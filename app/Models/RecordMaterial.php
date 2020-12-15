<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordMaterial extends BaseModel
{
    protected $fillable = [
        'purchase_to_material_id',
	    'store_id',
        'material_id',
        'number',
        'description',
        'style',
        'type'
    ];

    // 材料一对多关系
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    
    public function unitPrice()
    {
    	return $this->belongsTo(PurchaseToMaterial::class, 'purchase_to_material_id', 'id');
    }
}
