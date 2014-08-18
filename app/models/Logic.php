<?php


class Logic {	
		
	public static function preparePreselectedCheckBox($all,$allSelected)
	{
		$selectedArray = array();
		$i=0;
		foreach($all as $choice)
		{
		    $check=0;	
			foreach($allSelected as $selected)
			{
				if($selected->id == $choice->id)
				{
					$selectedArray[$i] = 1;
					$check = 1;
					break;
				}
			}
			if($check == 0)
			{
				$selectedArray[$i]=0;
			}
			$i++;
		}
		return $selectedArray;
	}
	
	public static function preparePreselectedSelect($allSelected)
	{
		$selectedArray = array();
		$i=0;
		foreach($allSelected as $selected)
		{
		   $selectedArray[$i] = $selected->id;
		   $i++;
		}
		return $selectedArray;
	}
	
	public static function deployProject()
	{
		//create home ads dir
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').Config::get('app.home')))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').Config::get('app.home'));
		}
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.home')))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.home'));
		}
		
		//create review ads dir
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').Config::get('app.review')))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').Config::get('app.review'));
		}
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.review')))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.review'));
		}
		
		//create user folder
		if(!file_exists(Config::get('app.image_user_path')))
		{
			mkdir(Config::get('app.image_user_path'));
		}
		
		if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.review')))
		{
			mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').Config::get('app.review'));
		}
		
		//Introduction
		if(!file_exists(Config::get('app.image_path') . '/Introduction'))
		{
			mkdir(Config::get('app.image_path') . '/Introduction');
		}
				
		if(count(HighlightOrder::all()) == 0)
		{
			$hMode = new HighlightOrder;
			$hMode -> mode = 'random';
			$hMode -> user_id = '2';
			$hMode -> save();
		}
		
		if(count(CategoryOrder::all()) == 0)
		{
			$cMode = new CategoryOrder;
			$cMode -> mode = 'name';
			$cMode -> user_id = '2';
			$cMode -> save();
		}
		
		
		//Category Folder
		foreach(Category::all() as $category)
		{
			if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$category->album_name))
			{
				mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$category->album_name);
			}
			if(!file_exists(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$category->album_name))
			{
				mkdir(Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$category->album_name);
			}
		}
		
		//Category Folder
		foreach(Post::all() as $post)
		{
			if(!file_exists(Config::get('app.image_path').'/'.$post -> album_name))
			{
				mkdir(Config::get('app.image_path').'/'.$post -> album_name);
				mkdir(Config::get('app.image_path').'/'.$post -> album_name.'/banner');
			}
		}
		
		//Review Folder	
	}
}

?>