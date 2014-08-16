<?php


class Province extends Eloquent {	
	public $timestamps = false;
    protected $table = 'province';
	
	public function amphur()
	{
		return $this->hasMany('Amphur');
	}
	public function post()
	{
		return $this->hasMany('Post');
	}
	public function tumbol()
	{
		return $this->hasMany('Tumbol');
	}
	public function geo()
	{
		return $this->belongsTo('Geography');
	}
	public static function getAllProvinceArray()
	{
		$init_province= Province::where('province_name','=','กรุงเทพมหานคร')->first();
		$province= array($init_province->id => $init_province->province_name);	
		$allProvince = Province::orderBy('province_name')->get();
		foreach($allProvince as $temp)
		{
				
			$province = array_add($province, $temp->id, $temp->province_name);
		}
		return $province;
	}
}

?>