<?php


class Income extends Eloquent {	
	public $timestamps = false;
    protected $table = 'income';
	
	public function user()
	{
		return $this->hasMany('User');
	}
	
	public static function getAllIncomeArray()
	{
		$init_income = Income::first();
		$income = array($init_income->id => $init_income->description);
		$allIncome = Income::all();
		foreach($allIncome as $temp)
		{
				
			$income = array_add($income, $temp->id, $temp->description);
		}
		return $income;
	}
}

?>