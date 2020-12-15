<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordGoods extends BaseModel
{
    protected $fillable = [
        'goods_id',
        'goods_sku_id',
        'number',
        'description',
        'style',
        'type'
    ];

    // 一对多关联
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
