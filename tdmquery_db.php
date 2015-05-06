<?php
    include_once("db_connection.php");
    $acctNum    = $_POST['acctNum'];
    $beginDate  = $_POST['beginDate'];
    $endDate    = $_POST['endDate'];
    $test       = $_POST['test'];

    $totalSQL = 'SELECT
        IFNULL(hostip, "TOTAL") as Server,
        SUM(CASE WHEN status="running" THEN 1 ELSE 0 END) AS "Running",
        SUM(CASE WHEN status="loaded" THEN 1 ELSE 0 END) AS "Loaded",
        SUM(CASE WHEN status="down" THEN 1 ELSE 0 END) AS "Down",
        count(serviceName) as $test
    FROM
        lisalog
    GROUP BY
        hostip WITH ROLLUP;';

    $totalResult = mysqli_query($con, "$totalSQL") or die(mysqli_error);
    echo '$totalResult';
?>
