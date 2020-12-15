<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordStorage extends BaseModel
{
    public function goods()
    {
        return $this->belongsTo('App\Models\Goods');
    }
}
