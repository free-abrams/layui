<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends BaseModel
{
    // 关联
	public function classify()
	{
		return $this->belongsTo(MaterialClassify::class, 'material_classify_id', 'id');
	}
	
	public function suppliers()
	{
		return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
	}
}
