<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordOrder extends BaseModel
{
    // 关联 orders 表
	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
