<?php

class Picture extends Eloquent {

	public static function directoryToArray($directory, $recursive) {
		$array_items = array();
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (!is_dir($directory . "/" . $file)) {
						$array_items[] = preg_replace("/\/\//si", "/", $file);
					}
				}
			}
			closedir($handle);
		}
		return $array_items;
	}
	public static function recursive_copy($src,$dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                recursive_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
    closedir($dir);
	}
	
	//Unused
	/*
	public static function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}*/
	
   public static function recursive_remove($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") self::recursive_remove($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 }
   public static function getRandomPicture($pictureArray)
   {
   		$n = count($pictureArray);
		$index = rand(0,$n-1);
		return $pictureArray[$index];
   }
   
   public static function getAdsSide($album_name)
   {
   		$adsSideDir = Config::get('app.image_path').'/'.Config::get('app.ads_sidebar_prefix').$album_name;
		$allSideAds = Picture::directoryToArray($adsSideDir,false);
		if(!file_exists($adsSideDir) || count($allSideAds) == 0){
			
			//$adsSide = "http://placehold.it/260x800";
			$adsSide = "";
		}
		else {
			//$allSideAds = Picture::directoryToArray($adsHomeSideDir,false);
			$ads = Picture::getRandomPicture($allSideAds);
			$adsSide = Config::get('app.image_base_url').'/'.Config::get('app.ads_sidebar_prefix').$album_name.'/'.$ads;
		}
		return $adsSide;
   }
    public static function getAdsFoot($album_name)
   {
		$adsFootDir = Config::get('app.image_path').'/'.Config::get('app.ads_footer_prefix').$album_name;
		$allFootAds = Picture::directoryToArray($adsFootDir,false);

		if(!file_exists($adsFootDir) || count($allFootAds) == 0){
			$adsFoot = "";	
			//$adsFoot = "http://placehold.it/750x300";
		}
		else {
			$ads = Picture::getRandomPicture($allFootAds);
			$adsFoot = Config::get('app.image_base_url').'/'.Config::get('app.ads_footer_prefix').$album_name.'/'.$ads;
		}
		return $adsFoot;
   }
   

}
