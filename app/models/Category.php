<?php

class Category extends Eloquent {	
	public $timestamps = false;
    protected $table = 'category';
	protected $hidden = array('password', 'remember_token');
}

?>