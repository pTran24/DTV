<?php
    session_start();
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

    $con = mysqli_connect("$host","$user","$pw","catalog");
    //$db = mysqli_select_db("lisacatalog")
    if (mysqli_connect_errno($con)){
        echo "Failed to conenct to MySQL: " . mysqli_connecterror();
    }

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
    # Convert result to csv and push use to download if user pressed "Download" button
    if(isset($_POST["downloadquery"])) {
        $fp = fopen('php://output', 'w');
        ob_start();
        if ($fp && $result) {
            # fputcsv($fp, $headers); # populate header csv format
            $joinedHeader = implode("|", $headers);
            fwrite($fp, "$joinedHeader\n");
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                #fputcsv($fp, array_values($row)); #populate rows csv format
                $joinedRow = implode("|", $row);
                fwrite($fp, "$joinedRow\n");
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
