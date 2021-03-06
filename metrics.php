<!DOCTYPE html>
<html>
<head>
    <title>LISA Metrics</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/metrics.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
    <?php include_once("/banner_nav.html"); ?>
    <div id='page-wrap'>
        <?php
        date_default_timezone_set('America/Los_Angeles');

        # Read in config file
        $configfile = fopen("Wamp.conf", "r") or die("Unable to open file!");
        while(!feof($configfile)) {
            $line = fgets($configfile);
            if (preg_match("/mysqlhost=(.*)/", $line, $match)) {
                $host = trim($match[1]);
            }
            if (preg_match("/mysqlusr=(.*)/", $line, $match)) {
                $user = trim($match[1]);
            }
            if (preg_match("/mysqlpw=(.*)/", $line, $match)) {
                $pw = trim($match[1]);
            }
        }
        fclose($configfile);

        $con=mysqli_connect("$host","$user","$pw","lisacatalog"); #DTV WAMP
        if (mysqli_connect_errno($con)){
            echo "Failed to conenct to MySQL: " . mysqli_connecterror();
        }

        $currentDate = date("Y-m-d");
        $currentMonth = date("m");
        $currentDay = date("d");
        //echo "Current Date: $currentDate";
        if (isset($_GET["slength"])){
            $stubLength = $_GET["slength"];
        }
        if (isset($_GET["sinterval"])){
            $stubInterval = $_GET["sinterval"];
        }
        if (isset($_GET["tlength"])){
            $txnLength = $_GET["tlength"];
        }
        if (isset($_GET["tinterval"])){
            $txnInterval = $_GET["tinterval"];
        }
        if (isset($_GET["page_y"])){
            $page_y = $_GET["page_y"];
        }else{
            $page_y = "0";
        }
        #//echo "$stubLength $stubInterval $txnLength $txnInterval";

        $totalSQL = 'SELECT
        IFNULL(hostip, "TOTAL") as Server,
        SUM(CASE WHEN status="running" THEN 1 ELSE 0 END) AS "Running",
        SUM(CASE WHEN status="loaded" THEN 1 ELSE 0 END) AS "Loaded",
        SUM(CASE WHEN status="down" THEN 1 ELSE 0 END) AS "Down",
        count(serviceName) as Total
        FROM
        lisalog
        GROUP BY
        hostip WITH ROLLUP;';

        #############################################
        #Generate SQL for Stubs Created Over Time
        #############################################
        if (empty($stubLength)){
            $stubLength = "12"; #Choose from selection box later
        }
        $stubLengthCnt = $stubLength;
        if (empty($stubInterval)){
            $stubInterval = "MONTH"; #Choose from selection box later day/week/month/year
        }

        $stubsCreatedSQL = "SELECT IFNULL(hostip, 'TOTAL') as Server,";

        if ($stubInterval == "MONTH"){
            $currentDate = date("Y-m-01");
        }
        else{
            $currentDate = date("Y-m-d");
        }
        $beginTime = strtotime("$currentDate -{$stubLength} $stubInterval");
        $beginDate = date('Y-m-d', "$beginTime");

        while ($stubLengthCnt>=0){
            $startTime = strtotime("$currentDate -{$stubLengthCnt} $stubInterval");
            $startDate = date('Y-m-d', "$startTime");

            #Set endTime to be 1 interval larger than begin time
            $endTime = strtotime("$startDate +1 $stubInterval");
            $endDate = date('Y-m-d', "$endTime");

            #Get column-name (by intervals)
            if ($stubInterval == "DAY"){
                $colName = date('Y-m-d', $startTime);
            }
            elseif ($stubInterval == "MONTH"){
                $colName = date('M - Y',$startTime);
                $startDate = date('Y-m-01', $startTime);
                $endDate = date('Y-m-01', "$endTime");
                $beginDate = date('Y-m-01', "$beginTime");
            }
            elseif ($stubInterval =="YEAR"){
                $colName = date('Y',$startTime);
                $startDate = date('Y-01-01', $startTime);
                $endDate = date('Y-01-01', "$endTime");
                $beginDate = date('Y-01-01', "$beginTime");
            }

            $stubsCreatedSQL .= "FORMAT(SUM(CASE WHEN DATE(createdate) >= DATE('$startDate') AND DATE(createDate) < DATE('$endDate') THEN 1 ELSE 0 END),0) as '$colName',";

            $stubLengthCnt--;
        }
        #$stubsCreatedSQL = rtrim($stubsCreatedSQL, ",");
        $stubsCreatedSQL .= "FORMAT(SUM(CASE WHEN createdate BETWEEN DATE('$beginDate') AND DATE('$currentDate') THEN 1 ELSE 0 END),0) as 'Total'";
        #$stubsCreatedSQL .= "'' as 'Total'";
        #$stubsCreatedSQL .= "FROM lisamar GROUP BY hostip WITH ROLLUP;";
        $stubsCreatedSQL .= "FROM (SELECT hostip, createdate, modelname FROM lisamar UNION SELECT hostip, createdate, serviceName FROM removedservices) as services GROUP BY hostip WITH ROLLUP;";
        #echo "<p>$stubsCreatedSQL</p>";


        ###############################
        #Generate SQL for Txn Over Time
        ###############################
        if (empty($txnLength)){
            $txnLength = "7"; #Choose from selection box later
        }
        $txnLengthCnt = $txnLength;
        if (empty($txnInterval)){
            $txnInterval = "DAY"; #Choose from selection box later day/week/month/year
        }
        $txnSQL = "SELECT IFNULL(server, 'TOTAL') as Server,";
        if ($txnInterval == "MONTH"){
            $currentDate = date("Y-m-01");
        }
        else{
            $currentDate = date("Y-m-d");
        }

        $beginTime = strtotime("$currentDate -{$txnLength} $txnInterval");
        $beginDate = date('Y-m-d', "$beginTime");

        while( $txnLengthCnt>=0 ){
            $startTime = strtotime("$currentDate -{$txnLengthCnt} $txnInterval");
            $startDate = date('Y-m-d', "$startTime");

            #Set endTime to be 1 interval larger than begin time
            $endTime = strtotime("$startDate +1 $txnInterval");
            $endDate = date('Y-m-d', "$endTime");

            #Get column-name (by intervals)
            if ($txnInterval == "DAY"){
                $colName = date('Y-m-d', $startTime);
            }
            elseif ($txnInterval == "MONTH"){
                $colName = date('M - Y',$startTime);
                $startDate = date('Y-m', $startTime);
                $endDate = date('Y-m-01', "$endTime");
                $beginDate = date('Y-m-01', "$beginTime");
            }
            elseif ($txnInterval =="YEAR"){
                $colName = date('Y',$startTime);
                $startDate = date('Y', $startTime);
                $endDate = date('Y-01-01', "$endTime");
                $beginDate = date('Y-01-01', "$beginTime");
            }

            #$txnSQL .= "MAX(IF(DATE_FORMAT(timestamp, '%Y-%m-%d')='$startDate',transactions,NULL)) as '$startDate',";
            #$txnSQL .= "FORMAT(MAX(IF(DATE(timestamp)='$startDate',transactions,0)),0) as '$startDate',";
            #$txnSQL .= "FORMAT(MAX(CASE WHEN DATE(timestamp) >= DATE('$startDate') AND DATE(timestamp) < DATE('$endDate') THEN transactions ELSE 0 END),0) as '$colName',";

            $txnSQL .= "FORMAT(SUM(CASE WHEN DATE(d) LIKE '$startDate%' THEN maxt ELSE 0 END),0) as '$colName',";
            $txnLengthCnt--;
        }
        #$txnSQL = rtrim($txnSQL, ",");
        #$txnSQL .= "SUM(CASE WHEN DATE_FORMAT(timestamp, '%Y-%m-%d') BETWEEN '$beginDate' AND '$currentDate' THEN MAX(transactions) ELSE 0 END) as 'Total'";
        $txnSQL .= "'' as 'Total'";
        $txnSQL .= "FROM (SELECT DATE(timestamp) as d, server, MAX(transactions) as maxt
        FROM stubtxncnt tt
        WHERE DATE(timestamp) >= '$beginDate'
        AND DATE(timestamp) < '$endDate' GROUP BY DATE(TIMESTAMP), server) t
        GROUP BY server WITH ROLLUP;";
        #echo "<p>$txnSQL</p>";
        #####################################
        #           Execute SQLs
        #####################################
        $totalResult = mysqli_query($con, "$totalSQL") or die(mysqli_error);
        $stubsCreatedResult = mysqli_query($con, "$stubsCreatedSQL") or die(mysqli_error);
        $txnResult = mysqli_query($con, "$txnSQL") or die(mysqli_error);
        //$queryRowNum = mysqli_num_rows($totalResult);

        #Get column names from query
        $totalColumnNameArr = [];
        $i = 0;
        while ($nameField = mysqli_fetch_field($totalResult)){
            $totalColumnNameArr[$i] = $nameField->name;
            $i++;
        }

        $stubsCreatedColumnNameArr = [];
        $i = 0;
        while ($nameField = mysqli_fetch_field($stubsCreatedResult)){
            $stubsCreatedColumnNameArr[$i] = $nameField->name;
            $i++;
        }

        $txnColumnNameArr = [];
        $i = 0;
        while ($nameField = mysqli_fetch_field($txnResult)){
            $txnColumnNameArr[$i] = $nameField->name;
            $i++;
        }
        ?>

        <!-- Total Stubs Table -->
        <table id='total'>
            <caption>Total Stubs on Each LISA Instance</caption>
            <thead>
                <?php //print Header Column
                echo "<tr>";
                    foreach ($totalColumnNameArr as $colName){
                        echo "<th>$colName</th>";
                    }
                    echo "</tr>";
                ?>
            </thead>
            <tbody>
                <?php //populate data rows
                foreach ($totalResult as $row){
                    echo "<tr>";
                    foreach ($row as $col){
                        echo "<td>$col</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </br>
        <!--Stubs created Table-->
        <table id='stubsOverTime'>
            <caption>Stubs created over past
                <select id='stubLength'>
                    <?php
                    for ($i=1; $i<=31; ++$i){
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
                <select id="stubInterval">
                    <option value='DAY'>DAYS</option>
                    <option value='MONTH'>MONTHS</option>
                    <option value='YEAR'>YEARS</option>
                </select>
            </caption>
            <thead>
                <?php //print Header Column
                echo "<tr>";
                foreach ($stubsCreatedColumnNameArr as $colName){
                    echo "<th>$colName</th>";
                }
                echo "</tr>";
                ?>
            </thead>
            <tbody>
                <?php //populate data rows
                foreach ($stubsCreatedResult as $row){
                    echo "<tr>";
                    foreach ($row as $col){
                        echo "<td>$col</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </br>
        <!-- Transactions Table -->
        <table id='txnOverTime'>
            <caption>Transactions over past
                <select id="txnLength">
                <?php
                for ($i=1; $i<=31; ++$i){
                    echo "<option value='$i'>$i</option>";
                }
                ?>
                </select>
                <select id="txnInterval">
                    <option value='DAY' selected="selected">DAYS</option>
                    <option value='MONTH'>MONTHS</option>
                    <option value='YEAR'>YEARS</option>
                </select>
            </caption>
            <thead>
                <?php //print Header Column
                echo "<tr>";
                foreach ($txnColumnNameArr as $colName){
                    echo "<th>$colName</th>";
                }
                echo "</tr>";
                ?>
            </thead>
            <tbody>
                <?php //populate data rows
                foreach ($txnResult as $row){
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
        var colTotals = [];
        var grandTotal = 0;
        //Add Total column/row to transactions table
        $('#txnOverTime tbody tr:not(:last-child)').each(function() {
            var rowTotal = 0;
            $(this).children('td:not(:first-child):not(:last-child)').each(function(index) {
                var currValue = parseInt($(this).html().replace(/,/g, ''),10);
                if (isNaN(currValue)){
                    currValue = 0;
                }
                rowTotal += currValue;
                grandTotal += currValue;
                if (!colTotals[index] && colTotals[index] != 0){
                    colTotals[index] = currValue;
                }else {
                    colTotals[index] += currValue;
                }
            });
            //Sets last column to total each row
            $(this).children('td:last-child').each(function() {
                $(this).html(addCommas(rowTotal));
            });
        });
        $('#txnOverTime tbody tr:last-child').each(function() {
            colTotals.push(grandTotal);
            $(this).children('td:not(:first-child)').each(function(index) {
                $(this).html(addCommas(colTotals[index]));
            });
        });
        //format numbers to include commas
        function addCommas(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

        //Set dropdown button to selected option
        $("#stubLength").val("<?php echo "$stubLength" ?>");
        $("#stubInterval").val("<?php echo "$stubInterval" ?>");
        $("#txnLength").val("<?php echo "$txnLength" ?>");
        $("#txnInterval").val("<?php echo "$txnInterval" ?>");

        //Upon select box change, update URL to values of current selected boxes
        $("select").change(function() {
            var page_y = $( document ).scrollTop();
            var slength = $("#stubLength").val();
            var sinterval = $("#stubInterval").val();
            var tlength = $("#txnLength").val();
            var tinterval = $("#txnInterval").val();
            window.location = '//' + location.host + location.pathname +'?slength='+slength+'&sinterval='+sinterval+'&tlength='+tlength+'&tinterval='+tinterval+'&page_y='+page_y;
        });
        $( 'html, body' ).scrollTop(<?php echo "$page_y"; ?>);
    </script>
</body>
</html>
