<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StoreDetail extends BaseModel
{
    protected $fillable = [
        'name', 'logo_url' , 'mobile', 'province', 'city',
        'county', 'address', 'business_time_start', 'business_time_end',
        'details', 'status', 'sn', 'merchant_id'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function setLogoUrlAttribute($value)
    {
    	$this->attributes['logo_url'] = env('ALIOSS_HOST').'/'.$value;
    }

    public function getBusinessTimeStartAttribute($value)
    {
        if (!empty($value)){
            return $this->attributes['business_time_start'] = date('H:ii:ss', $value);

        }
    }

    public function getBusinessTimeEndAttribute($value)
    {
        if (!empty($value)){
            return $this->attributes['business_time_end'] = date('H:ii:ss', $value);

        }
    }
}
