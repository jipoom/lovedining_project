<?php

class BlogController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param Post $post
     * @param User $user
     */
    public function __construct(Post $post, User $user)
    {
        parent::__construct();

        $this->post = $post;
        $this->user = $user;
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{

		//Keep stat
		//Statistic::keepStat(0,"Home",0,Request::getClientIp());
		
		//Clear Session
		Session::forget('mode');
		Session::forget('catName');
		$home = Post::where('isHome','=',1)->first();
		//$randReviews = Post::getRandomReviews();
		//$randReviews = Post::getRecentReviews();
		$banners = Picture::directoryToArray(Config::get('app.image_path').'/'.Config::get('app.banner'),true);
		return View::make('site/home',compact('home','banners'));
	}

	/**
	 * Returns blog posts in accordance with the selected catagory.
	 *
	 * @return View
	 */
	public function getCategory($categoryId)
	{
		
		// Get all the blog posts
		$catName = Category::find($categoryId);
		$mode = null;
		if (Session::has('mode') && Session::get('catName') == $catName->category_name){
			$mode = Session::get('mode');
			$posts = Post::orderReview($this->post,$mode,$categoryId,$catName);
		}
		else {
			Session::forget('mode');
			Session::forget('catName');
			$posts = Post::getReviewsbyCategory($this->post,$categoryId,'created_at','DESC');
			
		}
		
		//Keep stat
		//Statistic::keepStat($categoryId,$catName->category_name,0,Request::getClientIp());
		
		$yetToPrint = true;
		
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode','categoryId'));
	}
	
	
	public function getCategoryMode($categoryId, $mode,$keyword=null)
	{
		// Get all the blog posts
		if($categoryId!="undefined")
		{
			$catName = Category::find($categoryId);
			$posts = Post::orderReview($this->post,$mode,$categoryId,$catName->category_name);
			
		}
		else {
			
			$posts = Post::search($keyword,true);
			$posts = Post::orderReview($posts,$mode,$categoryId,"search");
			/*foreach($posts as $post)
			{
				echo $post;
			}*/
		}
		
		
		
		// this is a parameter to check if we need to show sort menu
		$yetToPrint = true;
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode','categoryId','keyword'));
	}
	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($postId)
	{
		// Get this blog post data
		$post = $this->post->where('id', '=', $postId)->first();
		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
	
		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'ASC')->get();

        // Get current user and check permission
        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) {
            $canComment = $user->can('post_comment');
        }
		//form phisical address
		$address = $post->street_addr.' '.$post->soi.' '.$post->road.' '.$post->subdistrict.' '.$post->district.' '.$post->province;
		
		//add to the PostsUserRead
		$postsUserRead = new PostsUserRead;
		
		//check if user is logged in and has not read this review yet.
		if(Auth::check() && !($postsUserRead->where('post_id','=', $postId)->where('user_id','=', Auth::user()->id)->exists()))
		{
			
			$postsUserRead->user_id = Auth::user()->id;
			$postsUserRead->post_id = $postId;
			//$postsUserRead->category_id = $post->category_id;
			$postsUserRead->save();
		}
		
		//Keep stat
		$categories = $post->find($postId)->category;
		foreach($categories as $category)
		{
			//Statistic::keepStat($category->id,$category->category_name,$postId,Request::getClientIp());
			Statistic::keepStat($category->id,$postId,Request::getClientIp());
		}
		
		// Show the page
		return View::make('site/blog/view_post', compact('post', 'comments', 'canComment', 'address'));
	}
	
	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($postId)
	{

        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($postId . '#comments')->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = $this->post->where('id', '=', $postId)->first();
		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($post->comments()->save($comment))
			{
				// Redirect to this blog post page
				return Redirect::to($postId . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog post page
			return Redirect::to($postId . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog post page
		return Redirect::to($postId)->withInput()->withErrors($validator);
	}
	public function searchReview($keyword)
	{
		$mode = null;
		$yetToPrint = false;
		$posts = Post::search($keyword,false);
		
        return View::make('site/blog/index', compact('posts','yetToPrint','mode','keyword'));
    
	}
	
	public function getAlbum($postId)
	{
		// Get all the blog posts
		$post = $this->post->where('id', '=', $postId)->first();
		$album = Picture::directoryToArray(Config::get('app.image_path').$post->album_name,true);
		$title = 'Test Album';
		// Show the page
		return View::make('site/blog/album', compact('album','title','post'));
	}
}
