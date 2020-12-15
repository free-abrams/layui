<?php

namespace App\Models;

use App\Admin\Handers\MaterialHander;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GoodsSkuToMaterial extends BaseModel
{
	protected $fillable = [
		'goods_sku_id',
		'material_id',
		'number'
	];
	
	public function material()
	{
		return $this->belongsTo(Material::class);
	}
	
	// 检测材料库存是否支持设置sku库存
	// $needs = [
	//  material_id => need
	//];
	public static function mini_stock($stock = [], $needs = [])
	{
		//dd($stock, $needs);
		//$mini=[];
		
		foreach ($stock as $k => $v) {
			if ($v['stock'] <= $needs[$v['material_id']]) {
				return false;
			};
		}
		return true;
//        if(is_array($stock) && is_array($need)){
//            foreach ($stock as $key => $value){
//                $mini[]=intval($value/$need[$key]);
//            }
//        }
//        if(count($mini) > 0){
//            return min($mini);
//        }
//        return false;
	}
	
	/*
	 * 绑定材料sku的最低可设置价格
	 * @return int
	 */
	public static function limitPrice($unit_prices = [], $materials_needs = [], $sharePercent = 0, $goodsSku = 0)
	{
		// 单价 * 设置数量 * (1 + 抽成百分比)
		foreach ($unit_prices as $k => $v) {
			$limitPrice[] = $v[0]['unit_price'] * $materials_needs[$k] * (1 + $sharePercent / 100);
			//dd($v[0]['unit_price'], $materials_needs[$k], (1 + $sharePercent / 100), $limitPrice);
		}

		$limitPrice = collect($limitPrice)->sum();
		if($limitPrice > $goodsSku->price){
			$goodsSku->price = $limitPrice * 100;
			$goodsSku->save();
			return $msg = '更新成功,当前属性设置售出价过低, 已经强制设置为￥'.$limitPrice;
		}
		
		return true;
	}
	
	// 减少库存 生成记录
	public static function reduce($stock = [], $needs = [])
	{
		foreach ($needs as $k => $v) {
			$reduceStock = MaterialHander::deduction_stock($stock[$k], $v);
			
			foreach ($reduceStock as $key => $value) {
				// 减少库存
				static $pToMaterial = [];
				$pToMaterial[] = [
					'id' => $value['id'],
					'stock' => $value['stock'],
					'sell' => $value['sell'],
					'status' => $value['status']
				];
				// 生成消耗记录
				static $record = [];
				$record[] = [
					'store_id' => Admin::user()->store_id,
					'purchase_to_material_id' => $value['id'],
					'material_id' => $k,
					'number' => $v,
					'description' => '生成sku',
					'style' => 2,
					'type' => 2,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				];
			}
		}
		// 批量更新
		PurchaseToMaterial::updateBatch('purchase_to_materials', $pToMaterial);
		// 批量插入
		DB::table('record_materials')->insert($record);
	}
}
