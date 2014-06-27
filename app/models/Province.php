<?php


class Province extends Eloquent {	
	public $timestamps = false;
    protected $table = 'province';
	
	public function post()
	{
		return $this->hasMany('Post');
	}
}

?>