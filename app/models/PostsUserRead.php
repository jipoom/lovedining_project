<?php

use Illuminate\Support\Facades\URL;

class PostsUserRead extends Eloquent 
{

	protected $table = 'posts_user_read'; 
	public static function getUnreadReviews($category,$userId)
	{
		//return Post::where('category_id', '=', $category -> id) -> count() - PostsUserRead::where('user_id', '=', $userId) -> where('category_id', '=', $category -> id) -> count();
		$diff = Post::getReviewsByCategoryUnpaginate(null,$category -> id,'created_at','DESC')->count() - PostsUserRead::join('posts_category','posts_user_read.post_id','=','posts_category.post_id')->where('user_id', '=', $userId) -> where('posts_category.category_id', '=', $category -> id) -> count();
		return $diff;
	
	}
}
