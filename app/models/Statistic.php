<?php


class Statistic extends Eloquent {	
    protected $table = 'statistic';

	public static function keepStat($categoryId,$categoryName,$postId,$ip_addr)
	{		
		$stat = new Statistic;
		$stat->category_id = $categoryId;
		$stat->page_view = $categoryName;
		$stat->post_id = $postId;
		$stat->ip_address = $ip_addr;
		$stat->save();	
	}
}

?>