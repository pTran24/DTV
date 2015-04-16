<!DOCTYPE html>
<html>
<head>
    <title>LISA Catalog</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/jquery.dataTables.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/menu.js" /></script>
    <script src="js/jquery.dataTables.js"></script>
</head>
<body>
    <?php include_once("menu.html"); ?>
    <div id='page-wrap'>
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
        if (mysqli_connect_errno($con)){
            echo "Failed to conenct to MySQL: " . mysqli_connecterror();
        }
        #$sqlSelect =
        #    "SELECT
        #        d.environment as Environment,
        #        d.hostip as HostIP,
        #        l.serviceName as ServiceName,
        #        l.port as Port,
        #        l.basepath as BasePath,
        #        l.status as Status,
        #        l.txncnt as Txn,
        #        l.errors as Errors,
        #        m.lisaproject as Project,
        #        m.build as Build,
        #        IFNULL(m.author, 'NULL') as Author,
        #        l.starttime as StartTime,
        #        IFNULL(m.modifydate, 'NULL') as ModifyDate
        #    FROM
        #        domain d
        #    INNER JOIN
        #        lisalog l ON l.hostip = d.hostip
        #    LEFT JOIN
        #        lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
       # SQL: Get all deployed services and middle configs that match
       # $sqlSelect = 
       #     "SELECT
       #         d.environment as Environment,
       #         d.hostip as HostIP,
       #         l.serviceName as ServiceName,
       #         l.port as Port,
       #         l.basepath as BasePath,
       #         l.status as Status,
       #         l.txncnt as Txn,
       #         l.errors as Errors,
       #         m.lisaproject as Project,
       #         m.build as Build,
       #         c.application as App,
       #         c.environment as Env,
       #         c.filename as Config,
       #         m.author as Author,
       #         l.starttime as StartTime,
       #         m.modifydate as ModifyDate
       #     FROM
       #         domain d
       #     INNER JOIN
       #         lisalog l ON l.hostip = d.hostip
       #     LEFT JOIN
       #         lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip
       #     LEFT JOIN 
       #         middlewareconfigs c ON c.port = l.port AND c.basepath = l.basepath AND c.lisaserver = l.hostip
       #     ORDER BY ServiceName;";
        # SQL: Get all deployed services and ALL middleware configs
        $sqlSelect =
            "SELECT
                d.environment as Environment,
                d.hostip as HostIP,
                l.serviceName as ServiceName,
                l.port as Port,
                l.basepath as BasePath,
                l.status as Status,
                l.txncnt as Txn,
                l.errors as Errors,
                m.lisaproject as Project,
                m.build as Build,
                c.application as App,
                c.environment as Env,
                c.filename as Config,
                m.author as Author,
                l.starttime as StartTime,
                m.modifydate as ModifyDate
            FROM
                domain d
            INNER JOIN
                lisalog l ON l.hostip = d.hostip
            LEFT JOIN
                lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip
            LEFT JOIN
                middlewareconfigs c ON c.port = l.port AND c.basepath = l.basepath AND c.lisaserver = l.hostip
            UNION
            SELECT
                d.environment as Environment,
                d.hostip as HostIP,
                l.serviceName as ServiceName,
                l.port as Port,
                l.basepath as BasePath,
                l.status as Status,
                l.txncnt as Txn,
                l.errors as Errors,
                m.lisaproject as Project,
                m.build as Build,
                c.application as App,
                c.environment as Env,
                c.filename as Config,
                m.author as Author,
                l.starttime as StartTime,
                m.modifydate as ModifyDate
            FROM
                domain d
            INNER JOIN
                lisalog l ON l.hostip = d.hostip
            LEFT JOIN
                lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip
            RIGHT JOIN
                middlewareconfigs c ON c.port = l.port AND c.basepath = l.basepath AND c.lisaserver = l.hostip
            ORDER BY ServiceName;";
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
            $("table#example").removeClass("hidden"); //Display table after jquery is applied to prevent double-take effect
        });
    </script>
</body>
</html>
