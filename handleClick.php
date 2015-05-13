<?php
    include_once("db_connection.php");
    $orderID    = $_POST['orderID'];    # line 165, 179
    $beginDate  = $_POST['beginDate'];  # line 161, 180
    $endDate    = $_POST['endDate'];    # line 162, 181

    # Remove lines from query if form is left blank
	$tdmArray = explode("\n", $tdmSQL); # Break query into array
    foreach ($tdmArray as $key => $line) {
        if ( empty($beginDate) && stripos("$line", "orderdate >=") !== false) {
            unset($tdmArray[$key]);
        }
        if ( empty($endDate) && stripos("$line", "orderdate <") !== false) {
            unset($tdmArray[$key]);
        }
        if ( empty($orderID) && stripos("$line", "orderID IN") !== false) {
            unset($tdmArray[$key]);
        }
    }
    $tdmSQLFiltered = implode("\n", $tdmArray);

    #echo "<pre>Filtered: $tdmSQLFiltered\n</pre>";

    $result = mysqli_query($con, "$testSQL") or die(mysqli_error); # Run query

	# Grab headers from result
    $headers = [];
    $i = 0;
    while($nameField = mysqli_fetch_field($result)){
        $headers[$i] = $nameField->name;
        $i++;
    }
	$num_fields = mysqli_num_fields($result); # Grab row count


	if(isset($_POST["runquery"])) {
        echo "
        <ul id='tabs'>
              <li><a id='query'>Query</a></li>
              <li><a id='result'>Result</a></li>
        </ul>

        <div class='container' id='queryC'>Query Content</div>
        <div class='container' id='resultC'>
            <table id='results'>
                <thead>
                    <tr>";
                    foreach ($headers as $colName){
                        echo "<th>$colName</th>";
                    }
        echo "      </tr>
                </thead>
                <tbody>";
                foreach ($result as $row){
                    echo '<tr>';
                    foreach ($row as $col){
                        echo "<td>$col</td>";
                    }
                    echo '</tr>';
                }
        echo "  </tbody>
            </table>
        </div>";
	}

	# Convert result to csv and push use to download if user pressed "Download" button
	if(isset($_POST["downloadquery"])) {
    	$fp = fopen('php://output', 'w');
    	if ($fp && $result) {
        	header('Content-Type: text/csv');
        	header('Content-Disposition: attachment; filename="tdsm_export.csv"');
        	header('Pragma: no-cache');
        	header('Expires: 0');
        	fputcsv($fp, $headers);
        	while ($row = $result->fetch_array(MYSQLI_NUM)) {
            	fputcsv($fp, array_values($row));
        	}
        	die;
    	}
	}
?>
