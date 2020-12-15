<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsToMaterial extends BaseModel
{
	protected $fillable = [
		'stock_id',
		'material_id',
		'goods_id',
		'number'
	];
    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }
    
}
