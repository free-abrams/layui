<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class MemberLevel extends BaseModel
{
    protected $fillable=[
        'store_id',
        'name',
        'is_auto_upgrade',
        'is_opening',
        'amount',
        'give_amount',
        'discount',
        'description'
    ];

    // 所需充值金额修改器
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (int)$value * 100;
    }
    public function getAmountAttribute($value)
    {
        return (int)$value / 100;
    }

    public function setGiveAmountAttribute($value)
    {
        $this->attributes['give_amount'] = (int)$value * 100;
    }
    public function getGiveAmountAttribute($value)
    {
        return (int)$value / 100;
    }

    public function getDiscountAttribute($value)
    {
        if(Route::currentRouteName() !='member-levels.edit') {
            return $value."%";
        } else {
            return $value;
        }
    }

    // 一对多关联
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
