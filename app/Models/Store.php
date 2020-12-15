<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends BaseModel
{
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    public function storeDetail()
    {
        return $this->hasOne(StoreDetail::class);
    }
}
