<?php

class AdminCampaignHomeController extends AdminController {

	/**
	 * Post Model
	 * @var Post
	 */
	protected $campaign;

	/**
	 * Inject the models.
	 * @param Post $post
	 */
	public function __construct(Campaign $campaign) {
		parent::__construct();
		$this -> campaign = $campaign;
	}

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex() {

		// Title
		$title = "Campaign Banner Management";
	
		// Grab all the blog posts
		$campaigns = $this -> campaign;
		
		return View::make('admin/campaign_home/index', compact('campaigns', 'title'));
	}
	
	public function setBanner() {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator -> passes()) {
			
			//reset all to non-banner	
			//Post::where('is_home', '=', 1)->update(array('is_home' => 0));
			foreach(Input::get('setHome') as $banner)
			{
				
				//Set home to selected review
				$campaign = Campaign::find($banner);
				//If set home to anthoer review
				if($campaign->is_home == 0)
				{					
					$campaign->is_home = 1;
					$campaign->save();				
				}
				
			}
				return Redirect::to('admin/campaign_home/') -> with('success', Campaign::find($banner)->name." has been added to banner");
		}
		//If set home to the old review
		else
		{
			return Redirect::to('admin/campaign_home/') -> with('success', Campaign::find($banner)->name." has been added to banner");
		}
		
		// There was a problem deleting the blog post
		//return Redirect::to('admin/home') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	public function removeBanner($campaign) {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

			
		//reset all to non-banner	
		Campaign::where('id', '=', $campaign)->update(array('is_home' => 0));
		return Redirect::to('admin/campaign_home/') -> with('success', Campaign::find($campaign)->title." has been removed from banner");
	
	}
	public function removeHighlight($postId) {

		// Title
		$title = "Upload Banner Images";
		$rules = array('setHome' => 'required');

			
		//reset all to non-banner	
		Post::where('id', '=', $postId)->update(array('is_highlight' => 0));
		return Redirect::to('admin/home/custom_highlight') -> with('success', Post::find($postId)->title." has been removed from highlight");
	
	}

	public function postHighlightCustom() {

		// Title
		$rules = array('setHighlight' => 'required');

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator -> passes()) {
			
			//reset all to non-banner	
			//Post::where('is_highlight', '=', 1)->update(array('is_highlight' => 0));
			$i = 0;	
			if(count(Post::where('is_highlight', '=', 1)->get()) + count(Input::get('setHighlight')) > 6)
			{
				foreach(Input::get('setHighlight') as $highlight)
				{
					
					//Set home to selected review
					$post = Post::find($highlight);
					if($post->is_highlight == 1)
					{					
						$post->is_highlight = 0;
						$post->save();	
						$i++;				
					}				
									
				}
				Post::whereNotIn('id', Input::get('setHighlight'))->take(count(Input::get('setHighlight')) - $i)->update(array('is_highlight' => 0));
				//Post::where('is_highlight', '=', 1)->take(count(Input::get('setHighlight')) - $i)->update(array('is_highlight' => 0));
			}
			$i = 0;	
			foreach(Input::get('setHighlight') as $highlight)
			{
				
				//Set home to selected review
				$post = Post::find($highlight);
				//If set home to anthoer review
				if($post->is_highlight == 0)
				{					
					$post->is_highlight = 1;
					$post->save();				
				}
				$i++;
				if($i==6){
					break;
				}
				
			}
			// Save Highlight Order
			//update Highlight Order
			$order = HighlightOrder::all();
			$user = Auth::user();
			if($order->count()>0)
			{
				foreach ($order as $orderMode) {
					$orderMode -> mode = "custom";
					$orderMode -> user_id = $user->id;
					if($orderMode -> save())
						break;
				}
			}
			else {
				$order = new HighlightOrder;
				$order-> mode = "custom";
				$order-> user_id = $user->id;
				$order->save();
				
			}
			
			return Redirect::to('admin/home/custom_highlight') -> with('success', "Success");
		}
		//If set home to the old review
		else
		{
			return Redirect::to('admin/home/custom_highlight') -> with('success', "Success");
		}
		
		// There was a problem deleting the blog post
		//return Redirect::to('admin/home') -> with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

	public function changeOrder($mode) {
		//Sort Category by mode
		$highlight = HighlightOrder::getOrder($mode);
		//$message = null;
		return View::make('admin/home/showhighlight', compact('highlight', 'mode'));
		

	}
	
	public function saveOrder($mode) {
		//Sort Category by mode
		$title = Lang::get('admin/category/title.order_management');
		
		//update Highlight Order
		$order = HighlightOrder::all();
		$user = Auth::user();
		if($order->count()>0)
		{
			foreach ($order as $orderMode) {
				$orderMode -> mode = $mode;
				$orderMode -> user_id = $user->id;
				if($orderMode -> save())
					return Redirect::to('admin')->with('success', Lang::get('admin/home/messages.change.success'));
			}
		}
		else {
			$order = new HighlightOrder;
			$order-> mode = $mode;
			$order-> user_id = $user->id;
			echo $mode;
			if($order->save())
				return Redirect::to('admin')->with('success', Lang::get('admin/home/messages.change.success'));
			
		}
		
		

	}

	public function getData() {

		//$posts = Post::select(array('posts.id', 'posts.title', 'category.category_name as category', 'posts.id as comments', 'posts.created_at')) -> leftjoin('category', 'posts.category_id', '=', 'category.id');
		$timestamp = time(); 
		$campaign = Campaign::select(array('campaign.id', 'campaign.name as campaign_name', 'campaign.id as comments', 'campaign.start_date','campaign.expiry_date', 'campaign.is_home')) 
		-> active();
		//-> leftjoin('posts_category', 'posts.id', '=', 'posts_category.post_id') 
		//-> leftjoin('category', 'posts_category.category_id', '=', 'category.id');

			
		
		return Datatables::of($campaign) 
		
		-> edit_column('comments', '{{ DB::table(\'user_campaign\')->where(\'campaign_id\', \'=\', $id)->count() }}') 
		-> edit_column('campaign_name', '<a href="{{{ URL::to(\'admin/campaign/\'. $id .\'/edit\') }}}">{{{ Str::limit($campaign_name, 40, \'...\') }}}</a>')

		-> add_column('actions', '@if($is_home == 0){{Form::radio(\'setHome[]\', $id)}} @else {{Form::radio(\'setHome[]\', $id, true)}} @endif')  
        -> remove_column('id') -> make();

	}
	

}
