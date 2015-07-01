<?php
use Illuminate\Support\Facades\URL;

class Campaign extends Eloquent {	
    protected $table = 'campaign';
	
	public function post()
	{
		return $this->belongsTo('Post','post_id');
	}
	
	public function url()
	{
		return Url::to("cp/".$this->id."/".Session::get('Lang'));
	}
	
	public function scopeActive($query)
    {
      
	    return $query-> whereRaw('(UNIX_TIMESTAMP(expiry_date) >= UNIX_TIMESTAMP(now()) and isActive = 1)');
    }
	
	public static function search($keyword)
	{

		$wordTemp = explode(' ', $keyword);
		foreach($wordTemp as $term)
		{
			$items =Campaign::active()->join('posts','campaign.post_id','=','posts.id')->join('province','province.id','=','posts.province_id')->where(function($query) use ($term)
            {
                $query->where('restaurant_name', 'LIKE',  '%'. $term .'%')
                      ->orwhere('title', 'LIKE', '%'. $term .'%')
					  ->orwhere('province.province_name', 'LIKE', '%'. $term .'%')
					  ->orwhere('province.province_name_en', 'LIKE', '%'. $term .'%')
					  ->orwhere('amphur', 'LIKE', '%'. $term .'%')
					  ->orwhere('tumbol', 'LIKE', '%'. $term .'%')
					  ->orwhere('campaign.name', 'LIKE', '%'. $term .'%')
					  ->orwhere('campaign.description', 'LIKE', '%'. $term .'%');

            })->paginate(3,array('campaign.id', 'campaign.name', 'campaign.description', 'campaign.start_date', 
			'campaign.expiry_date','campaign.hotel_logo','campaign.album_name','campaign.remark1','campaign.remark2',
			'campaign.allow_duplicate_user','campaign.post_id','campaign.created_at',
			'campaign.updated_at','campaign.show_firstname','campaign.show_lastname','campaign.show_cid','campaign.show_email','campaign.show_tel',
			'campaign.show_dob','campaign.isActive','campaign.opt1_name','campaign.opt2_name','campaign.opt3_name',
			'campaign.is_home','campaign.rank'));
			//$posts = Post::active()->search($term);
		}
		return $items;
	}
	
}

?>