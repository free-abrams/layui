<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends BaseModel
{
    public function setBalanceAttribute($value)
    {
        return $this->attributes['balance'] = (int)$value * 100;
    }
    public function getBalanceAttribute($value)
    {
        return (int)$value / 100;
    }
    public function setTotalGrandAttribute($value)
    {
        return $this->attributes['total_grand'] = (int)$value * 100;
    }
    public function getTotalGrandAttribute($value)
    {
        return (int)$value / 100;
    }

    // 一对多
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function memberLevel()
    {
        return $this->belongsTo(MemberLevel::class);
    }

    public function recordrecharge()
    {
        return $this->hasMany(RecordRecharge::class);
    }
}
