<?php
namespace Barryvdh\Elfinder;

use Config;
use View;

class ElfinderController extends \BaseController
{
    protected $package = 'laravel-elfinder';

    public function showIndex()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::elfinder')->with(compact('dir', 'locale'));
    }
	
	public function showDefault($dirName = null)
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::elfinder')->with(compact('dir', 'locale','dirName'));
    }

    public function showTinyMCE()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::tinymce')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::tinymce4')->with(compact('dir', 'locale','dirName'));
    }
	
	public function showTinyMCE4Test($dirName = null)
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::tinymce4')->with(compact('dir', 'locale','dirName'));
    }

    public function showCKeditor4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = Config::get('app.locale');
        if (!file_exists(public_path() . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return View::make($this->package . '::ckeditor4')->with(compact('dir', 'locale'));
    }

    public function showConnector()
    {
        $dir = Config::get($this->package . '::dir'). "/" . $_REQUEST['_dirName'];
        $roots = Config::get($this->package . '::roots');

        if (!$roots)
        {
            $roots = array(
                array(
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path() . DIRECTORY_SEPARATOR . $dir , // path to files (REQUIRED)
                    'URL' => asset($dir), // URL to files (REQUIRED)
                    'accessControl' => Config::get($this->package . '::access') // filter callback (OPTIONAL)
                )
            );
        }

        // Documentation for connector options:
        // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
        $opts = array(
        'bind' => array(
	        'upload.presave' => array(
	            'Plugin.AutoResize.onUpLoadPreSave'
	        )
	    ),
	    'plugin' => array(
	        'AutoResize' => array(
	        'enable' => true,
	        'maxWidth'  => 2400,
	        'maxHeight'  => 1600,
	        'quality' => 75
	        )
	    ),
            'roots' => $roots
        );

        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}
