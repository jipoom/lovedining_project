<?php


class Meal extends Eloquent {	
    protected $table = 'meal';	
	public $timestamps = false;
	
	public function post()
	{
		return $this->belongsToMany('Post','posts_meal');
	}
	
	
	public static function getAllMealArray()
	{
		$meal = array('0' => 'All');	
		$init_meal = Meal::first();
		$meal = array_add($meal,$init_meal->id, $init_meal->name);
		$allmeal = Meal::all();
		foreach($allmeal as $temp)
		{
				
			$meal = array_add($meal, $temp->id, $temp->name);
		}
		return $meal;
	}
	
}

?>