<?php
namespace App\MyApp;
use App\Model\domain;
use App\User;
use Auth;
//Uptime Robot API Key

$domainss = Auth::user()->domainss()->get();
$request_monitors = '';
$monitors_key = [];
  foreach ($domainss as $item) {
array_push($monitors_key, $item->key_id);
  $request_monitors = implode('-',$monitors_key);
  }

$request = '';
$para = array(
        'monitors'=>$request_monitors,
      );
      foreach($para as $key=>$value) {
        $request .= $key.'='.$value; 
      }
      rtrim($request , '&');
     
   
$apiKey ='u616924-aa81a33811d492123ba4eae0'.'&'.$request;


//Text to display on Nav Bar and page title
$websitename = 'Status Page';
//How often the page should refresh the checks
$pagerefreshtime = '01:00';
//Uptime percentage for following days
$historyDay = array(1, 7, 30, 360);
//Display names for the uptime percentage of the previous days
$historyDaysNames = array('last 24 hours', 'last 7 days', 'last 30 days', 'last 12  month');
//On the status page what percentage is what color
$percentGreen = 99;
$percentYellow = 96;
//Display an alert at the top of the page alerting the user
$alertEnabled = False;
//What type of message could be displayed (sucess, warning, info, alert, secondary, standard)
//You can see what each color looks like here: http://foundation.zurb.com/docs/components/alert_boxes.html
$alertType = 'warning';
//What the alert box should say
$alertMessage = 'We are working on the downtime';
//checks to exclude from the status page. This info can be found in the UptimeRobot URL for each check
//$excludedchecks = array("776396792", "776396743");
$excludedChecks = array();

 


