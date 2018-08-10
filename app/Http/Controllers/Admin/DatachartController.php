<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\domain;
use App\User;
use Auth;


class DatachartController extends Controller
{
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
$monitor_data = $response->monitors[0];
$monitor_data = array(
    'website_url' => $website_url,
    'website_name' => $website_name,
    'monitor_started' => $monitor_started,
    'monitor_status' => $monitor_status,
    'monitor_info' => $monitor_info,
    'monitor_uptime' => $monitor_uptime,
    'data' => $data,
    'background_colour' => $background_colour,
    'border_colour' => $border_colour,
    'labels' => $labels,
    'monitor_brand' => $monitor_brand,
    'monitor_product' => $monitor_product,
    'monitor_ssl' => $monitor_ssl
    );
print_r($monitor_data);
return view('home',compact('monitor_data'));
    }
}
