<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storeys extends BaseModel
{
    protected $table = "storeys";


    public function storeystable()
    {
        return $this->morphTo();
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'store_id');
    }


    public function rooms()
    {
        return $this->hasOne(Room::class);
    }
}
