<?php


class UserCampaign extends Eloquent {	
	public $timestamps = false;
    protected $table = 'user_campaign';
	
	public function user()
	{
		return $this->hasMany('User');
	}
	public function campaign()
	{
		return $this->hasMany('Campaign');
	}
}

?>