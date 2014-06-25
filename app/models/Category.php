<?php


class Category extends Eloquent {	
	public $timestamps = false;
    protected $table = 'category';
	
	public function post()
	{
		return $this->hasMany('Post');
	}
}

?>