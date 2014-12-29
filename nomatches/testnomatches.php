<!DOCTYPE html>
<html>
    <head>
        <title>No-Match Warnings</title>
		<link rel="stylesheet" href="/css/banner.css" />
		<link rel="stylesheet" href="/css/menu.css" />
		<link rel="stylesheet" href="/css/jquery.dataTables.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/js/menu.js" /></script>
        <script src="/js/jquery.dataTables.js"></script>
	</head>
    <body>
		<?php include_once("../menu.html"); ?>
		<div id='page-wrap'>
		<?php
			$con=mysqli_connect("localhost:3333","grapes_sqauser","sq44$3r","lisacatalog");
			#$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","lisacatalog");#MAMP connection
			if (mysqli_connect_errno($con)){
				echo "Failed to conenct to MySQL: " . mysqli_connecterror();
			}
			#$sqlSelect = "SELECT IFNULL(d.environment, 'NULL') as Environment, IFNULL(d.hostip, 'NULL') as HostIP, IFNULL(l.serviceName, 'NULL') as ServiceName, IFNULL(m.imagename, 'NULL') as ImageName, IFNULL(l.status, 'NULL') as Status, IFNULL(l.uptime, 'NULL') as UpTime, IFNULL(l.capacity, 'NULL') as Capacity, IFNULL(l.errors, 'NULL') as Errors, IFNULL(m.lisaproject, 'NULL') as LISAProject, IFNULL(m.port, 'NULL') as Port, IFNULL(m.basepath, 'NULL') as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
			#$sqlSelect = "SELECT server, DATE_FORMAT(date, '%Y-%m-%d') as myDate, serviceName, operation, arguments, count(arguments) FROM `nomatch` GROUP BY server, myDate ORDER BY myDate desc, server, serviceName;";
			$sqlSelect = "SELECT server, DATE_FORMAT(date, '%Y-%m-%d') as myDate, serviceName, operation, count(arguments) FROM `nomatch` GROUP BY server, myDate, arguments ORDER BY myDate desc, server, serviceName;";
			$queryResult = mysqli_query($con, "$sqlSelect") or die(mysqli_error);
			$queryRowNum = mysqli_num_rows($queryResult);
			
			$columnNameArr = [];
			$i = 0;
			while($nameField = mysqli_fetch_field($queryResult)){
				$columnNameArr[$i] = $nameField->name;
				$i++;
			}
		?>
		
		<div id="table_filters">
		<!-- Filtering Table -->
			<?php //print Header Column
				$cnt = 1;
				$cnt2 = 0;
				foreach ($columnNameArr as $colName){
					#if ($colName != 'capacity' && $colName != 'timestamp' && $colName != 'uptime' && $colName != 'errors'){
						echo "
						<table class='filter_table'>
							<tr>
								<th>$colName</th>
							</tr>
							<tr id='filter_col$cnt' data-column='$cnt2'>
								<td><input type='text' class='column_filter' id='col${cnt2}_filter' style='width:100px'></td>
								<td class='hidden'><input type='checkbox' class='column_filter' id='col${cnt2}_regex' checked='checked'></td>
								<td class='hidden'><input type='checkbox' class='column_filter' id='col${cnt2}_smart' checked='checked'></td>
							</tr>
						</table>";
					#}
					$cnt++;
					$cnt2++;
				}
			?>
		</div>
		
		<!-- Output Table -->
		<table id='example' class="hidden">
			<thead>
			<?php //print Header Column
				echo "<tr>";
				foreach ($columnNameArr as $colName){
					echo "<th>$colName</th>";
				}
				echo "</tr>";
			?>
			</thead>
			<tbody>
			<?php //populate data rows
				foreach ($queryResult as $row){
					echo "<tr>";
					foreach ($row as $col){
						echo "<td>$col</td>";
					}
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
		</div>
		<script>
			$(document).ready(function(){
				$("table#example").removeClass("hidden"); //Display table after jquery is applied to prevent double-take effect
            });
		</script>
	</body>
</html>
