<?php

namespace App\Models;

use App\Model\GoodsToMaterail;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Route;

class Goods extends BaseModel
{
    protected $fillable = [
        'name',
        'images_url',
        'price',
        'stock',
        'sell',
        'sort',
        'goods_number',
        'status',
	    'store_id'
    ];
    // 封面图片获取器
    public function getImagesUrlAttribute($value)
    {
        return $value;
    }

    public function setImagesUrlAttribute($value)
    {
        $this->attributes['images_url'] = env('ALIOSS_HOST').'/'.$value;
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

    // 商品分类关联
    public function classify()
    {
        return $this->belongsToMany('App\Models\GoodsClassify', 'goods_to_classify');
    }
    
    // 关联商品类目
    public function getClassify()
    {
        return $this->belongsToMany(Classify::class, 'goods_bind_classifies', 'goods_id', 'classify_id');
    }

    // 关联
    public function setMeals()
    {
        return $this->belongsToMany('App\Models\SetMeal', 'set_meals_to_goods');
    }

    public function storage()
    {
        return $this->hasOne('App\Models\Storage');
    }

    public function goodsSku()
    {
        return $this->hasMany(GoodsSku::class);
    }

    public function goodstomaterial()
    {
        return $this->hasMany(GoodsToMaterial::class, 'goods_id');
    }

//    public function goodsToMaterial()
//    {
//        return $this->belongsToMany(Material::class, 'goods_to_materials');
//    }
}
