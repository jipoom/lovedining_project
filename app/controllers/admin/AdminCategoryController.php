<?php

class AdminCategoryController extends AdminController {


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
        $title = Lang::get('admin/category/title.category_management');

        // Grab all the blog posts
        $category = Category::all();

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
		
        // Show the page
        return View::make('admin/category/create_edit', compact('title'));
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
            'title'   => 'required|min:3',
            'restaurant_name'  => 'required|min:3',
            'content' => 'required|min:3',
            'tel' => 'required|Regex:/^[0-9]{9,}([,][ ][0-9]{9,})*+$/i'
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
                return Redirect::to('admin/blogs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/category/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/blogs/create')->with('error', Lang::get('admin/category/messages.create.error'));
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
	public function getEdit($categoryId)
	{
        // Title
        $title = Lang::get('admin/category/title.category_update');
		
		//Category
		$category = Category::find($categoryId);
        // Show the page
        return View::make('admin/category/create_edit', compact('category','title'));
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
            'category'   => 'required|min:3',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $category->category_name  = Input::get('category');

            // Was the blog post updated?
            if($category->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/category/' . $category->id . '/edit')->with('success', Lang::get('admin/category/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/category/' . $category->id . '/edit')->with('error', Lang::get('admin/category/messages.update.error'));
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
        $title = Lang::get('admin/category/title.category_delete');

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
            if(empty($post))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/blogs')->with('success', Lang::get('admin/category/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/blogs')->with('error', Lang::get('admin/category/messages.delete.error'));
    }

       /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
   {
        /*$category = Category::join('posts', 'category_id', '=', 'category.id')
                        ->select(array('category.id as id', 'category.category_name as category'));

        return Datatables::of($category)

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/comments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-xs">{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/comments/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
            ')


        ->make();*/
        
        $category = Category::select(array('category.id', 'category.category_name', 'category.id as posts'));

        return Datatables::of($category)

        ->edit_column('posts', '{{ DB::table(\'posts\')->where(\'category_id\', \'=\', $id)->count() }}')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/category/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/category/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}