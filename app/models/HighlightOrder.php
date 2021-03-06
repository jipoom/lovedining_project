<?php


class HighlightOrder extends Eloquent {	
	public $timestamps = false;
    protected $table = 'highlight_order';
	public static function getOrder($mode)
	{
		if($mode == "recent")			
			return Post::orderBy('created_at', 'DESC')->active()->take(6)->get();
		else if($mode == "random")			
		{
			return Post::orderByRaw("RAND()")->active()->take(6)->get();
		}
		else if($mode == "popular")	
		{
			$popularIds = Statistic::get6PopularReviews();
			$posts = array();
			$i=0;
			foreach ($popularIds as $popularId)
			{
				$posts[$i] = Post::find($popularId);
				$i++;
			}		
			return $posts;
		}
		else if($mode == "custom")	
		{
			return Post::where('is_highlight','=','1')->active()->orderBy('rank')->get();
		}
	}
	public static function getMode()
	{
		/*$order = HighlightOrder::all();	
		$mode = null;
		foreach ($order as $orderMode) {
			$mode = $orderMode -> mode;
		}
		return $mode;*/
		return HighlightOrder::first()->mode;	
	} 
}

?>