<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends BaseModel
{
    public function goods()
    {
        return $this->belongsTo('App\Models\Goods');
    }
}
