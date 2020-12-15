<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends BaseModel
{
    protected $fillable = [
        'company',
        'number',
        'province',
        'city',
        'county',
        'address',
        'lat',
        'lng',
        'name',
        'phone',
        'mobile',
        'description',
        'status'
    ];
}
