<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderToGoods extends BaseModel
{
    public function goods()
    {
    	return $this->belongsTo(Goods::class);
    }
}
