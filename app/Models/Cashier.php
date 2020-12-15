<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Cashier extends BaseModel
{
    protected $fillable = [
        'store_id',
        'name',
        'number',
        'mobile',
        'username',
        'password',
        'status',
        'turnover',
        'grand_total',
        'cash_total'
    ];
}
