<?php

class AdminIntroductionController extends AdminController {


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
    public function getCreate()
    {
        // Title
        if(Introduction::first())
		   return View::make('error/404');
		else {
			$title = Lang::get('admin/introduction/title.introduction_management');
	        // Grab all the blog posts
	        $introduction = $this->introduction;
			$randAlbumName = 'Introduction';
			if(!file_exists(Config::get('app.image_path') . '/' . $randAlbumName))
			{
				mkdir(Config::get('app.image_path') . '/' . $randAlbumName);
			}
	        // Show the page
	        return View::make('admin/introduction/index', compact('introduction', 'title','randAlbumName'));
		}		
     
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
            'content'   => 'required|min:3',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->introduction->content  = Input::get('content');

            // Was the blog post updated?
            if($this->introduction->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/introduction/'.Introduction::first()->id.'/edit')->with('success', Lang::get('admin/introduction/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/introduction')->with('error', Lang::get('admin/introduction/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/introduction')->withInput()->withErrors($validator);
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
	public function getEdit($introduction)
	{
        // Title
        $title = Lang::get('admin/introduction/title.introduction_management');
		$randAlbumName = 'Introduction';
		if(!file_exists(Config::get('app.image_path') . '/' . $randAlbumName))
		{
			mkdir(Config::get('app.image_path') . '/' . $randAlbumName);
		}
        // Show the page
        return View::make('admin/introduction/index', compact('introduction', 'title','randAlbumName'));	
			
        // Title
        
        
        
        $title = Lang::get('admin/introduction/title.introduction_update');
		$randAlbumName = 'Introduction';
		if(!file_exists(Config::get('app.image_path') . '/' . $randAlbumName))
		{
			mkdir(Config::get('app.image_path') . '/' . $randAlbumName);
		}
        // Show the page
         return View::make('admin/introduction/index', compact('$introduction', 'title','randAlbumName'));	
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($introduction)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'content'   => 'required|min:3',
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $introduction->content  = Input::get('content');

            // Was the blog post updated?
            if($introduction->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/introduction/'.$introduction->id.'/edit')->with('success', Lang::get('admin/introduction/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/introduction/'.$introduction->id.'/edit')->with('error', Lang::get('admin/introduction/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/introduction/'.$introduction->id.'/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
   /* public function getDelete($category)
    {
        // Title
        $title = Lang::get('admin/category/title.category_delete');

        // Show the page
        return View::make('admin/category/delete', compact('category', 'title'));
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    /*public function postDelete($category)
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
    }*/


}