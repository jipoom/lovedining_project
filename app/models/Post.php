<?php

use Illuminate\Support\Facades\URL;

class Post extends Eloquent {

	/**
	 * Deletes a blog post and all
	 * the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		$this->comments()->delete();

		// Delete the blog post
		return parent::delete();
	}

	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->content);
	}
	public function content_en()
	{
		return nl2br($this->content_en);
	}
	public function content_cn()
	{
		return nl2br($this->content_cn);
	}

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Get the post's comments.
	 *
	 * @return array
	 */
	public function comments()
	{
		return $this->hasMany('Comment');
	}
	
	public function campaign()
	{
		return $this->hasMany('Campaign');
	}
	
	public function category()
	{
		return $this->belongsToMany('Category','posts_category');
	}
	
	public function read()
	{
		return $this->belongsToMany('User','posts_user_read');
	}
	
	public function foodType()
	{
		return $this->belongsToMany('FoodType','posts_food_type');
	}
	
	public function meal()
	{
		return $this->belongsToMany('Meal','posts_meal');
	}
	
	public function dressing()
	{
		return $this->belongsToMany('Dressing','posts_dressing');
	}
	
	public function statistic()
	{
		return $this->belongsToMany('Category','statistic');
	}
    /**
     * Get the date the post was created.
     *
     * @param \Carbon|null $date
     * @return string
     */
    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }

	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return Url::to("review/".$this->id."/".Session::get('Lang'));
	}

	/**
	 * Returns the date of the blog post creation,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function created_at()
	{
		return $this->date($this->created_at);
	}

	/**
	 * Returns the date of the blog post last update,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function updated_at()
	{
        return $this->date($this->updated_at);
	}	
	
	public function tumbol()
	{
		return $this->belongsTo('Tumbol','tumbol_id');
	}
	public function province()
	{
		return $this->belongsTo('Province','province_id');
	}
	public function amphur()
	{
		return $this->belongsTo('Amphur','amphur_id');
	}
	
	public static function findImages($content)
	{
		$i = 0;
			$end = 0;
			$image = array();
			while(true)
			{
				if(strpos($content,'/images/user/'))		
				{
					$start = strpos($content,'/images/user/')+13;
					$stop = strpos($content,'" alt="');
					$gap = $stop-$start;
					$image[$i] =  substr($content,$start,$gap);
					$content = substr($content,$stop+7);
					$i++;
				}
				else
				{
					break;
				}
				
			}
			return $image;
	}
	public static function orderReview($post,$mode, $category,$catName)
	{	
		if($mode == "date"){
			Session::put('mode', 'date');
			Session::put('catName',$catName);
			//return Post::where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(8);
			return Post::getReviewsByCategory($post,$category,'created_at','DESC');
			
		}
		else if ($mode == "reviewName"){
			Session::put('mode', 'reviewName');
			Session::put('catName',$catName);
			//return Post::where('category_id', '=', $category)->orderBy('title', 'ASC')->paginate(8);
			return Post::getReviewsByCategory($post,$category,'title','ASC');
			
		}
		else if ($mode == "restaurantName"){
			Session::put('mode', 'restaurantName');
			Session::put('catName',$catName);
			//return Post::where('category_id', '=', $category)->orderBy('restaurant_name', 'ASC')->paginate(8);
			return Post::getReviewsByCategory($post,$category,'restaurant_name','ASC');
			
		}
		else if ($mode == "popularity"){
			Session::put('mode', 'popularity');
			Session::put('catName',$catName);
			return Statistic::getPopularReviews($category,$post);
			/*$posts = array();
			$i=0;
			foreach ($popularIds as $popularId)
			{
				$posts[$i] = Post::find($popularId);
				$i++;
			}		
			return $posts;*/
		}
		 
	}
	public static function getRandomReviews()
	{
		$posts = Post::where('profile_picture_name','<>','')->get();
		if(count($posts) <= 5)
		{
			return $posts;
		}
		else
		{
			for($i=0;$i<5;$i++)
			{
				$index = rand(0,count($posts)-1);
				if(empty($randReviewsTemp[$index]))
				{
					$randReviewsTemp[$index] = $posts[$index];
					$randReviews[$i] = $posts[$index];
				}
				else
				{
					$i--;
				}				
			}
			return $randReviews;
		}
	}
	
	public static function getRecentReviews()
	{
		$posts = Post::where('profile_picture_name','<>','')->active()->orderBy('created_at','DESC')->take(5)->get();
		return $posts;
	}
	
	public static function getReviewsByCategory($post,$categoryId,$orderBy,$mode)
	{
		
		 if(!$post)
		 	$post = new Post;
		 if($categoryId!="undefined")	
		 {	
			 return $post->active()->join('posts_category', 'posts.id', '=', 'posts_category.post_id')
				-> join('category', 'posts_category.category_id', '=', 'category.id')
				-> where('category.id', '=', $categoryId)
				//where date > published_date
				//where date < expired_date
				-> orderBy($orderBy, $mode)
				->paginate(8,array('posts.id', 'posts.user_id', 'posts.title', 'posts.title_2', 
				'posts.profile_picture_name','posts.content','posts.content_en','posts.content_cn','posts.album_name',
				'posts.restaurant_name','posts.tel','posts.address1',
				'posts.address2','posts.tumbol','posts.amphur','posts.route','posts.route_en','posts.route_cn',
				'posts.province_id','posts.zip','posts.created_at','posts.updated_at'));
		 }
		 //If user searches with a keyword
		 else {
			 return $post->orderBy($orderBy, $mode)->paginate(8,array('posts.id', 'posts.user_id', 'posts.title', 'posts.title_2', 
				'posts.profile_picture_name','posts.content','posts.content_en','posts.content_cn','posts.album_name',
				'posts.restaurant_name','posts.tel','posts.address1',
				'posts.address2','posts.tumbol','posts.amphur','posts.route','posts.route_en','posts.route_cn',
				'posts.province_id','posts.zip','posts.created_at','posts.updated_at'));
		 }
	}
	
	public static function search($keyword,$sort)
	{

		$wordTemp = explode(' ', $keyword);
		if(!$sort)	
		{
			foreach($wordTemp as $term)
			{
			    //where date > published_date
				//where date < expired_date	
			    //$posts = Post::where('title', 'LIKE', '%'. $term .'%')->orwhere('restaurant_name', 'LIKE', '%'. $term .'%')->paginate(8);
				$posts =Post::active()->join('province','province.id','=','posts.province_id')->where(function($query) use ($term)
	            {
	                $query->where('restaurant_name', 'LIKE',  '%'. $term .'%')
	                      ->orwhere('title', 'LIKE', '%'. $term .'%')
						  ->orwhere('province.province_name', 'LIKE', '%'. $term .'%')
						  ->orwhere('province.province_name_en', 'LIKE', '%'. $term .'%')
						  ->orwhere('amphur', 'LIKE', '%'. $term .'%')
						  ->orwhere('tumbol', 'LIKE', '%'. $term .'%');

	            })->paginate(8,array('posts.id', 'posts.user_id', 'posts.title', 'posts.title_2', 
				'posts.profile_picture_name','posts.content','posts.content_en','posts.content_cn','posts.album_name',
				'posts.restaurant_name','posts.tel','posts.address1',
				'posts.address2','posts.tumbol','posts.amphur','posts.route','posts.route_en','posts.route_cn',
				'posts.province_id','posts.zip','posts.created_at','posts.updated_at'));
				//$posts = Post::active()->search($term);
			}
		}
		else {
			foreach($wordTemp as $term)
			{
			   //where date > published_date
				//where date < expired_date
			    //$posts = Post::where('title', 'LIKE', '%'. $term .'%')->orwhere('restaurant_name', 'LIKE', '%'. $term .'%')->distinct();
				$posts =Post::active()->join('province','province.id','=','posts.province_id')->where(function($query) use ($term)
	            {
	                $query->where('restaurant_name', 'LIKE',  '%'. $term .'%')
	                      ->orwhere('title', 'LIKE', '%'. $term .'%')
						  ->orwhere('title_2', 'LIKE', '%'. $term .'%')
						  ->orwhere('province.province_name', 'LIKE', '%'. $term .'%')
						  ->orwhere('province.province_name_en', 'LIKE', '%'. $term .'%')
						  ->orwhere('amphur', 'LIKE', '%'. $term .'%')
						  ->orwhere('tumbol', 'LIKE', '%'. $term .'%');
	            });
			}
		}
		return $posts;
	}
	
	
	public function scopeActive($query)
    {
      
	    return $query-> whereRaw('(UNIX_TIMESTAMP(published_at) <= UNIX_TIMESTAMP(now())) and (is_permanent = 1 or UNIX_TIMESTAMP(expired_at) > UNIX_TIMESTAMP(now()))');
    }
	public function scopeSearch($query,$term)
    {
	    	
		return $query-> whereRaw('(title LIKE %'.$term.'%) or (restaurant_name LIKE %'.$term.'%)');      
	}
	
	public static function sendEmail($subject,$emailTitle, $post,$user,$publishedDate)
	{
		$data = array(
						'emailTitle' => $emailTitle, 
						'url' => Config::get('app.host_name').'/review'.$post->id."/TH",
						'firstname'=>$user->firstname,
						'postTitle'=>$post->title.' '.$post->title_2,
						'album_name'=>$post->album_name,
						'profile_picture_name'=>$post->profile_picture_name,
						'postTitle'=>$post->title,
						'restaurant'=>$post->restaurant_name,
						'publishedDate'=>$publishedDate
						
						);
					Mail::queue('emails.review.information', $data, function($message) use ($user,$subject)
					{
					  $message->to($user->email)
					          ->subject($subject);
					});
	}
	


}
