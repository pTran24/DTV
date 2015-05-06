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

    $con = mysqli_connect("$host","$user","$pw","lisacatalog"); #DTV WAMP
    //$db = mysqli_select_db("lisacatalog")
    if (mysqli_connect_errno($con)){
        echo "Failed to conenct to MySQL: " . mysqli_connecterror();
    }
?>
