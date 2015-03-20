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
    public function getIndex($directory = null, $campaignId = null)
    {
    	if ($campaignId == "new") {
			if ($directory && file_exists(Config::get('app.image_path') . '/' . $directory)) {
				Picture::recursive_remove(Config::get('app.image_path') . '/' . $directory);
			}
		}
        	
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
		$randAlbumName = "campaign_".date("YmdHis");
		$init_post = Post::first();
		$restaurant = array($init_post->id => $init_post->restaurant_name);
		$restaurants = Post::all();
		foreach($restaurants as $temp)
		{				
			$restaurant = array_add($restaurant, $temp->id, $temp->restaurant_name);
		}
		
        // Show the page
        return View::make('admin/campaign/create_edit', compact('campaign','title','restaurant','randAlbumName'));
		
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
            'startDate' => 'required',
            'expiryDate' => 'required',
            'review' => 'required|exists:posts,title',
            'description' => 'required',
        );
		
        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->campaign->name  = Input::get('campaign');
			$this->campaign->post_id  = Post::where('title','=',Input::get('review'))->first()->id;
			$this->campaign->expiry_date  = Input::get('expiryDate');
			$this->campaign->start_date  = Input::get('startDate');
			$this->campaign->description  = Input::get('description');
			$this->campaign->remark1  = Input::get('remark1');
			$this->campaign->remark2  = Input::get('remark2');
			$this->campaign->allow_duplicate_user  = Input::get('dupRegis');
			$this->campaign->show_name  = Input::get('show_name');
			$this->campaign->show_lastname  = Input::get('show_lastname');
			$this->campaign->show_id  = Input::get('show_id');
			$this->campaign->show_email  = Input::get('show_email');
			$this->campaign->show_dob  = Input::get('show_dob');
			$this->campaign->show_mobile  = Input::get('show_mobile');
			$this->campaign->isActive  = Input::get('isActive');
			$this->campaign->album_name  = Input::get('album_name');
			$this->campaign->hotel_logo  = Input::get('hotel_logo');
            // Was the blog post updated?
            if($this->campaign->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/campaign/')->with('success', Lang::get('admin/campaign/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/campaign/create')->withInput()->with('error', Lang::get('admin/campaign/messages.create.error'));
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
	
	public function autocomplete() {

		$match = '%' .Input::get('term') . '%';
		$init_user =  Post::where('title', 'like', $match)->firstOrFail();
		$results = array($init_user->id => $init_user->title);

		$query = Post::where('title', 'like', $match)->get();
		foreach($query as $user)
		{
			$results = array_add($results, $user->id, $user->title);
		}
		echo json_encode($results);
		
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
		$randAlbumName = $campaign -> album_name;
		$init_post = Post::first();
		$restaurant = array($init_post->id => $init_post->restaurant_name);
		$restaurants = Post::all();
		foreach($restaurants as $temp)
		{				
			$restaurant = array_add($restaurant, $temp->id, $temp->restaurant_name);
		}
		
        // Show the page
        return View::make('admin/campaign/create_edit', compact('campaign','title','restaurant','randAlbumName'));
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
            'startDate' => 'required',
            'expiryDate' => 'required',
            'review' => 'required|exists:posts,title',
            'description' => 'required',
        );
        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $campaign->name  = Input::get('campaign');
			$campaign->post_id  = Post::where('title','=',Input::get('review'))->first()->id;
			$campaign->expiry_date  = Input::get('expiryDate');
			$campaign->start_date  = Input::get('startDate');
			$campaign->description  = Input::get('description');
			$campaign->remark1  = Input::get('remark1');
			$campaign->remark2  = Input::get('remark2');
			$campaign->allow_duplicate_user  = Input::get('dupRegis');
			$campaign->show_name  = Input::get('show_name');
			$campaign->show_lastname  = Input::get('show_lastname');
			$campaign->show_id  = Input::get('show_id');
			$campaign->show_email  = Input::get('show_email');
			$campaign->show_dob  = Input::get('show_dob');
			$campaign->show_mobile  = Input::get('show_mobile');
			$campaign->isActive  = Input::get('isActive');
			$campaign->album_name  = Input::get('album_name');
			$campaign->hotel_logo  = Input::get('hotel_logo');
            // Was the blog post updated?
            if($campaign->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/campaign/')->with('success', Lang::get('admin/campaign/messages.update.success'));
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
        
      	$campaign = Campaign::select(array('campaign.id', 'campaign.post_id','campaign.name', 'posts.restaurant_name as restaurant' , 'campaign.start_date','campaign.expiry_date','campaign.isActive'))
		->join('posts', 'posts.id', '=', 'campaign.post_id');

		   
        return Datatables::of($campaign)
		
		->edit_column('restaurant', '<a href="{{{ URL::to(\'admin/blogs/\'. $post_id .\'/edit\') }}}">{{{ Str::limit($restaurant, 40, \'...\') }}}</a>')
		
		->edit_column('isActive', '@if(strtotime($expiry_date) < time() || $isActive == 0) inactive @elseif($isActive == 1) active @endif') 

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/campaign/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/campaign/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')
		->remove_column('post_id')
        ->make();
    }

}