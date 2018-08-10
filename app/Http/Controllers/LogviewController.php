<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyApp\Check;
use App\MyApp\StatusPage;
use Auth;


class LogviewController extends Controller
{
    
    /**
     * Determine if the request is the result of an AJAX call.
     * 
     * @return bool
     */
    public function ajax()
    {
        $domainss = Auth::user()->domainss()->get();

     
        require_once(app_path() . '\MyApp\config.php');
        $websitename = $websitename;
        $pagerefreshtime  = $pagerefreshtime;
        $alertEnabled = $alertEnabled;
        $cid =$_GET["cid"];
        //Validation
        if (!is_numeric($cid) || strlen($cid) > 20){
	    die("Invalid Check ID");
        }
        $StatusPage = new StatusPage($apiKey, $historyDay);
        

    
            return view('statuspage',['domainss' => $domainss,'websitename'=>$websitename,'pagerefreshtime'=>$pagerefreshtime,'alertEnabled'=>$alertEnabled]);


    }

    function timeChange($tsstart, $stend, $timezone = 0)
    {
       
       print_r($tsstart);
    $tdelta = strtotime($tsstart) - strtotime($stend);
	$hours=(int)(($tdelta / 3600) + $timezone);
    $minutes = date("i", $tdelta);
    
	return "<td>$hours Hrs, $minutes Mins</td>";
    }
  


}


