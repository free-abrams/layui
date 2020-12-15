<?php

namespace App\Models;

use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class MaterialClassify extends BaseModel
{
	use ModelTree;
    protected $table = 'material_classify';
    protected $primaryKey = 'id';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('title');
    }
    
    // 材料一对一
    public function materials()
    {
        return $this->belongsTo('App\Models\Material', 'material_classify_id', 'id');
    }
    
}
