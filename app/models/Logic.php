<?php


class Logic {	
		
	public static function preparePreselectedCheckBox($all,$allSelected)
	{
		$selectedArray = array();
		$i=0;
		foreach($all as $choice)
		{
		    $check=0;	
			foreach($allSelected as $selected)
			{
				if($selected->id == $choice->id)
				{
					$selectedArray[$i] = 1;
					$check = 1;
					break;
				}
			}
			if($check == 0)
			{
				$selectedArray[$i]=0;
			}
			$i++;
		}
		return $selectedArray;
	}
	
	public static function preparePreselectedSelect($allSelected)
	{
		$selectedArray = array();
		$i=0;
		foreach($allSelected as $selected)
		{
		   $selectedArray[$i] = $selected->id;
		   $i++;
		}
		return $selectedArray;
	}
}

?>