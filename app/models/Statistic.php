<?php


class Statistic extends Eloquent {	
    protected $table = 'statistic';

	//public static function keepStat($categoryId,$categoryName,$postId,$ip_addr)
	public static function keepStat($categoryId,$postId,$ip_addr)
	{		
		$stat = new Statistic;
		$stat->category_id = $categoryId;
		//$stat->page_view = $categoryName;
		$stat->post_id = $postId;
		$stat->ip_address = $ip_addr;
		$stat->save();	
	}
	public static function get4PopularReviews()
	{
		$popularId = array();	
		$i=0;			
		$posts = Post::active()->leftjoin('statistic', 'posts.id', '=', 'statistic.post_id')
                        ->select(DB::raw('posts.id as p_id, COUNT(*) AS total_posts'))
                        ->orderBy('total_posts', 'DESC')
                        ->groupBy('posts.id')
                        ->take(4)
                        ->get();
		foreach ($posts as $post)
		{
			$popularId[$i] = $post->p_id;
			$i++;
		} 
		return $popularId;
	}
	public static function getPopularCategories()
	{		
		$popularId = array();	
		$i=0;			
		$categories = Category::leftjoin('statistic', 'category.id', '=', 'statistic.category_id')
                        ->select(DB::raw('category.id as cat_id, COUNT(*) AS total_categories'))
                        ->orderBy('total_categories', 'DESC')
                        ->groupBy('category.id')
                        ->get();
		foreach ($categories as $category)
		{
			$popularId[$i] = $category->cat_id;
			$i++;
		} 
		return $popularId;
	}
}

?>