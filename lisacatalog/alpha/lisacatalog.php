<!DOCTYPE html>
<html>
    <head>
        <title>LISA Catalog ALPHA</title>
		<link rel="stylesheet" href="css/jquery.dataTables.css" />
		<link rel="stylesheet" href="/css/banner.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jquery.dataTables.js"></script>
	</head>
    <body>
		<div id="banner">
			<img id="bannerImg" src="images/directv-logo2.png";/>
			<div id="bannerText">LISA Catalog ALPHA</div>
		</div>
		<div id="legend">
			<p id="legendHeader">Legend</p>
			<div id="left-arrow" class="triangle-right"></div>
			<!--<div id="right-arrow" class="triangle-left"></div>-->
			
			<div id="legendContext">
				<p>B = Business Call</p>
				<p>P = Application Service Call</p>
			</div>
		</div>
		<div id='page_wrap'>
		
			<?php
				$con=mysqli_connect("localhost:3333","grapes_sqauser","sq44$3r","lisacatalog");
				#$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","lisacatalog");#MAMP connection
				if (mysqli_connect_errno($con)){
					echo "Failed to conenct to MySQL: " . mysqli_connecterror();
				}
				$sqlSelect = "SELECT IFNULL(d.environment, 'NULL') as Environment, IFNULL(d.hostip, 'NULL') as HostIP, IFNULL(l.serviceName, 'NULL') as ServiceName, IFNULL(m.imagename, 'NULL') as ImageName, IFNULL(l.status, 'NULL') as Status, IFNULL(l.uptime, 'NULL') as UpTime, IFNULL(l.capacity, 'NULL') as Capacity, IFNULL(l.errors, 'NULL') as Errors, IFNULL(m.lisaproject, 'NULL') as LISAProject, IFNULL(m.port, 'NULL') as Port, IFNULL(m.basepath, 'NULL') as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
				$queryResult = mysqli_query($con, "$sqlSelect") or die(mysqli_error);
				$queryRowNum = mysqli_num_rows($queryResult);
				
				$columnNameArr = [];
				$i = 0;
				while($nameField = mysqli_fetch_field($queryResult)){
					$columnNameArr[$i] = $nameField->name;
					$i++;
				}
							#<table style='display: inline-table; float:left;'>
			?>
			
			<div id="table_filters">
			<!-- Filtering Table -->
				<?php //print Header Column
					$cnt = 1;
					$cnt2 = 0;
					foreach ($columnNameArr as $colName){
						if ($colName != 'capacity' && $colName != 'timestamp' && $colName != 'uptime' && $colName != 'errors'){
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
						}
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
				$('table#example').removeClass('hidden');
				$('#legend > p').click(function (){
					$("#legendContext").slideToggle(200);
					$("#left-arrow.triangle-right, #left-arrow.triangle-down").toggleClass("triangle-right triangle-down");
					$("#right-arrow.triangle-left, #right-arrow.triangle-down").toggleClass("triangle-left triangle-down");
				});
            });
		</script>
	</body>
</html>
