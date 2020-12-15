<?php

namespace App\Models;

use App\Models\BaseModel;

class Classify extends BaseModel
{
    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'title',        #@标题
        'description',  #@描述
        'sort',         #@排序（同级有效）
    ];
    
    public function keys()
    {
        return $this->belongsToMany(Key::class, 'classify_to_keys', 'classify_id', 'keys_id')->withTimestamps();
    }
}
