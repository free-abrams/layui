<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class GoodsClassify extends BaseModel
{
    protected $table = 'goods_classify';

    protected $fillable = [
        'Title',
        'Description',
        'Sort',
	    'store_id'
        ];

    // 关联商品
    public function goods()
    {
        return $this->belongsToMany('App\Models\Goods','goods_to_classify');
    }
    
    public function keys()
    {
        return $this->belongsToMany(Key::class, 'classify_to_keys', 'classify_id', 'keys_id')->withTimestamps();
    }
}
