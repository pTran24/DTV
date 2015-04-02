<?php
include('../includes/config.php');

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
