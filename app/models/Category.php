<?php


class Category extends Eloquent {	
	public $timestamps = false;
    protected $table = 'category';
	
	public function post()
	{
		return $this->belongsToMany('Posts','posts_category');
	}
	public function statistic()
	{
		return $this->belongsToMany('Posts','statistic');
	}
	
	public static function getAllCategoryArray()
	{
		$category= array('0' => 'All');	
		$init_category = Category::first();
		$category = array_add($category,$init_category->id, $init_category->category_name);
		$allcategory = Category::all();
		foreach($allcategory as $temp)
		{
				
			$category = array_add($category, $temp->id, $temp->category_name);
		}
		return $category;
	}
}

?>