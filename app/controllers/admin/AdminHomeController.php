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
		
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.banner')))
		{
			//Create new banner Directory
			mkdir(Config::get('app.image_path').'/'.Config::get('app.banner'));
		}
		// Show the page
		return View::make('admin/home/index', compact('posts', 'title','mode','highlight'));
	}
	
	public function setHome() {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		// Check if the form validates with success
		if ($validator -> passes()) {
			//Set home to selected review
			$post = Post::find(Input::get('setHome'));
			//If set home to anthoer review
			if($post->isHome == 0)
			{
				Post::where('isHome', '=', 1)->update(array('isHome' => 0));
				$post->isHome = 1;
				if($post->save()){
					
					//trigger elfinder to enable admin to upload images
					return Redirect::to('admin/home/') -> with('success', Lang::get('admin/blogs/messages.create.success'));
				}
			}
		}
		//If set home to the old review
		else
		{
				//no update
			//trigger elfinder to allow enable to upload images but does not remove Banner directory
			return Redirect::to('admin/home/') -> with('success', Lang::get('admin/blogs/messages.create.success'));
		}
		
		// There was a problem deleting the blog post
		return Redirect::to('admin/home') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
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
		$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at', 'posts.isHome')) 
		-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
		-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');
			
		
		return Datatables::of($posts) 
		-> edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}') 
		-> edit_column('comments', '<a href="{{{ URL::to(\'admin/comments/\'.$id.\'/view_comments\' ) }}}">{{$comments}}</a>') 
		-> edit_column('title', '{{{ Str::limit($title, 40, \'...\') }}}')
		-> add_column('actions', '{{Form::radio(\'setHome\', $id)}}')  
        -> remove_column('id') -> make();

	}

}
