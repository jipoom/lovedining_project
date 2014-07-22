<?php

class AdminIntroduction extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $introduction;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Introduction $introduction)
    {
        parent::__construct();
        $this->introduction = $introduction;
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
            'category'   => 'required|min:3|unique:category,category_name',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->category->category_name  = Input::get('category');

            // Was the blog post updated?
            if($this->category->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/category/' . $this->category->id . '/edit')->with('success', Lang::get('admin/category/messages.create.success'));
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
            'category'   => 'required|min:3|unique:category,category_name,'.$category->id.',id',
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
            $posts = Post::where('category_id','=',$id)->get();
            foreach($posts as $post)
			{
				$post->category_id = 0;
				$post->save();
			}
            $category->delete();
			
            // Was the blog post deleted?
            $category = Post::find($id);
            if(empty($category))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/category')->with('success', Lang::get('admin/category/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/category')->with('error', Lang::get('admin/category/messages.delete.error'));
    }


}