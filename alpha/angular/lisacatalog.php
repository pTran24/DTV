<!DOCTYPE html>
<html>
<head>
    <title>LISA Catalog</title>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
</head>
<body>
    <div class="container">
        <?php
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

        $con=mysqli_connect("$host","$user","$pw","lisacatalog");
        #$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","lisacatalog");
        if (mysqli_connect_errno($con)){
            echo "Failed to conenct to MySQL: " . mysqli_connecterror();
        }
        $sqlSelect =
            "SELECT
                d.environment as Environment,
                d.hostip as HostIP,
                l.serviceName as ServiceName,
                l.status as Status,
                l.starttime as StartTime,
                l.capacity as Capacity,
                l.txncnt as Txn,
                l.errors as Errors,
                m.build as Build,
                m.lisaproject as Project,
                IFNULL(m.author, 'NULL') as Author,
                IFNULL(m.modifydate, 'NULL') as ModifyDate,
                l.port as Port,
                l.basepath as BasePath
            FROM
                domain d
            INNER JOIN
                lisalog l ON l.hostip = d.hostip
            LEFT JOIN
                lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
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
                #if ($colName != 'capacity' && $colName != 'timestamp' && $colName != 'Environment' && $colName != 'Capacity' && $colName != 'UpTime' && $colName != 'Errors'){
                #Show filter boxes, excluding those in 'if' statement
                if ($colName != 'ModifyDate' && $colName != 'StartTime' && $colName != 'Environment' && $colName != 'TxnPerSec' && $colName != 'PeakTxnPerSec' && $colName != 'Capacity' && $colName != 'Errors'){
                    echo "
                    <table class='filter_table'>
                        <tr>
                            <th>$colName</th>
                        </tr>
                        <tr id='filter_col$cnt' data-column='$cnt2'>
                            <td><input type='text' class='column_filter' id='col${cnt2}_filter' style='width:100px'></td>
                        </tr>
                    </table>";
                }
                $cnt++;
                $cnt2++;
            }
            ?>
        </div>

        <!-- Output Table -->
        <table id='results'>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#example").colResizable({
                fixed:false,
                liveDrag:false
            });
        });
    </script>
</body>
</html>
