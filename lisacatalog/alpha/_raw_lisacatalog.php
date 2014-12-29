<!DOCTYPE html>
<html>
    <head>
        <title>Phong's LISA Catalog</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jquery.tablesorter.js"></script>
        <link rel="stylesheet" href="css/jquery.dataTables.css" />
	</head>
    <body>
		<?php
			$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","directv");
			if (mysqli_connect_errno($con)){
				echo "Failed to conenct to MySQL: " . mysqli_connecterror();
			}
			$sqlSelect = "SELECT * FROM lisa_catalog LIMIT 10;";
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
		<table>
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
	</body>
</html>
