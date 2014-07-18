<?php

class AdminBlogsController extends AdminController {


    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct();
        $this->post = $post;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/blogs/title.blog_management');

        // Grab all the blog posts
        $posts = $this->post;

        // Show the page
        return View::make('admin/blogs/index', compact('posts', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/blogs/title.create_a_new_blog');
		
		//Category
		$init_cat = Category::first();
		$category = array($init_cat->id => $init_cat->category_name);
		$categories = Category::all();
		foreach($categories as $temp)
		{
				
			$category = array_add($category, $temp->id, $temp->category_name);
		}
		
		//Province
		$init_province = Province::first();
		$provinceTemp = array($init_province->id => $init_province->province_name);
		$provinces = Province::all();
		foreach($provinces as $temp)
		{		
			$provinceTemp = array_add($provinceTemp, $temp->id, $temp->province_name);
		}
		
		
        // Show the page
        return View::make('admin/blogs/create_edit', compact('title','category','provinceTemp'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3|unique:posts',
            'restaurant_name'  => 'required|min:3',
            'content' => 'required|min:3',
            'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i',
            'album_name' => 'required|unique:posts'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Create a new blog post
            $user = Auth::user();

            // Update the blog post data
            $this->post->title            = Input::get('title');
			$this->post->restaurant_name  = Input::get('restaurant_name');
			$this->post->tel  = Input::get('tel');
			$this->post->street_addr  = Input::get('street_addr');
			$this->post->soi    = Input::get('soi');
			$this->post->road    = Input::get('road');
			$this->post->subdistrict  = Input::get('subdistrict');
			$this->post->district  = Input::get('district');
			$this->post->province  = Input::get('province');
			$this->post->zip  = Input::get('zip');
			$this->post->category_id  = Input::get('category_id');
			$this->post->album_name  = Input::get('album_name');
			
            //$this->post->slug             = Str::slug(Input::get('title'));
            $this->post->content          = Input::get('content');
            $this->post->meta_title       = Input::get('meta-title');
            $this->post->meta_description = Input::get('meta-description');
            $this->post->meta_keywords    = Input::get('meta-keywords');
            $this->post->user_id          = $user->id;
			
            // Was the blog post created?
            if($this->post->save())
            {
                // Redirect to the new blog post page
                //return Redirect::to('admin/blogs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
           		if(!file_exists(Config::get('app.image_path').'/'.Input::get('album_name')))
           			mkdir(Config::get('app.image_path').'/'.Input::get('album_name'),0755);
           		return Redirect::to('admin/blogs/')->with('success', Lang::get('admin/blogs/messages.create.success'));
           
		    }

            // Redirect to the blog post create page
            return Redirect::to('admin/blogs/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogs/create')->withInput()->withErrors($validator);
	}

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getShow($post)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getEdit($post)
	{
        // Title
        $title = Lang::get('admin/blogs/title.blog_update');
		//Category
		$init_cat = Category::first();
		$category = array($init_cat->id => $init_cat->category_name);
		$categories = Category::all();
		foreach($categories as $temp)
		{				
			$category = array_add($category, $temp->id, $temp->category_name);
		}
		
		
        // Show the page
        return View::make('admin/blogs/create_edit', compact('post', 'title', 'category'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($post)
	{

        // Declare the rules for the form validation
         $rules = array(
            'title'   => 'required|min:3|unique:posts,title,'.$post->id.',id',
            'restaurant_name'  => 'required|min:3',
            'content' => 'required|min:3',
            'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i',
            'album_name' => 'required|Regex:/^[0-9a-zA-Z]*$/|unique:posts,album_name,'.$post->id.',id'
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $oldImageDir = $post->album_name;
            $post->title            = Input::get('title');
            $post->restaurant_name  = Input::get('restaurant_name');
			$post->tel  = Input::get('tel');
			$post->street_addr  = Input::get('street_addr');
			$post->soi    = Input::get('soi');
			$post->road    = Input::get('road');
			$post->subdistrict  = Input::get('subdistrict');
			$post->district  = Input::get('district');
			$post->province  = Input::get('province');
			$post->zip  = Input::get('zip');
			$post->category_id  = Input::get('category_id');
			$post->album_name  = Input::get('album_name');
            //$post->slug             = Str::slug(Input::get('title'));
            $post->content          = Input::get('content');
            $post->meta_title       = Input::get('meta-title');
            $post->meta_description = Input::get('meta-description');
            $post->meta_keywords    = Input::get('meta-keywords');

            // Was the blog post updated?
            
            if($post->save())
            {
                $extension = null;
				if($oldImageDir == null)
				{
					mkdir(Config::get('app.image_path').'/'.Input::get('album_name'), 0755);
				}
				else if(!file_exists(Config::get('app.image_path').'/'.Input::get('album_name')))
				{
					Picture::recursive_copy(Config::get('app.image_path').'/'.$oldImageDir , Config::get('app.image_path').'/'.Input::get('album_name'));
				}	
                PostsUserRead::where('post_id', '=', $post->id)->delete();
                //return Redirect::to('admin/blogs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'));
           		
           		//Check if admin update dir name
           		if($oldImageDir!=Input::get('album_name') && $oldImageDir!=null)
				{
					//give admin a warning	
					$extension = "<p><b>please update your image path on this review</b></p>";
					//rename old dir
					rename ( Config::get('app.image_path').'/'.$oldImageDir , Config::get('app.image_path').'/'.$oldImageDir.'_old_'.date('Y-m-d'));
				}
           		return Redirect::to('admin/blogs/')->with('success', Lang::get('admin/blogs/messages.update.success').$extension);
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/blogs/' . $post->id . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogs/' . $post->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($post)
    {
        // Title
        $title = Lang::get('admin/blogs/title.blog_delete');

        // Show the page
        return View::make('admin/blogs/delete', compact('post', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($post)
    {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $id = $post->id;
            $post->delete();
            // Was the blog post deleted?
            $post = Post::find($id);
            if(empty($post) && PostsUserRead::where('post_id', '=', $id)->delete())
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.delete.error'));
    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category' ,'posts.id as comments', 'posts.created_at'))
		->join('category', 'posts.category_id', '=', 'category.id');

        //$posts = Post::leftjoin('category', 'posts.category_id', '=', 'category.id')
        //->select(array('posts.id', 'posts.title', 'category.category_name as category ','posts.id as comments', 'posts.created_at'));
        
        return Datatables::of($posts)

        ->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
       

    }

}