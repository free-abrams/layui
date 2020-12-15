<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends BaseModel
{
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // 金额修改器 获取器
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setFullAttribute($value)
    {
        $this->attributes['full'] = $value * 100;
    }

    public function getFullAttribute($value)
    {
        return $value / 100;
    }

    // 时间修改器，获取器
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = strtotime($value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = strtotime($value);
    }

    public function getStartTimeAttribute($value)
    {
        return date('Y-m-d H:i', $value);
    }

    public function getEndTimeAttribute($value)
    {
        return date('Y-m-d H:i', $value);
    }
}
