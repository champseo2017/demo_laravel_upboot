<?php
use App\MyApp\Check;
use App\MyApp\StatusPage;
require('config.php');


$StatusPage = new StatusPage($apiKey, $historyDay);

$checks = $StatusPage->getChecks();

if (!$checks){
	echo "<div data-alert class=\"alert-box alert radius\">";
	echo "An error occured, please try again";
	echo "</div>";	
}else{
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
					echo "<tr>";
					echo "<td>{$check->getName()} <a href=\"/home/statuspage/Logs?cid=$key\"><i class=\"fi-list-thumbnails\"></i></a> </td>";

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
		}
		?>
	</tbody>
</table>

