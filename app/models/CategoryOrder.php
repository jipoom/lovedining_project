<?php


class CategoryOrder extends Eloquent {	
	public $timestamps = false;
    protected $table = 'category_order';
	public static function getOrder($mode)
	{
		if($mode == "name")			
			return Category::orderBy('category_name', 'ASC')->get();
		else if($mode == "numReviews")			
			/*return DB::select(DB::raw('SELECT count(posts.id) as counts,category_name,category.id
								FROM category
								LEFT JOIN posts
								ON category.id=posts.category_id
								group by category.id
								order by counts desc'));*/
			return DB::select(DB::raw('SELECT count(posts_category.post_id) as counts,category_name,category.id
								FROM category
								LEFT JOIN posts_category
								ON category.id=posts_category.category_id
								group by category.id
								order by counts desc'));
		else if($mode == "popularity")		
			return Category::all();
	}
	public static function getMode()
	{
		$order = CategoryOrder::all();	
		$mode = null;
		foreach ($order as $orderMode) {
			$mode = $orderMode -> mode;
		}
		return $mode;
	}
}

?>