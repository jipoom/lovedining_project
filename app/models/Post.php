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
		return $this->belongsTo('Category', 'category_id');
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
		return Url::to($this->id);
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
	public static function orderReview($mode, $category,$catName)
	{	
		if($mode == "date"){
			Session::put('mode', 'date');
			Session::put('catName',$catName);
			return Post::where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(8);
			
		}
		else if ($mode == "reviewName"){
			Session::put('mode', 'reviewName');
			Session::put('catName',$catName);
			return Post::where('category_id', '=', $category)->orderBy('title', 'ASC')->paginate(8);
			
		}
		else if ($mode == "restaurantName"){
			Session::put('mode', 'restaurantName');
			Session::put('catName',$catName);
			return Post::where('category_id', '=', $category)->orderBy('restaurant_name', 'ASC')->paginate(8);
			
		}
		else if ($mode == "popularity"){
			Session::put('mode', 'popularity');
			Session::put('catName',$catName);
			return Post::where('category_id', '=', $category)->orderBy('created_at', 'DESC')->paginate(8);
			
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

}
