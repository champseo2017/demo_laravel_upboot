<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Config;


class LogsController extends Controller
{
   

    public function index()
    {
      
        require_once(app_path() . '\MyApp\Ajax.php');
        require_once(app_path() . '\MyApp\config.php');
         require_once(app_path() . '\MyApp\Check.php');
         require_once(app_path() . '\MyApp\StatusPage.php');
        $websitename = $websitename;
        $pagerefreshtime  = $pagerefreshtime;
        $alertEnabled = $alertEnabled;
        //config('config.websitename');
        // $test= Config::get('websitename');
        // $test=\Config::get('websitename');
        // $test2 = config('pagerefreshtime');
  
        

        


        

        return view('statuspage',compact('websitename','pagerefreshtime','alertEnabled','website_url'));
      


    }
}

