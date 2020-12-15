<?php

namespace App\Api\Goods;

use App\Models\Goods;
use App\Models\GoodsSku;
use App\Models\Material;
use App\Models\RecordMaterial;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class GoodsController extends Controller
{
    public function goods($id)
    {
        $sku = GoodsSku::where('goods_id', $id)->get();
        $goods = Goods::with(['goodsSku:id,ids,attribute_string,goods_id,price,stock'])->find($id);
        
        return response([
        	'code' => 1,
	        'msg' => '查询成功',
	        'data' => $goods
        ]);
    }
    
    public function caches()
    {
    	$id = 9;
    	
    	if(Cache::has('goods_'.$id)){
    		foreach (unserialize(Cache::get('goods_'.$id)) as $v){
    		    print $v;
    		    dd(unserialize(Cache::get('goods_'.$id)));
		    }
    		return unserialize(Cache::get('goods_'.$id));
	    } else {
	        $sku = Goods::with(['goodsSku:id,ids,attribute_string,goods_id,price,stock'])->find($id);
	        Cache::add('goods_'.$id, serialize($sku), 60);
	        return $sku;
	    }
    }

    public function record()
    {
    	/*
    	 * |月份|进仓金额|出仓金额
    	 */
        $start = Carbon::now();
        $end = Carbon::now();
        $timeBetween = [$start->startOfYear(), $end->endOfyear()];

        $record = RecordMaterial::whereBetween('created_at', $timeBetween)
	                                ->with(['unitPrice:id,unit_price'])
                                    ->where(['style' => 1, 'type' => 1])
	                                ->get();
        
        $material_id = array_keys($record->groupBy('material_id')->toArray());
        
        $material = Material::whereIn('id', $material_id)->get(['id', 'name'])->pluck('name', 'id');
        
        // groupBy Month
	    $record->map(function ($item) {
	    	$time = New Carbon($item->created_at);
	    	$item->date = $time->format('m');
	    });
	    
	    foreach ($record->groupBy('date') as $k => $v)
	    {
	        static $price = [];
	        $v->map(function ($item) use (&$price, $k){
	            if(isset($price[$k])){
	                $price[$k] += $item->number * $item->unitPrice->unit_price;
	            } else{
	            	$price[$k] = $item->number * $item->unitPrice->unit_price;
	            }
	        });
	    }
	  
        foreach($record->groupBy('material_id') as $k => $v)
        {
            static $data = [];
            $v->map(function ($item) use (&$data, $k, $material) {
            	$data[$k]['name'] = $material[$k];
                 $data[$k]['price'] = $item->number * $item->unitPrice->unit_price;
                 $data[$k]['date'] = $item->date;
                 if(isset($data[$k])){
                    $data[$k]['price'] += $item->number * $item->unitPrice->unit_price;
                 }
            });
        }
        //dd( $record, collect($data)->groupBy('date'));
    }
}
