<?php

class AdminDressingController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $dressing;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Dressing $dressing)
    {
        parent::__construct();
        $this->dressing = $dressing;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {

		$title = Lang::get('admin/dressing/title.dressing_management');
        // Grab all the blog posts
        $dressing = $this->dressing;

        // Show the page
        return View::make('admin/dressing/index', compact('dressing', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/dressing/title.create_a_new_dressing');
        // Show the page
        return View::make('admin/dressing/create_edit', compact('title'));
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
            'dressing'   => 'required|min:3|unique:dressing,name',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->dressing->name  = Input::get('dressing');
            // Was the blog post updated?
            if($this->dressing->save())
            {
                // Redirect to the new blog post page

                return Redirect::to('admin/dressing/' . $this->dressing->id . '/edit')->with('success', Lang::get('admin/dressing/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/dressing/create')->with('error', Lang::get('admin/dressing/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/dressing/create')->withInput()->withErrors($validator);
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
	public function getEdit($dressing)
	{
        // Title
        $title = Lang::get('admin/dressing/title.dressing_update');
		
        // Show the page
        return View::make('admin/dressing/create_edit', compact('dressing','title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($dressing)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'dressing'   => 'required|min:3|unique:dressing,name,'.$dressing->id.',id',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $dressing->name  = Input::get('dressing');
            // Was the blog post updated?
            if($dressing->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/dressing/' . $dressing->id . '/edit')->with('success', Lang::get('admin/dressing/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/dressing/' . $dressing->id . '/edit')->with('error', Lang::get('admin/dressing/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/dressing/' . $dressing->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($dressing)
    {
        // Title
        $title = Lang::get('admin/dressing/title.dressing_delete');

        // Show the page
        return View::make('admin/dressing/delete', compact('dressing', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($dressing)
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
            $id = $dressing->id;
            /*$posts = Post::where('category_id','=',$id)->get();
            foreach($posts as $post)
			{
				$post->category_id = 0;
				$post->save();
			}*/
            $dressing->delete();
			
            // Was the blog post deleted?
            if(empty($category))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/dressing')->with('success', Lang::get('admin/dressing/messages.delete.success'));
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
        	
        
        $dressing = Dressing::select(array('dressing.id', 'dressing.name'));

        return Datatables::of($dressing)


        ->add_column('actions', '<a href="{{{ URL::to(\'admin/dressing/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/dressing/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}