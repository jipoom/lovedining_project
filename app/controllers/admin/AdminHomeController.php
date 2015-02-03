<?php

class AdminHomeController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $post;

	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Post $post) {
		parent::__construct();
		$this -> post = $post;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {

		// Title
		$title = "Main page Management";
		$mode = HighlightOrder::getMode();
		$highlight = HighlightOrder::getOrder($mode);
	
		// Grab all the blog posts
		$posts = $this -> post;
		
		/*if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.banner')))
		{
			//Create new banner Directory
			mkdir(Config::get('app.image_path').'/'.Config::get('app.banner'));
		}*/
		// Show the page
		return View::make('admin/home/index', compact('posts', 'title','mode','highlight'));
	}
	
	public function highlightCustom() {

		// Title
		$title = "Customize LoveDining Highlight";		
		// Show the page
		return View::make('admin/home/custom_highlight', compact('title'));
	}
	
	public function setHome() {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator -> passes()) {
			
			//reset all to non-banner	
			//Post::where('is_home', '=', 1)->update(array('is_home' => 0));
			foreach(Input::get('setHome') as $banner)
			{
				
				//Set home to selected review
				$post = Post::find($banner);
				//If set home to anthoer review
				if($post->is_home == 0)
				{					
					$post->is_home = 1;
					$post->save();				
				}
				
			}
				return Redirect::to('admin/home/') -> with('success', Lang::get('admin/blogs/messages.create.success'));
		}
		//If set home to the old review
		else
		{
			return Redirect::to('admin/home/') -> with('success', Lang::get('admin/blogs/messages.create.success'));
		}
		
		// There was a problem deleting the blog post
		//return Redirect::to('admin/home') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	public function removeBanner($postId) {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

			
		//reset all to non-banner	
		Post::where('id', '=', $postId)->update(array('is_home' => 0));
		return Redirect::to('admin/home/') -> with('success', Post::find($postId)->title." has been removed from banner");
	
	}
	public function removeHighlight($postId) {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

			
		//reset all to non-banner	
		Post::where('id', '=', $postId)->update(array('is_highlight' => 0));
		return Redirect::to('admin/home/custom_highlight') -> with('success', Post::find($postId)->title." has been removed from highlight");
	
	}

	public function postHighlightCustom() {

		// Title
		$rules = array('setHighlight' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator -> passes()) {
			
			//reset all to non-banner	
			//Post::where('is_highlight', '=', 1)->update(array('is_highlight' => 0));
			$i = 0;	
			if(count(Post::where('is_highlight', '=', 1)->get()) + count(Input::get('setHighlight')) > 6)
			{
				foreach(Input::get('setHighlight') as $highlight)
				{
					
					//Set home to selected review
					$post = Post::find($highlight);
					if($post->is_highlight == 1)
					{					
						$post->is_highlight = 0;
						$post->save();	
						$i++;				
					}				
									
				}
				Post::whereNotIn('id', Input::get('setHighlight'))->take(count(Input::get('setHighlight')) - $i)->update(array('is_highlight' => 0));
				//Post::where('is_highlight', '=', 1)->take(count(Input::get('setHighlight')) - $i)->update(array('is_highlight' => 0));
			}
			$i = 0;	
			foreach(Input::get('setHighlight') as $highlight)
			{
				
				//Set home to selected review
				$post = Post::find($highlight);
				//If set home to anthoer review
				if($post->is_highlight == 0)
				{					
					$post->is_highlight = 1;
					$post->save();				
				}
				$i++;
				if($i==6){
					break;
				}
				
			}
			// Save Highlight Order
			//update Highlight Order
			$order = HighlightOrder::all();
			$user = Auth::user();
			if($order->count()>0)
			{
				foreach ($order as $orderMode) {
					$orderMode -> mode = "custom";
					$orderMode -> user_id = $user->id;
					if($orderMode -> save())
						break;
				}
			}
			else {
				$order = new HighlightOrder;
				$order-> mode = "custom";
				$order-> user_id = $user->id;
				$order->save();
				
			}
			
			return Redirect::to('admin/home/custom_highlight') -> with('success', "Success");
		}
		//If set home to the old review
		else
		{
			return Redirect::to('admin/home/custom_highlight') -> with('success', "Success");
		}
		
		// There was a problem deleting the blog post
		//return Redirect::to('admin/home') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	public function changeOrder($mode) {
		//Sort Category by mode
		$highlight = HighlightOrder::getOrder($mode);
		//$message = null;
		return View::make('admin/home/showhighlight', compact('highlight', 'mode'));
		

	}
	
	public function saveOrder($mode) {
		//Sort Category by mode
		$title = Lang::get('admin/category/title.order_management');
		
		//update Highlight Order
		$order = HighlightOrder::all();
		$user = Auth::user();
		if($order->count()>0)
		{
			foreach ($order as $orderMode) {
				$orderMode -> mode = $mode;
				$orderMode -> user_id = $user->id;
				if($orderMode -> save())
					return Redirect::to('admin')->with('success', Lang::get('admin/home/messages.change.success'));
			}
		}
		else {
			$order = new HighlightOrder;
			$order-> mode = $mode;
			$order-> user_id = $user->id;
			echo $mode;
			if($order->save())
				return Redirect::to('admin')->with('success', Lang::get('admin/home/messages.change.success'));
			
		}
		
		

	}

	public function getData() {

		//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$timestamp = time(); 
		$posts = Post::select(array('posts.id', 'posts.title as post_name', 'posts.id as comments', 'posts.created_at', 'posts.is_home')) 
		-> active();
		//-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
		//-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');

			
		
		return Datatables::of($posts) 
		
		-> edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}') 
		-> edit_column('comments', '<a href="{{{ URL::to(\'admin/comments/\'.$id.\'/view_comments\' ) }}}">{{$comments}}</a>') 
		-> edit_column('post_name', '<a href="{{{ URL::to(\'admin/blogs/\'. $id .\'/edit\') }}}">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')

		-> add_column('actions', '@if($is_home == 0){{Form::radio(\'setHome[]\', $id)}} @else {{Form::radio(\'setHome[]\', $id, true)}} @endif')  
        -> remove_column('id') -> make();

	}
		
	public function getCustomhighlight() {

		//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$timestamp = time(); 
		$posts = Post::select(array('posts.id', 'posts.title as post_name', 'posts.id as comments', 'posts.created_at', 'posts.is_highlight')) 
		-> active();
		//-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
		//-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');

			
		
		return Datatables::of($posts) 
		
		-> edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}') 
		-> edit_column('comments', '<a href="{{{ URL::to(\'admin/comments/\'.$id.\'/view_comments\' ) }}}">{{$comments}}</a>') 
		-> edit_column('post_name', '<a href="{{{ URL::to(\'admin/blogs/\'. $id .\'/edit\') }}}">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')

		-> add_column('actions', '@if($is_highlight == 0){{Form::radio(\'setHighlight[]\', $id)}} @else {{Form::radio(\'setHighlight[]\', $id, true)}} @endif')  
        -> remove_column('id') -> make();

	}

}
