<?php


class FoodType extends Eloquent {	
    protected $table = 'food_type';	
	public $timestamps = false;
	
	public function post()
	{
		return $this->belongsToMany('Post','posts_food_type');
	}
	public function user()
	{
		return $this->belongsToMany('User','user_food_type');
	}
}

?>