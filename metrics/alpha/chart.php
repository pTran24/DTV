<!DOCTYPE html>
<html>
	<head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="../js/Chart.js"></script>
		<script type="text/javascript">
			function createChart() {
				var data = {
					labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep"],
					datasets: [
						{
							fillColor: "rgba(225,0,0,1)",
							strokeColor: "rgba(225,0,0,1)",
							data: [12, 16, 13, 15, 18, 21]
						},
						{
							fillColor: "rgba(0,26,225,1)",
							strokeColor: "rgba(0,26,225,1)",
							data: [18, 16, 17, 17, 18, 16]
						},
						{
							fillColor: "rgba(24,31,28,0.5)",
							strokeColor: "rgba(24,31,28,0.5)",
							data: [11, 16, 9, 10, 17, 17]
						}  
					]  
				}
				var cht = document.getElementById('myChart');
				var ctx = cht.getContext('2d');
				var barChart = new Chart(ctx).Line(data);
			}
		</script>
    </head>
    <body onload="createChart();">
		<canvas id="myChart" width="400" height="400"></canvas>
		<?php $labels = '"January", "February", "March", "April", "May", "June", "July"'; ?>
		<p>Hello</p>

	</body>
</html>
