<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends BaseModel
{

    // 材料多对多
    public function materials()
    {
        return $this->belongsToMany('App\Models\Material', 'purchase_to_materials',
        'purchase_id', 'material_id');
    }

    // 采购中间表 一对多
    public function purchasetomaterial()
    {
        return $this->hasMany(PurchaseToMaterial::class, 'purchase_id');
    }

    /**
     * 价格修改器
     * 价格获取器
     */
    public function setTotalPriceAttribute($value)
    {
        return $this->attributes['total_price'] = $value * 100;
    }

    public function getTotalPriceAttribute($value)
    {
        return $value = $value / 100;
    }

    public function setOtherPriceAttribute($value)
    {
        return $this->attributes['other_price'] = $value * 100;
    }

    public function getOtherPriceAttribute($value)
    {
        return $value = $value / 100;
    }

    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = $value * 100;
    }

    public function getPriceAttribute($value)
    {
        return $value = $value / 100;
    }

}
