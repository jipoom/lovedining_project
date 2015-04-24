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
		return Url::to("campaign/".$this->id."/".Session::get('Lang'));
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

            })->get();
            /*paginate(8,array('campaign.id', 'campaign.name', 'campaign.start_date', 'campaign.expiry_date', 
			'campaign.hotel_logo','campaign.d','posts.content_en','posts.content_cn','posts.album_name',
			'posts.restaurant_name','posts.tel','posts.address1',
			'posts.address2','posts.tumbol','posts.amphur','posts.route','posts.route_en','posts.route_cn',
			'posts.province_id','posts.zip','posts.created_at','posts.updated_at','posts.meta_title',
			'posts.meta_description','posts.meta_keywords','posts.slug'));
			//$posts = Post::active()->search($term);*/
		}
		return $items;
	}
	
}

?>