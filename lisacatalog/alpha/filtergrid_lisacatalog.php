<!DOCTYPE html>
<html>
    <head>
        <title>Phong's LISA Catalog</title>
        <link rel="stylesheet" type="text/css" href="css/filtergrid.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script src="js/actb.js"></script>
        <script src="js/tablefilter.js"></script>

	</head>
    <body>
        <div id="banner">
            <img id="bannerImg" src="images/directv-logo2.png";/>
            <span id="bannerText">LISA Catalog</span>
        </div>
        <div id="page-wrap">
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
		<table id="table1">
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
		<script language="javascript" type="text/javascript">
			var table1Filters = {
				col_0: "select",
				col_1: "select",
				col_2: "select",
				col_3: "select",
				col_4: "select",
				col_5: "select",
				col_6: "select",
				col_7: "select",
				col_8: "select"
			}
			setFilterGrid("table1",0,table1Filters);
		</script> 	
		</div>
	</body>
</html>
