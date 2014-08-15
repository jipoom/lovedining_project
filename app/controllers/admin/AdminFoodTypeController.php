<?php

class AdminFoodTypeController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $foodtype;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(FoodType $foodtype)
    {
        parent::__construct();
        $this->foodtype = $foodtype;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {

		$title = Lang::get('admin/foodtype/title.foodtype_management');
        // Grab all the blog posts
        $foodtype = $this->foodtype;

        // Show the page
        return View::make('admin/foodtype/index', compact('foodtype', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/foodtype/title.create_a_new_foodtype');
        // Show the page
        return View::make('admin/foodtype/create_edit', compact('title'));
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
            'foodtype'   => 'required|min:3|unique:meal,name',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->foodtype->name  = Input::get('foodtype');
            // Was the blog post updated?
            if($this->foodtype->save())
            {
                // Redirect to the new blog post page

                return Redirect::to('admin/foodtype/' . $this->foodtype->id . '/edit')->with('success', Lang::get('admin/foodtype/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/foodtype/create')->with('error', Lang::get('admin/foodtype/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/foodtype/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getShow($foodtype)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getEdit($foodtype)
	{
        // Title
        $title = Lang::get('admin/foodtype/title.foodtype_update');
		
        // Show the page
        return View::make('admin/foodtype/create_edit', compact('foodtype','title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($foodtype)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'foodtype'   => 'required|min:3|unique:meal,name,'.$foodtype->id.',id',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $foodtype->name  = Input::get('foodtype');
            // Was the blog post updated?
            if($foodtype->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/foodtype/' . $foodtype->id . '/edit')->with('success', Lang::get('admin/foodtype/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/foodtype/' . $foodtype->id . '/edit')->with('error', Lang::get('admin/foodtype/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/foodtype/' . $foodtype->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($foodtype)
    {
        // Title
        $title = Lang::get('admin/foodtype/title.foodtype_delete');

        // Show the page
        return View::make('admin/foodtype/delete', compact('foodtype', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($foodtype)
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
            $id = $foodtype->id;
            /*$posts = Post::where('category_id','=',$id)->get();
            foreach($posts as $post)
			{
				$post->category_id = 0;
				$post->save();
			}*/
            $foodtype->delete();
			
            // Was the blog post deleted?
            if(empty($foodtype))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/foodtype')->with('success', Lang::get('admin/foodtype/messages.delete.success'));
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
        	
        
        $foodtype = FoodType::select(array('food_type.id', 'food_type.name'));

        return Datatables::of($foodtype)


        ->add_column('actions', '<a href="{{{ URL::to(\'admin/foodtype/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/foodtype/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}