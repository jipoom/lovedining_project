<?php


class Tumbol extends Eloquent {	
	public $timestamps = false;
    protected $table = 'tumbol';
	
	public function amphur()
	{
		return $this->belongsTo('amphur','amphur_id');
	}
	public function province()
	{
		return $this->belongsTo('province','province_id');
	}
	public function geo()
	{
		return $this->belongsTo('geography','geo_id');
	}
}

?>