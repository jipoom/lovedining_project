<?php

use Illuminate\Support\Facades\URL;

class PostsUserRead extends Eloquent 
{

	protected $table = 'posts_user_read'; 
	public static function getUnreadReviews($category,$userId)
	{
		return Post::where('category_id', '=', $category -> id) -> count() - PostsUserRead::where('user_id', '=', $userId) -> where('category_id', '=', $category -> id) -> count();
	}
}
