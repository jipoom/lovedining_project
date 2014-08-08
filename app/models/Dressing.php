<?php


class Dressing extends Eloquent {	
    protected $table = 'dressing';	
	public $timestamps = false;
	
	public function post()
	{
		return $this->belongsToMany('Post','posts_dressing');
	}
}

?>