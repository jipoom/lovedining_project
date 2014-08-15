<?php

class AdminCategoryController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $category;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        if(Request::is('admin/category*'))
		{
        	$title = Lang::get('admin/category/title.category_management');
		}
		else if(Request::is('admin/order*'))
		{
			$title = Lang::get('admin/category/title.order_management');
		}

        // Grab all the blog posts
        $category = $this->category;

        // Show the page
        return View::make('admin/category/index', compact('category', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/category/title.category_update');
		$randAlbumName = date("YmdHis");
        // Show the page
        return View::make('admin/category/create_edit', compact('title','randAlbumName'));
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
            'category'   => 'required|min:3|unique:category,category_name',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->category->category_name  = Input::get('category');
 			$this->category->album_name  = Input::get('album_name');;
            // Was the blog post updated?
            if($this->category->save())
            {
                // Redirect to the new blog post page
                		
                if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$this->category->album_name))
				{
					mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$this->category->album_name);
				}
				if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$this->category->album_name))
				{
					mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$this->category->album_name);
				}
                //return Redirect::to('admin/category/' . $this->category->id . '/edit')->with('success', Lang::get('admin/category/messages.create.success'));
            	return View::make('closeme');
			}

            // Redirect to the blog post create page
            return Redirect::to('admin/category/create')->with('error', Lang::get('admin/category/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/category/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getShow($category)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getEdit($category)
	{
        // Title
        $title = Lang::get('admin/category/title.category_update');
		$randAlbumName = $category->album_name;
		if($randAlbumName=="")
		{
			$randAlbumName = date("YmdHis");
		}
		
        // Show the page
        return View::make('admin/category/create_edit', compact('category','title','randAlbumName'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($category)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'category'   => 'required|min:3|unique:category,category_name,'.$category->id.',id',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $category->category_name  = Input::get('category');
 			$category->album_name  = Input::get('album_name');
            // Was the blog post updated?
            if($category->save())
            {
                // Redirect to the new blog post page
                if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$category->album_name))
				{
					mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$category->album_name);
				}
				if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$category->album_name))
				{
					mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$category->album_name);
				}
                
                //return Redirect::to('admin/category/' . $category->id . '/edit')->with('success', Lang::get('admin/category/messages.update.success'));
            	return View::make('closeme');
			}

            // Redirect to the blogs post management page
            return Redirect::to('admin/category/' . $category->id . '/edit')->with('error', Lang::get('admin/category/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/category/' . $category->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($category)
    {
        // Title
        $title = Lang::get('admin/category/title.category_delete');

        // Show the page
        return View::make('admin/category/delete', compact('category', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($category)
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
            $id = $category->id;
			$album_name = $category->album_name;
            /*$posts = Post::where('category_id','=',$id)->get();
            foreach($posts as $post)
			{
				$post->category_id = 0;
				$post->save();
			}*/
            $category->delete();
			
            // Was the blog post deleted?
            $category = Post::find($id);
            if(empty($category))
            {
                // Redirect to the blog posts management page
                Picture::recursive_remove(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$album_name);
                Picture::recursive_remove(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$album_name);
                return Redirect::to('admin/category')->with('success', Lang::get('admin/category/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        //return Redirect::to('admin/category')->with('error', Lang::get('admin/category/messages.delete.error'));
    }

       /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
   {
        	
        
        $category = Category::select(array('category.id', 'category.category_name', 'category.id as posts'));

        return Datatables::of($category)

        ->edit_column('posts', '{{ DB::table(\'posts_category\')->where(\'category_id\', \'=\', $id)->count() }}')
		
		->edit_column('posts', '<a href="{{{ URL::to(\'admin/blogs/\'.$id.\'/view_blogs\' ) }}}">{{$posts}}</a>')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/category/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/category/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}