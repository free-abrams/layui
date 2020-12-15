<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends BaseModel
{
    protected $table = "patterns";

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function setMeals()
    {
        return $this->belongsToMany('App\Models\SetMeal', 'patterns_to_set_meals');
    }
}
