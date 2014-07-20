<?php


class Age extends Eloquent {	
	public $timestamps = false;
    protected $table = 'age';
	public function user()
	{
		return $this->hasMany('User');
	}
	public static function getAllAgeArray()
	{
		$init_age = Age::first();
		$age = array($init_age->id => $init_age->description);
		$allAge = Age::all();
		foreach($allAge as $temp)
		{
				
			$age = array_add($age, $temp->id, $temp->description);
		}
		return $age;
	}

}

?>