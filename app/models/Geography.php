<?php


class Geographhy extends Eloquent {	
	public $timestamps = false;
    protected $table = 'geography';
	
	public function amphur()
	{
		return $this->hasMany('Amphur');
	}
	public function tumbol()
	{
		return $this->hasMany('Tumbol');
	}
	public function province()
	{
		return $this->hasMany('Province');
	}
}

?>