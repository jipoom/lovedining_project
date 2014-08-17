<?php

class AdminAdsController extends AdminController {


    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = "Ads Management";
		
        // Grab all the blog posts
        $categories = Category::all();

		//create home ads dir
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix')."Home"))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix')."Home");
		}
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix')."Home"))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix')."Home");
		}
		//create review ads dir
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix')."Review"))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix')."Review");
		}
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix')."Review"))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix')."Review");
		}

        // Show the page
        return View::make('admin/ads/index', compact('categories', 'title'));
    }


}