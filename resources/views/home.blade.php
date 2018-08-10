@extends('layouts.app')
@section('head_style')
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icons/apple-touch-icon-57x57.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/apple-touch-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icons/apple-touch-icon-60x60.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icons/apple-touch-icon-76x76.png')}}">
<link rel="icon" type="image/png" href="{{ asset('icons/favicon-96x96.png')}}" sizes="96x96">
<link rel="icon" type="image/png" href="{{ asset('icons/favicon-16x16.png')}}" sizes="16x16">
<link rel="icon" type="image/png" href="{{ asset('icons/favicon-32x32.png')}}" sizes="32x32">
<link rel="stylesheet" href="{{ asset('includes/css/normalize.css')}}">
<link rel="stylesheet" href="{{ asset('includes/css/foundation.min.css')}}">
<link rel="stylesheet" href="{{ asset('includes/css/app.css')}}">
<link rel="stylesheet" href="{{ asset('includes/css/foundation-icons.css')}}">
@endsection
@section('content')
        @php
    $test = [];
    $request_monitors = '';
	$monitors_key = [];
    foreach ($domainss as $item) {
array_push($monitors_key, $item->key_id);
		$request_monitors = implode('-',$monitors_key);
    }
@endphp
@php
$request = '';
$para = array(
           'api_key' =>'u616924-aa81a33811d492123ba4eae0',
		   'monitors'=>$request_monitors,
           'format' => 'json',
           'logs'=> 1,
           'log_types'=>1,
           'logs_limit'=>1,
           'all_time_uptime_ratio'=>1,
        );
        foreach($para as $key=>$value) {
             $request .= $key.'='.$value.'&'; 
        }
        rtrim($request, '&');
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
        $test[] = json_decode($response,true);
@endphp
<?php
$monitors_id = [];
$monitors_id_count = '';
$total = [];
$totalcount = '';
$site_total = [];
$domain_run = [];
$all_time_uptime_ratio = [];
$cer = [];  
 foreach($test  as $countdomain){
	$total = $countdomain['monitors'];
	$totalcount = count($total);
 }
 foreach($test  as $site){
	$site_total = $site['pagination']['total'];
	$domain_run = $site['pagination']['total'];
	 echo "<h3>Total Site: $site_total</h3>";
	 echo "<h3>Domain Run: $domain_run</h3>";
	 foreach($site['monitors'] as $site_2){
		$all_time_uptime_ratio = $site_2['all_time_uptime_ratio'];
		$cer = $site_2['ssl']['expires'];
		$monitors_id = $site_2['id'];
	 }
	 if($all_time_uptime_ratio < '100.000'){
		echo $totalcount;
	 }else{
		 echo "<h3>DoMain Down</h3><span>0</span>";
	 }
	 if($monitors_id != $cer){
		echo "<h3>DoMain expired</h3><span>0</span>";
	 }else{
		 echo $totalcount;
	 }
	 
	 	 
 }

?>
<h4>Uptime Report</h4>
	<table style="width: 100%;">
		<thead>
			<tr>
				<th>Check Name</th>
				<th class="text-center">Current Status</th>
				<?php
				foreach ($historyDaysNames as $historyDaysName) {
					echo "<th class=\"text-center hide-for-small-only\">$historyDaysName</th>";
				}
				
				?>
				
				<th class="text-center hide-for-small-only">Total Check History</th>
			</tr>
		</thead>
		<tbody>

			<?php
			foreach ($checks as $key => $check) {
				
				if (!in_array($check->getID(), $excludedChecks))
				{
					$para = array(
						'monitors'=>$check->getID(), 
					 );
					$key_id = implode('-',$para);
					echo "<tr>";
					echo "<td>{$check->getName()} <a href=\"/home/gramp/$key_id\" target='_blank'><i class=\"fi-list-thumbnails\"></i></a> </td>";

					if ($check->getStatus() == 2) {
						echo "<td class=\"green text-center\">Online</td>";
					}elseif ($check->getStatus() == 1) {
						echo "<td class=\"grey text-center\">Pending</td>";
					}elseif ($check->getStatus() == 0) {
						echo "<td class=\"grey text-center\">Paused</td>";
					}else{
						echo "<td class=\"red text-center\">Offline</td>";
					}

					foreach ($check->getUptimeRatios() as $uptimeratio) {
						if ($uptimeratio >= $percentGreen){
							echo "<td class=\"green text-center hide-for-small-only\">$uptimeratio%</td>";
						}elseif ($uptimeratio >= $percentYellow) {
							echo "<td class=\"yellow text-center hide-for-small-only\">$uptimeratio%</td>";
						}else{
							echo "<td class=\"red text-center hide-for-small-only\">$uptimeratio%</td>";
						}
					}

					if ($check->getAllUptime() >= $percentGreen){
						echo "<td class=\"green text-center hide-for-small-only\">{$check->getAllUptime()}%</td>";
					}elseif ($check->getAllUptime() >= $percentYellow) {
						echo "<td class=\"yellow text-center hide-for-small-only\">{$check->getAllUptime()}%</td>";
					}else{
						echo "<td class=\"red text-center hide-for-small-only\">{$check->getAllUptime()}%</td>";
					}

					echo "</tr>";
				}
			}
		?>
	</tbody>
</table>


@endsection

@section('footer_statuspage_script')

@endsection