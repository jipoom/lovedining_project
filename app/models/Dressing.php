<?php


class Dressing extends Eloquent {	
    protected $table = 'dressing';	
	public $timestamps = false;
	
	public function post()
	{
		return $this->belongsToMany('Post','posts_dressing');
	}
	
	public static function getAllDressingArray()
	{
		$dressing = array('0' => 'All');	
		$init_dressing = Dressing::first();
		$dressing = array_add($dressing,$init_dressing->id, $init_dressing->name);
		$alldressing = Dressing::all();
		foreach($alldressing as $temp)
		{
				
			$dressing = array_add($dressing, $temp->id, $temp->name);
		}
		return $dressing;
	}
}

?>