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
	
	public function changeLang($lang,$page=null)
	{
		Session::put('Lang',$lang);

		if($page == "campaign")
		{
			$goto = Session::get('Campaign');
			Session::forget('Campaign');
			return Redirect::to(URL::to('campaign')."/".$goto."/".$lang);
		}
		else if($page == "post")
		{
			$goto = Session::get('View');
			Session::forget('View');
			return Redirect::to('review/'.$goto.'/'.$lang);
			//return Redirect::to(URL::to('review')."/".$goto."/".$lang);
		}
		return Redirect::to(URL::previous());
	}
    
	public function getDeploy()
	{
		Logic::deployProject();
		return View::make('deploy');
	}
	
	public function getAboutUs()
	{
		$introduction = Introduction::first();
		return View::make('site/about-us',compact('introduction'));
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
		if(!Session::has('Lang'))
		{
			Session::put('Lang','TH');
		}
		Session::forget('View');
		Session::forget('Campaign');
		Session::forget('mode');
		Session::forget('catName');
		$home = Post::active()->where('is_home','=',1)->get();
		
		$mode = HighlightOrder::getMode();
		$highlight = HighlightOrder::getOrder($mode);
		
		//Ads
		$adsSideDir = Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix')."Home";
		$adsFootDir = Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix')."Home";
		$allSideAds = Picture::directoryToArray($adsSideDir,false);
		$allFootAds = Picture::directoryToArray($adsFootDir,false);
	
		
		/*if(!file_exists($adsSideDir) || count($allSideAds) == 0){
			
			$adsHomeSide = "http://placehold.it/260x800";
		}
		else {
			//$allSideAds = Picture::directoryToArray($adsHomeSideDir,false);
			$adsHome = Picture::getRandomPicture($allSideAds);
			$adsHomeSide = Config::get('app.image_base_url').'/'.Config::get('app.ads_sidebar_prefix').'Home/'.$adsHome;
		}
		if(!file_exists($adsFootDir) || count($allFootAds) == 0){
			$adsHomeFoot = "http://placehold.it/750x300";
		}
		else {
			$adsHome = Picture::getRandomPicture($allFootAds);
			$adsHomeFoot = Config::get('app.image_base_url').'/'.Config::get('app.ads_footer_prefix').'Home/'.$adsHome;
		}*/
		//Ads
		$adsSide = Picture::getAdsSide(Config::get('app.home'));
		$adsFoot = Picture::getAdsFoot(Config::get('app.home'));
		$postUserRead = PostsUserRead::where('user_id','=',Auth::id())->get();
		//$randReviews = Post::getRandomReviews();
		//$randReviews = Post::getRecentReviews();
		
		return View::make('site/home',compact('home','highlight','postUserRead','adsSide','adsFoot'));
	}

	/**
	 * Returns blog posts in accordance with the selected catagory.
	 *
	 * @return View
	 */
	public function getCategory($categoryId)
	{
		
		// Get all the blog posts
		if(!Session::has('Lang'))
		{
			Session::put('Lang','TH');
		}
		$catName = Category::find($categoryId);
		Session::forget('View');
		Session::forget('Campaign');
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
		$postUserRead = PostsUserRead::where('user_id','=',Auth::id())->get();
		
		
		//Ads
		$adsSide = Picture::getAdsSide($catName->album_name);
		$adsFoot = Picture::getAdsFoot($catName->album_name);
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode','categoryId','postUserRead','adsSide','adsFoot'));
	}
	
	
	public function getCategoryMode($categoryId, $mode,$keyword=null)
	{
		// Get all the blog posts
		if(!Session::has('Lang'))
		{
			Session::put('Lang','TH');
		}
		if($categoryId!="undefined")
		{
			$catName = Category::find($categoryId);
			$posts = Post::orderReview($this->post,$mode,$categoryId,$catName->category_name);
			//Ads
			$adsSide = Picture::getAdsSide($catName->album_name);
			$adsFoot = Picture::getAdsFoot($catName->album_name);
			
		}
		else {
			
			
			$posts = Post::search($keyword,true);

			$posts = Post::orderReview($posts,$mode,$categoryId,"search");
			//Ads
			$catName = Category::orderByRaw("RAND()")->first();
			$adsSide = Picture::getAdsSide($catName->album_name);
			$adsFoot = Picture::getAdsFoot($catName->album_name);
			/*foreach($posts as $post)
			{
				echo $post;
			}*/
		}
		
		//Ads
		
		
		
		// this is a parameter to check if we need to show sort menu
		$yetToPrint = true;
		$postUserRead = PostsUserRead::where('user_id','=',Auth::id())->get();
		// Show the page
		return View::make('site/blog/index', compact('posts','yetToPrint','mode','categoryId','keyword','postUserRead','adsSide','adsFoot'));
	}
	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($postId,$slug,$lang)
	{
		// Get this blog post data
		Session::put('Lang',$lang);	
		Session::put('View',$postId."/".$slug);
		$page = "post";
		$post = $this->post->active()->where('id', '=', $postId)->first();
		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			//return App::abort(404);
			return View::make('error/404');
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
		//$address = $post->street_addr.' '.$post->soi.' แขวง'.$post->tumbol.' '.$post->amphur.' '.$post->province;
		//Convert address to google map format
		//$address = str_replace('/','%2F',$address);
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
			$post->statistic()->attach($category->id, array('ip_address' => Request::getClientIp()));
			//Statistic::keepStat($category->id,$postId,Request::getClientIp());
		}
		
		//Ads
		$adsSide = Picture::getAdsSide(Config::get('app.review'));
		$adsFoot = Picture::getAdsFoot(Config::get('app.review'));
		
		// Show the page
		return View::make('site/blog/view_post', compact('post', 'comments', 'canComment','adsSide','adsFoot','page'));
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
		$post = $this->post->active()->where('id', '=', $postId)->first();
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
				return Redirect::to("review/".$postId."/".$post->slug."/".Session::get('Lang') . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog post page
			return Redirect::to("review/".$postId."/".$post->slug."/".Session::get('Lang')  . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog post page
		return Redirect::to("review/".$postId."/".$post->slug."/".Session::get('Lang'))->withInput()->withErrors($validator);
	}
	public function searchReview($keyword)
	{
		$mode = null;
		$yetToPrint = false;
		$posts = Post::search($keyword,false);
		$postUserRead = PostsUserRead::where('user_id','=',Auth::id())->get();
		//Ads
		$catName = Category::orderByRaw("RAND()")->first();
		$adsSide = Picture::getAdsSide($catName->album_name);
		$adsFoot = Picture::getAdsFoot($catName->album_name);
        return View::make('site/blog/index', compact('posts','yetToPrint','mode','keyword','postUserRead','adsSide','adsFoot'));
    
	}
	
	public function getAlbum($postId)
	{		
		// Get all the blog posts
		$post = $this->post->active()->where('id', '=', $postId)->first();
		if($post)
		{
			$album = Picture::directoryToArray(Config::get('app.image_path').'/'.$post->album_name,true);
			$title = 'Test Album';
			// Show the page
			return View::make('site/blog/album', compact('album','title','post'));
		}
		return View::make('error/404');
	}
	
	//Campaign
	public function getAllCampaign(){
		if(!Session::has('Lang'))
		{
			Session::put('Lang','TH');
		}

		Session::forget('Campaign');
		Session::forget('mode');
		Session::forget('catName');
		$campaigns = Campaign::all();
		$home = Campaign::active()->where('is_home','=',1)->get();
		return View::make('site/campaign/index',compact('campaigns','page','home'));
	}
	public function getRegister($campaignId,$lang){
		//Session::put('Lang',$lang);	
		Session::put('Lang',$lang);	
		Session::put('Campaign',$campaignId);
		$page = "campaign";
		$campaign= Campaign::find($campaignId);
		return View::make('site/campaign/view_register',compact('campaign','page'));
	}
	public function postRegister($campaignId,$lang){
		$campaign= Campaign::find($campaignId);
		$rules = array();
		if($campaign->show_firstname == 1){
			$rules['firstname'] = 'required';
		}
		if($campaign->show_lastname == 1){
			$rules['lastname'] = 'required';
		}
		if($campaign->show_email == 1){
			$rules['email'] = 'required';
		}
		if($campaign->show_tel == 1){
			$rules['tel'] = 'required';
		}
		if($campaign->show_cid == 1){
			$rules['cid'] = 'required';
		}
		if($campaign->show_dob == 1){
			$rules['dob'] = 'required';
		}
		if($campaign->opt1_name != ''){
			$rules['opt1'] = 'required';
		}
		if($campaign->opt2_name != ''){
			$rules['opt2'] = 'required';
		}
		if($campaign->opt3_name != ''){
			$rules['opt3'] = 'required';
		}

		$messages = array(
		    'required' => 'This field is required.',
		);
		$validator = Validator::make(Input::all(), $rules,$messages);

		// Check if the form validates with success
		if ($validator -> passes()) {
			$len = 10;
				
			$bytes = openssl_random_pseudo_bytes($len, $cstrong);
    		$hex   = bin2hex($bytes);	
			$userCampaign = new UserCampaign;
			$userCampaign->user_id = Auth::user() -> id;
			$userCampaign->campaign_id = $campaignId;
			$userCampaign->user_firstname = Input::get('firstname');
			$userCampaign->user_lastname = Input::get('lastname');
			$userCampaign->user_email = Input::get('email');
			$userCampaign->user_tel = Input::get('tel');
			$userCampaign->user_dob= Date('Y-m-d',strtotime(Input::get('dob')));
			$userCampaign->user_cid = Input::get('cid');
			$userCampaign->campaign_code = $hex;
			$userCampaign->opt1 = Input::get('opt1');
			$userCampaign->opt2 = Input::get('opt2');
			$userCampaign->opt3 = Input::get('opt3');
			if($userCampaign->save())
            {
                return Redirect::to('campaign/' . $campaignId.'/'.Session::get('Lang'))->with('success', 'ลงทะเบียนรับ Voucher เสร็จสมบูรณ์');
            }

            return Redirect::to('campaign/' . $campaignId.'/'.Session::get('Lang'))->with('error', 'การลงทะเบียนผิดพลาดกรูณาลองอีกครั้ง');
        			
		}
		return Redirect::to('campaign/' . $campaignId.'/'.Session::get('Lang')) -> withInput() -> withErrors($validator);
	}
}
