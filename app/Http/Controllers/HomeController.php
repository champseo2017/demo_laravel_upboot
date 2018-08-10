<?php

namespace App\Http\Controllers;
use App\Model\domain;
use App\User;
use Auth;
use Config;
use App\MyApp\Check;
use App\MyApp\StatusPage;



use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function test()
    {
        $domainss = Auth::user()->domains()->get();
        return view('test', ['domainss' => $domainss]);
    }
    public function grap($key_id)
    {
        require_once(app_path() . '\MyApp\config.php');
        require_once(app_path() . '\MyApp\Check.php');
        require_once(app_path() . '\MyApp\StatusPage.php');
       $websitename = $websitename;
       $pagerefreshtime  = $pagerefreshtime;
       $alertEnabled = $alertEnabled;
       $StatusPage = new StatusPage($apiKey, $historyDay);
       $checks = $StatusPage->getChecks();
        // $api_key= Auth::user()->api_key;
        $api_key = 'u616924-aa81a33811d492123ba4eae0';
       
        // Build request:
    $request = 'api_key=' . $api_key . '&format=json&logs=1&log_types=1&logs_limit=1&all_time_uptime_ratio=1&monitors='.$key_id;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.uptimerobot.com/v2/getMonitors',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                'cache-control: no-cache',
                'content-type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // Decode JSON response and get only the data needed:
$response = json_decode($response);
// var_dump($response);
$stat = $response->stat;
$monitors_keydata = $response->monitors[0]->id;

$strAction = isset($response->error->message) ? $response->error->message : '';
if($strAction != 'api_key not found.')
	{
      
        $response = $response->monitors[0];
        // Website details:
$website_name = $response->friendly_name;
$website_url = $response->url;
// Website ssl:
$website_brand = $response->ssl->brand;
$website_product = $response->ssl->product;
$website_expires = $response->ssl->expires;
$website_expires = date('jS F Y', $website_expires);
$website_ssl = $response->ssl;
// Date monitor was created:
$monitor_started = $response->create_datetime;
$monitor_started = date('jS F Y', $monitor_started);
// Overall uptime percentage:
$monitor_uptime = $response->all_time_uptime_ratio;
$monitor_uptime = number_format($monitor_uptime, 2);
// Overall downtime percentage:
$monitor_downtime = 100 - $monitor_uptime;
$monitor_downtime = number_format($monitor_downtime, 2);
// Data to be passed to chart. Hide downtime if there is none:
    if ($monitor_downtime == 0) {
        $data = $monitor_uptime;
        $background_colour = '\'#13B132\'';
        $border_colour = '\'#13B132\'';
        $labels = '\'Uptime\'';
    } else {
        $data = $monitor_uptime . ', ' . $monitor_downtime;
        $background_colour = '\'#13B132\', \'#F42121\'';
        $border_colour = '\'#13B132\', \'#F42121\'';
        $labels = '\'Uptime\', \'Downtime\'';
    }
// Current website status:
$monitor_status = $response->status;
// Change content to be displayed based on current website status:
if ($monitor_status == 0) { // Monitor is paused:
    $monitor_status = 'The monitor is currently paused. This may be for website updates/maintenance';
    $monitor_info = 'Please check again later for an updated status report';
} elseif ($monitor_status == 2) { // Website is up:
    $monitor_status = 'Website is currently UP' .
    '<span class="icon is-large has-text-success"><i class="fas fa-lg fa-check"></i></span>';
    // Check if there has been any recorded downtime:
    if (empty($response->logs)) { // Downtime recorded:
        $monitor_info = 'There has been no recorded downtime';
    } else { // No downtime recorded:
        // Get date of last downtime:
        $monitor_last_downtime = $response->logs[0]->datetime;
        $monitor_last_downtime = date('jS F Y', $monitor_last_downtime);
        // Get time since last downtime in hours:
        $time_downtime = strtotime($monitor_last_downtime);
        $time_current = time();
        $time_since_downtime = $time_current - $time_downtime;
        $time_since_downtime = floor($time_since_downtime / 3600);
        $monitor_info = 'It has been ' . $time_since_downtime . ' hours (' . $monitor_last_downtime . ') since any downtime';
    }
} elseif ($monitor_status == 9) { // Website is down:
    $monitor_status = 'Website is currently UP' .
    '<span class="icon is-large has-text-danger"><i class="fas fa-lg fa-times"></i></span>';
    // Get length of current downtime in hours:
    $monitor_downtime_seconds = $response->logs[0]->duration; // Seconds
    $monitor_downtime_hours = floor($monitor_downtime_seconds / 3600); // Hours
    $monitor_info = 'The website is currently down. It has been down for' . $monitor_downtime_hours . ' hours';
} 
    }
   elseif($stat == 'ok'){

   }
return view('test',compact('website_url','website_name','monitor_started','monitor_status','monitor_info','monitor_uptime','data','background_colour','labels','border_colour','website_brand','website_product','website_expires','website_create_datetime','website_create_type','website_create_datetime','website_create_duration','website_create_code','website_create_detail','response','api_key','strAction','stat','array','websitename','pagerefreshtime','alertEnabled','StatusPage','checks','historyDaysNames','excludedChecks','percentGreen'));   
    }

    public function index()
    {

     
        require_once(app_path() . '\MyApp\config.php');
         require_once(app_path() . '\MyApp\Check.php');
         require_once(app_path() . '\MyApp\StatusPage.php');
        $websitename = $websitename;
        $pagerefreshtime  = $pagerefreshtime;
        $alertEnabled = $alertEnabled;
        $StatusPage = new StatusPage($apiKey, $historyDay);
        $checks = $StatusPage->getChecks();
        //config('config.websitename');
        // $test= Config::get('websitename');
        // $test=\Config::get('websitename');
        // $test2 = config('pagerefreshtime');
        $domainss = Auth::user()->domainss()->get();
       
     
        return view('home',compact('websitename','pagerefreshtime','alertEnabled','StatusPage','checks','historyDaysNames','excludedChecks','percentGreen','domainss'));
}
}