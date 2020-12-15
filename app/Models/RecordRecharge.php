<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordRecharge extends BaseModel
{
    // 一对多关联
    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // 获取器
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }
}
