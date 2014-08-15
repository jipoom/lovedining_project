<?php

class AdminMealController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $meal;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Meal $meal)
    {
        parent::__construct();
        $this->meal = $meal;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {

		$title = Lang::get('admin/meal/title.meal_management');
        // Grab all the blog posts
        $meal = $this->meal;

        // Show the page
        return View::make('admin/meal/index', compact('meal', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/meal/title.create_a_new_meal');
        // Show the page
        return View::make('admin/meal/create_edit', compact('title'));
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
            'meal'   => 'required|min:3|unique:meal,name',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->meal->name  = Input::get('meal');
            // Was the blog post updated?
            if($this->meal->save())
            {
                // Redirect to the new blog post page

                //return Redirect::to('admin/meal/' . $this->meal->id . '/edit')->with('success', Lang::get('admin/meal/messages.create.success'));
           		return View::make('admin/close');
			}

            // Redirect to the blog post create page
            return Redirect::to('admin/meal/create')->with('error', Lang::get('admin/meal/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/meal/create')->withInput()->withErrors($validator);
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
	public function getEdit($meal)
	{
        // Title
        $title = Lang::get('admin/meal/title.meal_update');
		
        // Show the page
        return View::make('admin/meal/create_edit', compact('meal','title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($meal)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'meal'   => 'required|min:3|unique:meal,name,'.$meal->id.',id',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $meal->name  = Input::get('meal');
            // Was the blog post updated?
            if($meal->save())
            {
                // Redirect to the new blog post page
                //return Redirect::to('admin/meal/' . $meal->id . '/edit')->with('success', Lang::get('admin/meal/messages.update.success'));
            	return View::make('admin/close');
			}

            // Redirect to the blogs post management page
            return Redirect::to('admin/meal/' . $meal->id . '/edit')->with('error', Lang::get('admin/meal/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/meal/' . $meal->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($meal)
    {
        // Title
        $title = Lang::get('admin/meal/title.meal_delete');

        // Show the page
        return View::make('admin/meal/delete', compact('meal', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($meal)
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
            $id = $meal->id;
            /*$posts = Post::where('category_id','=',$id)->get();
            foreach($posts as $post)
			{
				$post->category_id = 0;
				$post->save();
			}*/
            $meal->delete();
			
            // Was the blog post deleted?
            if(empty($meal))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/meal')->with('success', Lang::get('admin/meal/messages.delete.success'));
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
        	
        
        $meal = Meal::select(array('meal.id', 'meal.name'));

        return Datatables::of($meal)


        ->add_column('actions', '<a href="{{{ URL::to(\'admin/meal/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/meal/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}