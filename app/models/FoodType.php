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
	
	public static function getAllFoodTypeArray()
	{
		$foodType= array('0' => 'All');	
		$init_foodType = FoodType::first();
		$foodType = array_add($foodType,$init_foodType->id, $init_foodType->name);
		$allfoodType = FoodType::all();
		foreach($allfoodType as $temp)
		{
				
			$foodType = array_add($foodType, $temp->id, $temp->name);
		}
		return $foodType;
	}
}

?>