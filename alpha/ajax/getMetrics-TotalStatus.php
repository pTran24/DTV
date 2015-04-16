<?php
include('../includes/config.php');

$query = 'SELECT IFNULL(hostip, "TOTAL") as Server, SUM(CASE WHEN status="running" THEN 1 ELSE 0 END) AS "Running", SUM(CASE WHEN status="loaded" THEN 1 ELSE 0 END) AS "Loaded", SUM(CASE WHEN status="down" THEN 1 ELSE 0 END) AS "Down", count(serviceName) as Total FROM lisalog GROUP BY hostip WITH ROLLUP;';
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
