<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends BaseModel
{
    //获取楼层关联
    public function storeys()
    {

        return $this->morphMany(Storeys::class, 'storeystable');
    }

    //获取房型关联
    public function scale()
    {
        return $this->belongsTo(Scale::class);

    }

    public function storey()
    {
        return $this->belongsTo(Storeys::class);
    }

//    public function scale()
//    {
//        return $this->belongsTo(Scale::class);
//    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    // 房间订单一对多
    public function order()
    {
    	return $this->hasMany(Order::class);
    }

}
