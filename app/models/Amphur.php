<?php


class Amphur extends Eloquent {	
	public $timestamps = false;
    protected $table = 'amphur';
	
	public function tumbol()
	{
		return $this->hasMany('Tumbol');
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