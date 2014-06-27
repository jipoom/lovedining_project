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
		// Get all the blog posts
		//$posts = $this->post->orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		//return View::make('site/blog/index', compact('posts'));
		return View::make('site/introduction');
	}

	/**
	 * Returns blog posts in accordance with the selected catagory.
	 *
	 * @return View
	 */
	public function getCategory($category)
	{
		// Get all the blog posts
		$posts = $this->post->where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(10);
		$yetToPrint = true;
		$mode = null;
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode'));
	}
	
	
	public function getCategoryMode($category, $mode)
	{
		// Get all the blog posts
		if($mode == "date"){
			$posts = $this->post->where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(10);
		}
		else if ($mode == "reviewName"){
			$posts = $this->post->where('category_id', '=', $category)->orderBy('title', 'ASC')->paginate(10);
		}
		else if ($mode == "restaurantName"){
			$posts = $this->post->where('category_id', '=', $category)->orderBy('restaurant_name', 'ASC')->paginate(10);
		}
		else if ($mode == "popularity"){
			$posts = $this->post->where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(10);
		}
		
		
		// this is a parameter to check if we need to show sort menu
		$yetToPrint = true;
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode'));
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
			$postsUserRead->category_id = $post->category_id;
			$postsUserRead->save();
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
}
