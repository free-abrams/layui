<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetMeal extends BaseModel
{
	protected $table = "set_meals";
	
	protected $fillable = [
		'type', 'name', 'describe', 'images_url',
		'package_price', 'status', 'current_price',
		'minimum_price', 'deposit_price', 'number_price'
	
	];
	
	public function scale()
	{
		return $this->belongsTo(Scale::class, 'scale_id');
	}
	
	public function setImagesUrlAttribute($value)
	{
		$this->attributes['images_url'] = env('ALIOSS_HOST') . '/' . $value;
	}
	
	public function getImagesUrlAttribute($value)
	{
		return $value . '?x-oss-process=image/resize,w_40';
	}
	
	// 时间日期获取器
	public function getStartTimeAttribute($value)
	{
		return $value = date('YYYY-MM-DD HH:mm:ss', $value);
	}
	
	public function getEndTimeAttribute($value)
	{
		return $value = date('YYYY-MM-DD HH:mm:ss', $value);
	}
	
	public function good()
	{
		return $this->hasMany(Goods::class, 'id');
	}
	
	public function goods()
	{
		return $this->hasMany('App\Models\SetMealToGood', 'set_meal_id');
	}
	
	//套餐多选商品加入中间表
	public function mealToGoods()
	{
		return $this->morphMany('App\Models\setMealToGood', 'setMealToGoods');
	}
	
	
	// 多对多关联
	public function patterns()
	{
		return $this->belongsToMany('App\Models\Pattern', 'patterns_to_set_meals');
	}
	
	public function getPriceAttribute($value)
	{
		return $value / 100;
	}
	public function getPackagePriceAttribute($value)
	{
		return $value / 100;
	}
	public function getCurrentPriceAttribute($value)
	{
		return $value / 100;
	}
	public function getMinimumPriceAttribute($value)
	{
		return $value / 100;
	}
	
	public function getDepositPriceAttribute($value)
	{
		return $value / 100;
	}
}
