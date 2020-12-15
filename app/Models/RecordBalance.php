<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordBalance extends BaseModel
{
    // 一对多关联
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    // 访问器
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function getBalanceAttribute($value)
    {
        return $value / 100;
    }
}
