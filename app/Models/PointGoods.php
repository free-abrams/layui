<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class PointGoods extends BaseModel
{
    protected $fillable = [
        'name',
        'store_id',
        'images_url',
        'price',
        'stock',
        'sell',
        'sort',
        'goods_number',
        'status'
    ];
    // 封面图片获取器
    public function getImagesUrlAttribute($value)
    {
    	if(Route::currentRouteName() === 'point-goods.index') {
    	    return $value = $value.'?x-oss-process=image/resize,w_30';
	    }
    	return $value;
    }
    
    public function setImagesUrlAttribute($value)
    {
        return  $this->attributes['images_url'] = env('ALIOSS_HOST').'/'.$value;
    }

    //单价修改器
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    // 单价访问器
    public function getPriceAttribute($value)
    {
        return $value = $value/100;
    }
    
    public function setGoodNumberAttribute($value)
    {
        $this->attributes['goods_number'] = 'POINTGOODS'. $value;
    }
    
    public function store()
    {
    	return $this->belongsTo(Store::class);
    }
}
