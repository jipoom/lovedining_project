<?php

class AdminStatController extends AdminController {


    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = "LoveDining Statistic";
		
        // Grab all the Statistics
        $stat = Statistic::all();
        // Show the page
        return View::make('admin/stat/index', compact('stat', 'title'));
    }
	
	public function getPageData() {
		//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$stat = Statistic::select(array('statistic.id', 'statistic.created_at','category.category_name', 'statistic.ip_address'))
		->join('category','statistic.category_id','=','category.id'); 
		

		return Datatables::of($stat) 
		-> add_column('actions','<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>') 
        -> remove_column('id') -> make();

	}
		
	public function getReviewData() {
			//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$stat = Statistic::select(array('statistic.id', 'statistic.created_at', 'posts.title', 'statistic.ip_address'))
		->join('posts','posts.id','=','statistic.post_id'); 
	

		return Datatables::of($stat) 
			-> add_column('actions','<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>')
        -> remove_column('id') -> make();

	}
	
	public function getPageCountData() {
			//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$stat = Statistic::select(array('statistic.id', 'statistic.category_id','category.category_name', 'statistic.ip_address as access','statistic.created_at')) 
		->join('category','category.id','=','statistic.category_id')->groupBy('category_name'); 

		return Datatables::of($stat) 
		-> edit_column('created_at','{{ DB::table(\'statistic\')->where(\'category_id\', \'=\', $category_id)->orderBy(\'created_at\',\'DESC\')->first()->created_at }}')
		-> edit_column('access','{{ DB::table(\'statistic\')->where(\'category_id\', \'=\', $category_id)->count() }}')
		-> remove_column('id') 
		-> remove_column('category_id') 
		-> make();

	}
	
	public function getReviewCountData() {
			//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$stat = Statistic::select(array('statistic.id','statistic.post_id','posts.title', 'statistic.ip_address as access', 'statistic.created_at'))
		->join('posts','posts.id','=','statistic.post_id')->groupBy('title'); 
	

		return Datatables::of($stat) 
		-> edit_column('created_at','{{ DB::table(\'statistic\')->where(\'post_id\', \'=\', $post_id)->orderBy(\'created_at\',\'DESC\')->first()->created_at }}')
		-> edit_column('access','{{ DB::table(\'statistic\')->where(\'post_id\', \'=\', $post_id)->count() }}')
        -> remove_column('id') 
		-> remove_column('post_id') 
        -> make();

	}


}