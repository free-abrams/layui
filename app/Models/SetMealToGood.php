<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetMealToGood extends BaseModel
{
    //
    protected $table = "set_meals_to_goods";

    protected $fillable = [
        'set_meal_id',
        'goods_id',
        'number'
    ];

    public function setMeals()
    {
        return $this->belongsTo('App\Models\SetMeal', 'set_meal_id');
    }

    public function setMealToGoods()
    {
        return $this->morphTo();
    }
}
