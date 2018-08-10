<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyApp\Check;
use App\MyApp\StatusPage;
use Auth;

use Config;

class ModulController extends Controller
{
    public function index()
    {
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
        $checks = $StatusPage->getChecks();
if (!$checks){
	echo "<div data-alert class=\"alert-box alert radius\">";
	echo "An error occured, please try again";
	echo "</div>";	
}else{
	echo "<h4>{$checks[$cid]->getName()}</h4>";
	echo "<hr>";
	?>
	<table style="width: 100%;">
		<thead>
			<tr>
				<th>Event</th>
				<th>Date-Time</th>
				<th>Duration</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$logs = $checks[$cid]->getLogs();
				foreach ($logs as $key => $log) {
					echo "<tr>";
					if ($log['type'] == 1){
						echo "<td><div class=\"alert label radius\"><i class=\"fi-arrow-down\"></i> Down</div></td>";
					}elseif ($log['type'] == 2) {
						echo "<td><div class=\"success label radius\"><i class=\"fi-arrow-up\"></i> Up</div></td>";
					}elseif ($log['type'] == 98) {
						echo "<td><div class=\"secondary label radius\"><i class=\"fi-play\"></i> Started</div></td>";
					}elseif ($log['type'] == 99) {
						echo "<td><div class=\"secondary label radius\"><i class=\"fi-pause\"></i> Paused</div></td>";
					}
					echo "<td>$log[datetime]</td>";

					if ($key == 0){
						echo $this->timeChange(date('d-n-Y H:i:s'), $log['datetime'], $checks[$cid]->getTZ());
					}else {
						echo $this->timeChange($logs[$key-1]['datetime'], $log['datetime']);
					}
                    echo "</tr>";
                   
                }
                
                
            }
            echo "<a class=\"close-reveal-modal\">&#215;</a>"; 
           
            
    }
    
    
    function timeChange($tsstart, $stend, $timezone = 0)
    {
       
       
    $tdelta = strtotime($tsstart) - strtotime($stend);
	$hours=(int)(($tdelta / 3600) + $timezone);
    $minutes = date("i", $tdelta);
    
	return "<td>$hours Hrs, $minutes Mins</td>";
    }
    

    
}
