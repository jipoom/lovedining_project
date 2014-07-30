<?php


class PostsCategory extends Eloquent {	
	public $timestamps = false;
    protected $table = 'posts_category';
	
	public function post()
	{
		return $this->hasMany('Post');
	}
	public function category()
	{
		return $this->hasMany('Category');
	}
}

?>