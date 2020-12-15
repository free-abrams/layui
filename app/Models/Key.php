<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
	protected $hidden = ['deleted_at'];
	protected $primaryKey = 'id';
	protected $appends = ['classname', 'valueslist'];
	protected $table = 'keys';
    protected $fillable = [
    	'store_id',
        'title',
	    'sort'
    ];
    
    public function values()
    {
        return $this->belongsToMany(Value::class, 'keys_to_values', 'keys_id', 'values_id');
    }

    public function classify()
    {
        return $this->belongsToMany(Classify::class, 'classify_to_keys', 'keys_id', 'classify_id')->withTimestamps();
    }

    public function getClassnameAttribute()
    {
        if ($this->classify) {
            foreach ($this->classify as $key => $value) {
                return $value->title;
            }
        }
        return '';
    }

    public function getValueslistAttribute()
    {
        $name = '';
        if ($this->values) {
            foreach ($this->values as $key => $value) {
                $name = $name . ',' . $value->title;
            }
            $name = substr($name, 1);
        }
        return $name;
    }
}
