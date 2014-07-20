<?php


class Sex extends Eloquent {	
	public $timestamps = false;
    protected $table = 'sex';
	public function user()
	{
		return $this->hasMany('User');
	}
	public static function getAllSexArray()
	{
		$init_sex = Sex::first();
		$sex = array($init_sex->id => $init_sex->description);
		$allsex = Sex::all();
		foreach($allsex as $temp)
		{
				
			$sex = array_add($sex, $temp->id, $temp->description);
		}
		return $sex;
	}

}

?>