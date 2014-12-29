<!DOCTYPE html>
<html>
    <head>
        <title>Phong's LISA Catalog</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/jquery.dataTables.css" />
	</head>
    <body>
		<div id="banner">
			<img id="bannerImg" src="images/directv-logo2.png";/>
			<span id="bannerText">LISA Catalog</span>
		</div>
		<div id='page-wrap'>
		<?php
			$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","directv");
			if (mysqli_connect_errno($con)){
				echo "Failed to conenct to MySQL: " . mysqli_connecterror();
			}
			$sqlSelect = "SELECT * FROM lisa_catalog;";
			$queryResult = mysqli_query($con, "$sqlSelect") or die(mysqli_error);
			$queryRowNum = mysqli_num_rows($queryResult);
			
			$sqlSelect = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='directv' AND `TABLE_NAME`='lisa_catalog'";
			$columnNames = mysqli_query($con, "$sqlSelect");
			$columnNameRowNum = mysqli_num_rows($columnNames);
			
			for ($i=0;$i<$columnNameRowNum;$i++){
				$name = mysqli_fetch_row($columnNames);
				$columnNameArr[$i] = $name[0];
			}
		?>
		<div id="table_container">
		<!-- Filtering Table -->
			<?php //print Header Column
				$cnt = 1;
				$cnt2 = 0;
				foreach ($columnNameArr as $colName){
					echo "
					<table style='display: inline-block'>
						<tr>
							<th>$colName</th>
						</tr>
						<tr id='filter_col$cnt' data-column='$cnt2'>
							<td><input type='text' class='column_filter' id='col${cnt2}_filter'></td>
							<td class='hidden'><input type='checkbox' class='column_filter' id='col${cnt2}_regex' checked='checked'></td>
							<td class='hidden'><input type='checkbox' class='column_filter' id='col${cnt2}_smart' checked='checked'></td>
						</tr>
					</table>";
					$cnt++;
					$cnt2++;
				}
			?>
		</div>
		<!-- Output Table -->
		<table id='example' class='display'>
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
	</body>
</html>
