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
 <section class="hero is-success is-bold">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    <a href="<?= $website_url; ?>">
                        <?= $website_name . ' - ' . $website_url; ?>
                    </a>
                </h1>
                <h2 class="subtitle">Website status</h2>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="section">
            <div class="columns">
                <div class="column is-6">
                    <h3 class="subtitle">Details:</h3>
                        <div class="content">
                            <p>Monitoring started: <?= $monitor_started; ?></p>
                            <p>Current status: <?= $monitor_status; ?></p>
                            <p><?= $monitor_info; ?></p>
                            <p>
                            <h3>SSL detail</h3>
                                <p>brand: <?= $website_brand ?></p>
                                <p>product: <?= $website_product ?></p>
                                <p>expires: <?= $website_expires ?></p>
                                Contact support:
                                <span class="icon is-large">
                                    <a href="#" class="has-text-success">
                                        <i class="fas fa-lg fa-envelope"></i>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </ul>
                </div>
                <div class="column is-6">
                    <h3 class="subtitle has-text-centered">Overall uptime: <?= $monitor_uptime; ?>%</h3>
                    <canvas id="uptime"></canvas>
                </div>
            </div>
        </div>
    </div>
    <nav class="top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name">
					<h1><a href="#"><?php echo $websitename; ?></a></h1>
				</li>
				<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
			</ul>
			<section class="top-bar-section">
				<!-- Page Refresh Time -->
				<ul class="right">
					<li class="name"><h1><a href="#"><i class="fi-refresh"></i>&nbsp;Next Update in <span id="timetill"><?php echo $pagerefreshtime ?></span></a></h1></li>
				</ul>
			</section>
		</nav>
		<br>
		<!-- User Defined Alert Bar -->
		<div class="row">
			<?php
			if ($alertEnabled){
				echo "<div data-alert class=\"alert-box $alertType radius\">$alertMessage<a href=\"#\" class=\"close\">&times</a> </div>";
			}
			
			?>
		</div>

		<div class="row">
			<div class="panel radius">
				<div id="reload">
					<?php @include('/MyApp/Ajax.php'); ?>
				</div>
			</div>
		</div>

	
		<div id="logs" class="reveal-modal small" data-reveal></div>
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
                echo "<tr>";
                echo "<td>{$check->getName()} <a href=\"/home/modul/Logs?cid=$key\" data-reveal-id=\"logs\" data-reveal-ajax=\"true\"><i class=\"fi-list-thumbnails\"></i></a> </td>";

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

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                Status page by <a href="https://stevencotterill.co.uk">Steven Cotterill</a>.
                Feel free to use or modify :)
            </p>
        </div>
    </footer>
@endsection



@section('footer_statuspage_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('includes/js/foundation.min.js')}}"></script>
    <script>
        var ctx = document.getElementById("uptime");
        var config = new Chart(ctx,{
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?= $data; ?>],
                    backgroundColor: [<?= $background_colour; ?>],
                    borderColor: [<?= $border_colour; ?>]
                }],
                labels: [<?= $labels; ?>],
            },
			options: {
				responsive: true,
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
        });
        $(document).foundation();
		//Refresh page JS
			$(document).ready(function (e) {
				var $timer = $("#timetill");
				function update() {
					var myTime = $timer.html();
					var ss = myTime.split(":");
					var dt = new Date();
					dt.setMinutes(ss[0]);
					dt.setSeconds(ss[1]);
					var dt2 = new Date(dt.valueOf() - 1000);
					var temp = dt2.toTimeString().split(" ");
					var ts = temp[0].split(":");
					$timer.html(ts[1]+":"+ts[2]);
					if((ts[1]==="00") &&(ts[2]==="00")){
						$("#reload").load("{{ url('/home/statuspage/Ajax.php/') }}");
						$timer.html("<?php echo $pagerefreshtime?>");
						setTimeout(update, 1000);
					}
					else{ setTimeout(update, 1000);}
				}
				setTimeout(update, 1000);
			});
    </script>


@endsection
