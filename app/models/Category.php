<?php


class Category extends Eloquent {	
	public $timestamps = false;
    protected $table = 'category';
	
	public function post()
	{
		return $this->belongsToMany('Posts','posts_category');
	}
	public function statistic()
	{
		return $this->belongsToMany('Posts','statistic');
	}
}

?>