<!DOCTYPE html>
<html>
	<head>
		<title>Deleted Record History</title>
		<link rel="stylesheet" href="/css/banner.css" />
        <link rel="stylesheet" href="/css/menu.css" />
        <link rel="stylesheet" href="/css/network.css" />
        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/menu.js" /></script>
    </head>
    <body>
        <?php include_once("../menu.html"); ?>	
		<div id="page-wrap">
			<?php //CREATE CONNECTION, GET FORM INFORMATION
				// Create connection
				$con=mysqli_connect("localhost:3333","grapes_sqauser","sq44$3r", "networkreference");
				$masterPassword = 'testing';
				if (mysqli_connect_errno($con)){
					//Check connection
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$resultClause = "SELECT * FROM recyclebin";
				$resultQuery = mysqli_query($con, $resultClause);
				$querySize = mysqli_num_rows($resultQuery);
			?>
			
			<?php //FUNCTION DEFINITION
				function storeColumns(&$con){
					//Grabs titles from the database of the column titles, returns an array.
					$columnNames = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='networkreference' AND `TABLE_NAME`='recyclebin'";
					$columnNames = mysqli_query($con, $columnNames);
					$numColumns = mysqli_num_rows($columnNames);
					for ($i=0; $i<$numColumns; $i++){
						$column = mysqli_fetch_row($columnNames);
						$columnArray[$i] = $column[0];
					}
					return $columnArray;
				}
			?>
			<h2>Networkflows Form Deletion History</h2>
			<?php //OUTPUT COLUMN HEADERS
				$columnTitles = storeColumns($con);
				echo "<table border='1' cellspacing='2'>";
				echo "<th>Entry number</th>";
				foreach($columnTitles as $value){
					echo "<th>" . $value . "</th>";
				}
			?>
			<?php //OUTPUT VALUES
				for ($i=0; $i<$querySize; $i++){
					$row = mysqli_fetch_array($resultQuery);
					$environmentValue = $row['environment'];
					$typeValue = $row['type'];
					$sourceLocationValue = $row['SourceLocation'];
					$sourceValue = $row['Source'];
					$sourceIPValue = $row['sourceIP'];
					$destinationValue = $row['Destination'];
					$destinationLocationValue = $row['DestinationLocation'];
					$destinationIPValue = $row['destinationIP'];
					$destinationPortValue = $row['destinationPort'];
					$protocolValue = $row['protocol'];
					$URLValue = $row['URL'];
					$noteValue = $row['note'];
					$deleteReasonValue = $row['deleteReason'];
					$deleteDateValue = $row['deleteDate'];
					
					
					echo <<< TABLEVALUES
					<tr>
					<td>$i</td>
					<td>$environmentValue</td>
					<td>$typeValue</td>
					<td>$sourceLocationValue</td>
					<td>$sourceValue</td>
					<td>$sourceIPValue</td>
					<td>$destinationValue</td>
					<td>$destinationLocationValue</td>
					<td>$destinationIPValue</td>
					<td>$destinationPortValue</td>
					<td>$protocolValue</td>
					<td>$URLValue</td>
					<td>$noteValue</td>
					<td>$deleteReasonValue</td>
					<td>$deleteDateValue</td>
					</tr>
TABLEVALUES;
				}
				echo "</table>";
			?>
		</div>
	</body>
</html>

