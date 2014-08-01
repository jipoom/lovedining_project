<?php

class AdminCampaignController extends AdminController {


    /**
     * Post Model
     * @var Category
     */
    protected $campaign;

    /**
     * Inject the models.
     * @param $category $category
     */
    public function __construct(Campaign $campaign)
    {
        parent::__construct();
        $this->campaign = $campaign;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/campaign/title.campaign_management');

        // Grab all the blog posts
        $campaign = $this->campaign;

        // Show the page
        return View::make('admin/campaign/index', compact('campaign', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		
		// Title
        $title = Lang::get('admin/campaign/title.create_a_new_campaign');
		
		$init_post = Post::first();
		$restaurant = array($init_post->id => $init_post->restaurant_name);
		$restaurants = Post::all();
		foreach($restaurants as $temp)
		{				
			$restaurant = array_add($restaurant, $temp->id, $temp->restaurant_name);
		}
		
        // Show the page
        return View::make('admin/campaign/create_edit', compact('campaign','title','restaurant'));
		
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
            'campaign'   => 'required|min:3',
            'expiryDate' => 'required',
            'description' => 'required'
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->campaign->name  = Input::get('campaign');
			$this->campaign->post_id  = Input::get('postId');
			$this->campaign->expiry_date  = Input::get('expiryDate');
			$this->campaign->description  = Input::get('description');
            // Was the blog post updated?
            if($this->campaign->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/campaign/' . $this->campaign->id . '/edit')->with('success', Lang::get('admin/campaign/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/campaign/create')->with('error', Lang::get('admin/campaign/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/campaign/create')->withInput()->withErrors($validator);
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
	public function getEdit($campaign)
	{
        // Title
        $title = Lang::get('admin/campaign/title.campaign_update');
		
		$init_post = Post::first();
		$restaurant = array($init_post->id => $init_post->restaurant_name);
		$restaurants = Post::all();
		foreach($restaurants as $temp)
		{				
			$restaurant = array_add($restaurant, $temp->id, $temp->restaurant_name);
		}
		
        // Show the page
        return View::make('admin/campaign/create_edit', compact('campaign','title','restaurant'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function postEdit($campaign)
	{
		
        // Declare the rules for the form validation
         $rules = array(
            'campaign'   => 'required|min:3|unique:campaign,name,'.$campaign->id.',id',
            'expiryDate' => 'required',
            'description' => 'required'
        );


        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $campaign->name  = Input::get('campaign');
			$campaign->name  = Input::get('campaign');
			$campaign->post_id  = Input::get('postId');
			$campaign->expiry_date  = Input::get('expiryDate');
			$campaign->description  = Input::get('description');
            // Was the blog post updated?
            if($campaign->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/campaign/' . $campaign->id . '/edit')->with('success', Lang::get('admin/campaign/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/campaign/' . $campaign->id . '/edit')->with('error', Lang::get('admin/campaign/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/campaign/' . $campaign->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function getDelete($campaign)
    {
        // Title
        $title = Lang::get('admin/campaign/title.campaign_delete');

        // Show the page
        return View::make('admin/campaign/delete', compact('campaign', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function postDelete($campaign)
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
            $id = $campaign->id;
            $campaign->delete();

            // Was the blog post deleted?
            $campaign = Post::find($id);
            if(empty($campaign))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/campaign')->with('success', Lang::get('admin/campaign/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/campaign')->with('error', Lang::get('admin/campaign/messages.delete.error'));
    }

       /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
   {
        
      	$campaign = Campaign::select(array('campaign.id', 'campaign.post_id','campaign.name', 'posts.restaurant_name as restaurant' ,'campaign.description', 'campaign.created_at', 'campaign.expiry_date'))
		->join('posts', 'posts.id', '=', 'campaign.post_id');

		   
        return Datatables::of($campaign)
		
		->edit_column('restaurant', '<a href="{{{ URL::to(\'admin/blogs/\'. $post_id .\'/edit\') }}}">{{{ Str::limit($restaurant, 40, \'...\') }}}</a>')
		
		->edit_column('description', '{{Str::limit($description, 30, \'...\')}}')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/campaign/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/campaign/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')
		->remove_column('post_id')
        ->make();
    }

}