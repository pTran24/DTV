<?php
include('../includes/config.php');
date_default_timezone_set('America/Los_Angeles');
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

// $totalSQL = 'SELECT
// IFNULL(hostip, "TOTAL") as Server,
// SUM(CASE WHEN status="running" THEN 1 ELSE 0 END) AS "Running",
// SUM(CASE WHEN status="loaded" THEN 1 ELSE 0 END) AS "Loaded",
// SUM(CASE WHEN status="down" THEN 1 ELSE 0 END) AS "Down",
// count(serviceName) as Total
// FROM
// lisalog
// GROUP BY
// hostip WITH ROLLUP;';

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
$stubsCreatedSQL .= "FORMAT(SUM(CASE WHEN createdate BETWEEN DATE('$beginDate') AND DATE('$currentDate') THEN 1 ELSE 0 END),0) as 'Total'";
$stubsCreatedSQL .= "FROM (SELECT hostip, createdate, modelname FROM lisamar UNION SELECT hostip, createdate, serviceName FROM removedservices) as services GROUP BY hostip WITH ROLLUP;";
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
    $txnSQL .= "FORMAT(SUM(CASE WHEN DATE(d) LIKE '$startDate%' THEN maxt ELSE 0 END),0) as '$colName',";
    $txnLengthCnt--;
}
$txnSQL .= "'' as 'Total'";
$txnSQL .= "FROM (SELECT DATE(timestamp) as d, server, MAX(transactions) as maxt
FROM stubtxncnt tt
WHERE DATE(timestamp) >= '$beginDate'
AND DATE(timestamp) < '$endDate' GROUP BY DATE(TIMESTAMP), server) t
GROUP BY server WITH ROLLUP;";
$query="SELECT d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.status as Status, l.starttime as StartTime, l.capacity as Capacity, l.txncnt as Txn, l.errors as Errors, m.build as Build, m.lisaproject as Project, IFNULL(m.author, 'NULL') as Author, IFNULL(m.modifydate, 'NULL') as ModifyDate, l.port as Port, l.basepath as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;
	}
}
# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;
?>
