<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointGoodsOrder extends BaseModel
{
    protected $fillable = [
    	'store_id',
    	'name',
    	'mobile',
    	'remark',
    	'point_goods_id',
    	'number',
    	'status'
    ];
}
