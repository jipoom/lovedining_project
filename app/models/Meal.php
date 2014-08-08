<?php


class Meal extends Eloquent {	
    protected $table = 'meal';	
	public $timestamps = false;
	
	public function post()
	{
		return $this->belongsToMany('Post','posts_meal');
	}
}

?>