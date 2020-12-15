<?php

namespace App\Models;

use App\Admin\Handers\MaterialHander;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecordMaterial;
use Illuminate\Support\Facades\DB;

class PurchaseToMaterial extends BaseModel
{
    protected $fillable = [
        'purchase_id',
        'material_id',
        'supplier_id',
        'number',
        'unit_price',
        'description',
        'expiration_date',
        'manufacture_date',
        'stock',
        'sell',
        'status'
    ];

    public function recordmaterial()
    {
        return $this->hasOne(RecordMaterial::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    // 价格修改器，获取器
    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value * 100;
    }

    public function getUnitPriceAttribute($value)
    {
        return $value / 100;
    }
    
    // 获取各种材料库存 sum
    public static function getMaterialsStock($materials_ids = [])
    {
					// 搜索各种材料库存
					$stock = PurchaseToMaterial::whereIn('material_id', $materials_ids)
						->whereHas('purchase', function (Builder $query) {
							$query->where('store_id', Admin::user()->store_id)
								->where('status', 2);
						})->where('stock', '>', 0)
						->where('status', '1')
						->groupBy('material_id')
						->selectRaw('sum(stock) as stock, material_id')
						->get();
		return $stock;
    }
    // 获取材料最新单价
    public static function getMaterialsPrice($materials_ids = [])
    {
    	// 搜索各种材料单价
	    foreach ($materials_ids as $v) {
						$initPrice[] = PurchaseToMaterial::where('material_id', $v)
							->whereHas('purchase', function (Builder $query) {
								$query->where('store_id', Admin::user()->store_id);
							})->orderBy('created_at', 'desc')
							->first(['unit_price', 'material_id']);
	    }
					
		return collect($initPrice);
    }
    
    public static function getPurchases($materials_ids = [], $sortByDesc = false)
    {
				$materials = PurchaseToMaterial::whereHas('purchase',function (Builder $query) {
					            $query->where('store_id', Admin::user()->store_id)
						            ->where('status', 2);
					        })->whereIn('material_id', $materials_ids)
						        ->where('status', 1)
							->orderBy('material_id')
							->get();
				
				if($sortByDesc){
					$stock = $materials->groupBy('material_id')->map(function ($item) {
		                $item->sortByDesc('created_at');
		                return $item[0];
		            })->toArray();
				} else{
					$stock = $materials->groupBy('material_id')->toArray();
				}
				
				return $stock;
    }
    
    // 批量更新
    public static function updateBatch($tableName = "", $multipleData = array())
    {
        if( $tableName && !empty($multipleData) ) {
 
            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";
 
            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";
 
                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";
 
            // Update
            return DB::update(DB::raw($q));
 
        } else {
            return false;
        }
 
    }
}
