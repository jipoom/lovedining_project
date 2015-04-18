<?php

use Illuminate\Support\Facades\URL;

class CampaignUserRead extends Eloquent 
{

	protected $table = 'campaign_user_read'; 
	public static function getUnreadCampaign()
	{
		//return Post::where('category_id', '=', $category -> id) -> count() - PostsUserRead::where('user_id', '=', $userId) -> where('category_id', '=', $category -> id) -> count();
		if(Auth::check())
			$diff = Campaign::active()->count() - Campaign::active()->join('campaign_user_read','campaign_user_read.campaign_id','=','campaign.id')->where('user_id','=',Auth::id())->count();
		elseif(Session::get('socialUser.isLogin'))
			$diff = Campaign::active()->count() - Campaign::active()->join('campaign_user_read','campaign_user_read.campaign_id','=','campaign.id')->where('social_id','=',Session::get('socialUser.id'))->count();
		return $diff;
	
	}
}
