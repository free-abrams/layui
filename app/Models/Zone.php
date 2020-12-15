<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends BaseModel
{
    public function get_city($id)
    {
        $this->model = new Zone();
        $city =  $this->model->where(['parent_id'=>$id])->select('id,city_name,short_name');
        return $city;
    }

}
