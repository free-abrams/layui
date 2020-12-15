<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
	protected $hidden = ['deleted_at'];
	protected $primaryKey = 'id';
	protected $table = 'values';
    protected $fillable = [
    	'store_id',
    	'title',
    	'sort'
    ];
    
    public function keys()
    {
        return $this->belongsToMany(key::class, 'keys_to_values', 'values_id', 'keys_id');
    }
}
