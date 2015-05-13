<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>

    <title>TDM Query</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/tdmquery.css" />
<!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />-->
</head>
<body>
    <?php
        include_once("menu.html");
        include_once("db_connection.php");
        $orderID    = '';
        $beginDate  = '';
        if (isset($_POST['orderID'])){
            $orderID    = $_POST['orderID'];    # line 165, 179
        }
        if (isset($_POST['beginDate'])){
            $beginDate  = $_POST['beginDate'];  # line 161, 180
        }
        include_once("tdm_sql.php");

        # Remove lines from query if form is left blank
        $tdmArray = explode("\n", $tdmSQL); # Break query into array
        foreach ($tdmArray as $key => $line) {
            if ( empty($beginDate) && stripos("$line", "orderdate >=") !== false) {
                unset($tdmArray[$key]);
            }
            if ( empty($orderID) && stripos("$line", "orderID IN") !== false) {
                unset($tdmArray[$key]);
            }
        }
        $tdmSQLFiltered = implode("\n", $tdmArray);

        $result = mysqli_query($con, "$testSQL") or die(mysqli_error); # Run query

        # Grab headers from result
        $headers = [];
        $i = 0;
        while($nameField = mysqli_fetch_field($result)){
            $headers[$i] = $nameField->name;
            $i++;
        }
        $num_fields = mysqli_num_fields($result); # Grab row count
    ?>
    <div id='page-wrap'>
        <form id="tdmForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            OM.<font color="blue">ORDERID</font> <strong>IN</strong> <strong>(</strong> <input id="acctNum" name="orderID" size="100" placeholder="71763144, 71763137" value="<?php echo $orderID; ?>"></input> <strong>)</strong><br />
            O.<font color="blue">ORDERDATE</font> >= <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input id="beginDate" name="beginDate" type="text" placeholder="360" value="<?php echo $beginDate; ?>"></input> , 111<strong>))</strong> <br />
        	<br />
            <input id="run" type="submit" value="Run Query" name="runquery"></input>
			<input id="sub" type="submit" value="Download Results" name="downloadquery"></input>
        </form>
		<br />

        <?php if(isset($_POST["runquery"])) : ?>
        <ul id='tabs'>
              <li><a id='query'>Query</a></li>
              <li><a id='result'>Result</a></li>
        </ul>
        <div class='container' id='queryC'>
            <pre>
                <?php echo "$tdmSQLFiltered" ?>
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
        <?php
        # Convert result to csv and push use to download if user pressed "Download" button
        if(isset($_POST["downloadquery"])) {
            $fp = fopen('php://output', 'w');
            ob_start();
            if ($fp && $result) {
                fputcsv($fp, $headers); # populate header
                while ($row = $result->fetch_array(MYSQLI_NUM)) {
                    fputcsv($fp, array_values($row)); #populate rows
                }
            }
            $content = ob_get_clean();
            $filename ='tdmQueryResult_' . date('Ymd');

            // Output CSV-specific headers
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '.txt";');

            exit($content);
        }
        ?>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
	<!--<script src="js/tdm_query.js"></script>-->
	<!--<script src="js/autosize.js"></script>-->
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
	});
	</script>
</body>
</html>
