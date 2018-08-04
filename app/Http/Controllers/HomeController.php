<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Model\domain;
use App\User;
use Auth;

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

    public function index()
    {
        $api_key = '';
        $user = auth()->user();
        $domainss = $user->domainss()->get();
       
        foreach ($domainss as $domains) {
            $api_key = $domains->number;
        }
        // Build request:
        $request = 'api_key=' . $api_key . '&format=json&logs=1&log_types=1&logs_limit=1&all_time_uptime_ratio=1';
        // Access API via cURL:
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.uptimerobot.com/v2/getMonitors',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
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
$response = $response->monitors[0];
print_r($response );







       return view('home',compact('domainss','api_key'));
      
    }
}
