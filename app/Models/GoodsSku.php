<?php

namespace App\Models;

use Encore\Admin\Facades\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GoodsSku extends BaseModel
{
	protected $table = 'goods_sku';
	
	protected $fillable = [
		'goods_id',
		'ids',
		'attribute_string',
		'stock',
		'price',
		'original_price',
		'cost',
		'unit'
	];
	
	private $needs = [];
	
	public function goods()
	{
		return $this->belongsTo(Goods::class);
	}
	
	public function material()
	{
		return $this->hasMany(GoodsSkuToMaterial::class);
	}
	
	public function materials()
	{
		return $this->belongsToMany(Material::class, 'goods_sku_to_materials')->withPivot('number');
	}
	
	
	public function getIdsAttribute($value)
	{
		return json_decode($value, true);
	}
	
	public function getPriceAttribute($value)
	{
		return $value / 100;
	}
	
	public function getOriginalPriceAttribute($value)
	{
		return $value / 100;
	}
	
	public function getCostAttribute($value)
	{
		return $value / 100;
	}
	
	public function getUnitAttribute($value)
	{
		return empty($value) ? '无' : $value;
	}
	
	// 更新时检查sku设置，检查库存，检查单价设置
	public static function checkSkuMaterials($goodsSku, $ids, $inputStock, $inputPrice)
	{
		$res = true;
		// 检查 sku 删除没有设置的sku
		$goodsSku->map(function ($item) use ($ids, $inputPrice) {
			if (!in_array(json_encode($item->ids), $ids)) {
				$item->forceDelete();
			}
			$item->price = $inputPrice[json_encode($item->ids)];
		});
		foreach ($goodsSku as $k => $v) {
			// 检查库存
			// 材料需求数量 ['material_id' => need]
			$needs = [];
			
			//dd($v->materials);
			foreach ($v->materials as $key => $value) {
				if ($v->stock < $inputStock[json_encode($v->ids)]) {
					// 增加了库存
					$need = $inputStock[json_encode($v->ids)] - $v->stock;
					$needs[$value->pivot->material_id] = $value->pivot->number * $need;
				}
				if ($v->stock > $inputStock[json_encode($v->ids)]) {
					// 减少了库存
				} else {
					// 没有修改
					$needs[$value->pivot->material_id] = $value->pivot->number;
				}
			}
			$stock = PurchaseToMaterial::getMaterialsStock(array_keys($needs));
			$res = GoodsSku::checkStock($stock, $needs);
			
			if ($res !== true) {
				return $res;
			}
			
			// 检查单价设置
			$detail = StoreDetail::where('store_id', Admin::user()->store_id)->first();
			$initPrice = PurchaseToMaterial::getMaterialsPrice(array_keys($needs));
			$unit_price = $initPrice->groupBy('material_id')->toArray();
			
			$res = GoodsSkuToMaterial::limitPrice($unit_price, $needs, $detail->sharing_percent, $v);
			
			if ($res !== true) {
				return $res;
			}
		}
		
		return $res;
	}
	
	// return bool|string
	public static function checkStock($stock, $needs)
	{
		if (count($stock) < 0) {
			return $msg = '有材料库存不足';
		}
		
		$res = $stock->map(function ($item) use ($needs) {
			//dd($item->stock , $needs[$item->material_id]);
			//dd((int)$item->stock, (int)$needs[$item->material_id], (int)$item->stock < (int)$needs[$item->material_id]);
			if ((int)$item->stock < (int)$needs[$item->material_id]) {
				return false;
			} else {
				return true;
			}
		});
		
		if (in_array(false, $res->toArray())) {
			return $msg = '有材料库存不足';
		}
		return true;
	}
	
	// 返回库存
	public static function returnStock($sku)
	{
		// returns =['material_id' => number]
		$returns = self::skuToNeeds($sku);
		// 查找材料的采购批次
		$pur = PurchaseToMaterial::getPurchases(array_keys($returns), true);
		// 加回库存
		foreach ($pur as $k => $v) {
			static $data = [];
			$pur[$k]['stock'] += $returns[$k];
			$data[] = [
				'id' => $pur[$k]['id'],
				'stock' => $pur[$k]['stock'],
				'updated_at' => Carbon::now()
			];
			
			// 生成消耗记录
			static $record = [];
			$record[] = [
				'store_id' => Admin::user()->store_id,
				'purchase_to_material_id' => $v['id'],
				'material_id' => $k,
				'number' => $returns[$k],
				'description' => '重置sku时返回库存',
				'style' => 2,
				'type' => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];
		}
		// 批量保存
		PurchaseToMaterial::updateBatch('purchase_to_materials', $data);
		// 生成记录
		DB::table('record_materials')->insert($record);
	}
	
	// 材料生成sku库存
	/*
	 * $needs = [
	 *  'material_id' => need|int
	 * ];
	 *
	*/
	public static function createStock($sku)
	{
		$needs = self::skuToNeeds($sku);
		
		$stock = PurchaseToMaterial::getPurchases(array_keys($needs));
		GoodsSkuToMaterial::reduce($stock, $needs);
		
		return true;
	}
	
	// 检查最低可设置售价
	public static function checkIniPrice($sku)
	{
		$needs = [];
		$sku->map(function ($items) use (&$needs) {
			
			$temp = $items->material->map(function ($item) use (&$needs) {
				if (isset($needs[$item->material_id])) {
					$needs[$item->material_id] += $item->number;
				} else {
					$needs[$item->material_id] = $item->number;
				}
			});
		});
		
		$initPrice = PurchaseToMaterial::getMaterialsPrice(array_keys($needs));
		$unit_price = $initPrice->groupBy('material_id')->toArray();
		
		// 检测sku价格是否设置正确
		$detail = StoreDetail::find(Admin::user()->store_id);
		
		$limitSkuPrice = GoodsSkuToMaterial::limitPrice($unit_price, $needs, $detail->sharing_percent, $sku[0]);
		
		if ($limitSkuPrice !== true) {
			return $limitSkuPrice;
		}
		
		return true;
	}
	
	// 私有公用处理sku方法
	protected static function skuToNeeds($sku)
	{
		$returns = [];
		// dd($sku);
		$sku->map(function ($items) use (&$returns) {
			$stock = $items->stock;
			$temp = $items->material->map(function ($item) use ($stock, &$returns) {
				if (isset($returns[$item->material_id])) {
					$returns[$item->material_id] += $item->number * $stock;
				} else {
					$returns[$item->material_id] = $item->number * $stock;
				}
			});
		});
		
		return $returns;
	}
	
	// 检查是否修改了原材料
	public static function checkMaterial($sku, $needs)
	{
		if (count($sku->materials) == count($needs)) {
			foreach ($sku->materials as $k => $v) {
				if (!isset($needs[$v->pivot->material_id]) || $needs[$v->pivot->material_id] != $v->pivot->number) {
					return true;
				}
			}
			return false;
		} else {
			return true;
		}
	}
}
