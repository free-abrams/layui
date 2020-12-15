<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordPay extends BaseModel
{
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }
}
