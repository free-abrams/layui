<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends BaseModel
{
    protected $table = 'configs';

    protected $fillable = [
        'store_id',
        'name',
        'value',
        'describe',
    ];
}
