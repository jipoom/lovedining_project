<?php


class HighlightOrder extends Eloquent {	
	public $timestamps = false;
    protected $table = 'highlight_order';
	public static function getOrder($mode)
	{
		if($mode == "recent")			
			return Post::orderBy('created_at', 'DESC')->take(4)->get();
		else if($mode == "random")			
		{
			return Post::orderByRaw("RAND()")->take(4)->get();
		}
		else if($mode == "popular")		
			return Post::orderBy('created_at', 'DESC')->take(4)->get();
	}
	public static function getMode()
	{
		$order = HighlightOrder::all();	
		$mode = null;
		foreach ($order as $orderMode) {
			$mode = $orderMode -> mode;
		}
		return $mode;
	}
}

?>