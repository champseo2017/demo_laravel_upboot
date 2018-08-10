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
					<?php @include('/MyApp/Ajax.php') ?>
					
				</div>
			</div>
		</div>
		
@endsection
@section('log-ajax')
<div id="logs" class=" small" data-reveal></div>
@endsection
@section('footer_statuspage_script')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('includes/js/foundation.min.js')}}"></script>

<script>
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

