<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>TDM Query</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/tdmquery.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>
<body>
    <?php
        session_start();
        include_once("banner_nav.html");
        # Read in config file
        $configfile = fopen("Wamp.conf", "r") or die("Unable to open file!");
        while(!feof($configfile)) {
            $line = fgets($configfile);
            if (preg_match("/omsr3host=(.*)/", $line, $match)) {
                $host = trim($match[1]);
            }
            if (preg_match("/omsusr=(.*)/", $line, $match)) {
                $user = trim($match[1]);
            }
            if (preg_match("/omspw=(.*)/", $line, $match)) {
                $pw = trim($match[1]);
            }
        }
        fclose($configfile);

        $con = mysqli_connect("$host","$user","$pw","lisacatalog");
        if (mysqli_connect_errno($con)){
            echo "Failed to conenct to MySQL: " . mysqli_connecterror();
        }

        $orderID    = '';
        $beginDate  = '';
        if (isset($_POST['orderID'])){
            $orderID    = $_POST['orderID'];
        }
        if (isset($_POST['beginDate'])){
            $beginDate  = $_POST['beginDate'];
        }
        include_once("tdm_sql.php");

        # Remove lines from query if corresponding field in form is left blank
        $tdmArray = explode("\n", $tdmSQL); # Break query into array
        foreach ($tdmArray as $key => $line) {
            if ( empty($beginDate) && stripos("$line", "orderdate >=") !== false) {
                unset($tdmArray[$key]);
            }
            if ( empty($orderID) && stripos("$line", "orderID IN") !== false) {
                unset($tdmArray[$key]);
            }
        }
        $finalSQL = implode("\n", $tdmArray);
    ?>
    <div id='page-wrap'>
        <form class="tdmForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            OM.<font color="blue">ORDERID</font> <strong>IN</strong> <strong>(</strong> <input id="acctNum" name="orderID" size="80" placeholder="71763144, 71763137" value="<?php echo $orderID; ?>"></input> <strong>)</strong><br />
            O.<font color="blue">ORDERDATE</font> >= <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input id="beginDate" name="beginDate" type="text" placeholder="360" value="<?php echo $beginDate; ?>"></input> , 111<strong>))</strong> <br />
            <br />
            <button id="run" type="submit" name="runquery">RUN</button>
        </form>
        <?php if(isset($_POST["runquery"])) :
            $result = mysqli_query($con, "$testSQL") or die(mysqli_error); # Run query

            # Grab HEADERS from $result query
            $headers = array();
            while($nameField = mysqli_fetch_field($result)){
                array_push($headers, $nameField->name);
            }

            # Grab ROWS from $result query
            $rows = array();
            while($row = $result->fetch_array(MYSQLI_NUM)){
                array_push($rows, $row);
            }

            $_SESSION['headers'] = $headers;
            $_SESSION['rows'] = $rows;
        ?>
        <form class="tdmForm" action="downloadQuery.php" method="post">
            <button id="download" type="submit" name="downloadquery">Download</button>
        </form>
        <br />
        <br />
        <ul id='tabs'>
              <li><a id='query'>Query</a></li>
              <li><a id='result'>Result</a></li>
        </ul>
        <div class='container' id='queryC'>
            <pre>
                <!-- <?php echo "$finalSQL" ?> -->
                <?php
                    foreach ($tdmArray as $line){
                        if ( stripos("$line", "ORDERID IN") !== false ){
                            $line = preg_replace('/\(/', '(<strong style="color:red">', $line);
                            $line = preg_replace('/\)/', '</strong>)', $line);
                            echo "$line\n";
                        } elseif ( stripos("$line", "orderdate >=") !== false ){
                            $line = preg_replace('/\) -/', ')-<strong style="color:red">', $line);
                            $line = preg_replace('/\,/', '</strong>,', $line);
                            echo "$line\n";
                        } else {
                            echo "$line\n";
                        }
                    }
                ?>
            </pre>
        </div>
        <div class='container' id='resultC'>
            <table id='results'>
                <thead>
                    <tr>
                    <?php foreach ($headers as $colName){
                        echo "<th>$colName</th>";
                    }?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row){
                    echo "<tr>";
                    foreach ($row as $col){
                        echo "<td>$col</td>";
                    }
                    echo "</tr>";
                }?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

	<script>
	$(document).ready(function() {
		$('#tabs li a:not(:first)').addClass('inactive');
		$('.container').hide();
		$('.container:first').show();

		$('#tabs li a').click(function(){
    		var t = $(this).attr('id');
			if($(this).hasClass('inactive')){ //this is the start of our condition
    			$('#tabs li a').addClass('inactive');
    			$(this).removeClass('inactive');
    			$('.container').hide();
    			$('#'+ t + 'C').fadeIn('slow');
			}
		});
        $('#download').click(function(){
            $(this).hide();
        })
	});
	</script>
</body>
</html>
