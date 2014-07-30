<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('category', 'Category');
Route::model('campaign', 'Campaign');
Route::model('role', 'Role');
Route::model('message', 'PrivateMessage');
Route::model('introduction', 'Introduction');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('category', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{postId}/view_comments', 'AdminCommentsController@getSelectedComments');
	Route::get('comments/data/{postId}', 'AdminCommentsController@getData');
  	Route::get('comments/{comment}/index', 'AdminCommentsController@getIndex');
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{catId}/view_blogs', 'AdminBlogsController@getSelectedPosts');
	Route::get('blogs/data/{catId}', 'AdminBlogsController@getData');
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
	Route::get('blogs/makeDir/{new}/{postId}','AdminBlogsController@makeDir');
	Route::get('blogs/create','AdminBlogsController@getCreate');
	Route::get('blogs/{directory}/{postId}','AdminBlogsController@getIndex');	
    Route::controller('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

	# Category Order Management
	Route::get('order/{category}/show', 'AdminOrderController@getShow');
    Route::get('order/{mode}', 'AdminOrderController@changeOrder');
	Route::get('order/save/{mode}', 'AdminOrderController@saveOrder');
    Route::controller('order', 'AdminOrderController');
	
	# Category Management
	
	Route::get('category/{category}/show', 'AdminCategoryController@getShow');
    Route::get('category/{category}/edit', 'AdminCategoryController@getEdit');
    Route::post('category/{category}/edit', 'AdminCategoryController@postEdit');
    Route::get('category/{category}/delete', 'AdminCategoryController@getDelete');
    Route::post('category/{category}/delete', 'AdminCategoryController@postDelete');
    Route::controller('category', 'AdminCategoryController');
	
	# Campaign Management
	Route::get('campaign/{campaign}/show', 'AdminCampaignController@getShow');
    Route::get('campaign/{campaign}/edit', 'AdminCampaignController@getEdit');
    Route::post('campaign/{campaign}/edit', 'AdminCampaignController@postEdit');
    Route::get('campaign/{campaign}/delete', 'AdminCampaignController@getDelete');
    Route::post('campaign/{campaign}/delete', 'AdminCampaignController@postDelete');
    Route::controller('campaign', 'AdminCampaignController');
	
	# Introduction Management
	Route::get('introduction', 'AdminIntroductionController@getCreate');
	Route::post('introduction', 'AdminIntroductionController@postCreate');
    Route::get('introduction/{introduction}/edit', 'AdminIntroductionController@getEdit');
    Route::post('introduction/{introduction}/edit', 'AdminIntroductionController@postEdit');
    //Route::get('introduction/{introduction}/delete', 'AdminIntroductionController@getDelete');
    //Route::post('introduction/{introduction}/delete', 'AdminIntroductionController@postDelete');
    Route::controller('introduction', 'AdminIntroductionController');
	
	# Ads Management
    Route::controller('ads', 'AdminAdsController');
	
	#File Manager
	Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
    Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
	Route::get('elfinder/tinymce', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4');
	Route::get('elfinder/tinymce/{dirName}', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4Test');
	Route::get('elfinder/default/{dirName}', 'Barryvdh\Elfinder\ElfinderController@showDefault');
	
    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

Route::group(array('prefix' => 'message_service', 'before' => 'auth'), function()
{
	# Private Message	
	Route::get('view/{message}', 'PrivateMessageController@getMessage');
    Route::get('reply/{message}', 'PrivateMessageController@getReply');
    Route::post('reply/{message}', 'PrivateMessageController@postReply');
	Route::get('{message}/delete', 'PrivateMessageController@getDelete');
    Route::post('{message}/delete', 'PrivateMessageController@postDelete');
	Route::get('search', 'PrivateMessageController@autocomplete');
    Route::controller('', 'PrivateMessageController');
});

# Posts - Second to last set, match slug
Route::get('{postId}', 'BlogController@getView');
Route::post('{postId}', 'BlogController@postView');
Route::get('{postId}/album', 'BlogController@getAlbum');
# Category - ID
//Route::get('category/{categoryId}/{mode}', 'BlogController@getCategory');

Route::group(array('prefix' => 'category'), function()
{
	 Route::get('{categoryId}/{mode}/{keyword?}', 'BlogController@getCategoryMode');
	 Route::get('{categoryId}/', 'BlogController@getCategory');
});

# Search

Route::group(array('prefix' => 'search'), function()
{
	 Route::get('{keyword}', 'BlogController@searchReview');
});


# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
