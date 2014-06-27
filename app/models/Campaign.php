<?php


class Campaign extends Eloquent {	
	public $timestamps = false;
    protected $table = 'campaign';
	
	public function post()
	{
		return $this->hasMany('Post');
	}
}

?>