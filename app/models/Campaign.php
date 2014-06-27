<?php


class Campaign extends Eloquent {	
    protected $table = 'campaign';
	
	public function post()
	{
		return $this->belongsTo('Post','post_id');
	}
	
}

?>