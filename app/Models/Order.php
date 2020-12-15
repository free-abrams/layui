<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
	// 管理中间表
	public  function ordertogoods()
	{
		return $this->hasMany(OrderToGoods::class);
	}
	public function businesstime()
    {
        return $this->belongsTo(BusinessTime::class, 'business_time_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
	// 订单房间多对一
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function setmeal()
    {
        return $this->belongsTo(SetMeal::class);
    }

    // 访问器
    public function getTimeAttribute($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }
    public function getReceivePriceAttribute($value)
    {
        return $value / 100;
    }
    public function getUncollectedPriceAttribute($value)
    {
        return $value / 100;
    }
}
