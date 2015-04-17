<?php
use Illuminate\Support\Facades\URL;

class Campaign extends Eloquent {	
    protected $table = 'campaign';
	
	public function post()
	{
		return $this->belongsTo('Post','post_id');
	}
	
	public function url()
	{
		return Url::to("campaign/".$this->id."/".Session::get('Lang'));
	}
	
	public function scopeActive($query)
    {
      
	    return $query-> whereRaw('(UNIX_TIMESTAMP(expiry_date) >= UNIX_TIMESTAMP(now()) and isActive = 1)');
    }
	
}

?>