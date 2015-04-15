<?php
include('../includes/config.php');

// $query = "SELECT d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.status as Status, l.starttime as StartTime, l.capacity as Capacity, l.txncnt as Txn, l.errors as Errors, m.build as Build, m.lisaproject as Project, IFNULL(m.author, 'NULL') as Author, IFNULL(m.modifydate, 'NULL') as ModifyDate, l.port as Port, l.basepath as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip";
$query = "SELECT d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.port as Port, l.basepath as BasePath, l.status as Status, l.txncnt as Txn, l.errors as Errors, m.lisaproject as Project, m.build as Build, c.application as App, c.environment as Env, c.filename as Config, m.author as Author, l.starttime as StartTime, m.modifydate as ModifyDate FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip LEFT JOIN middlewareconfigs c ON c.port = l.port AND c.basepath = l.basepath AND c.lisaserver = l.hostip UNION SELECT d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.port as Port, l.basepath as BasePath, l.status as Status, l.txncnt as Txn, l.errors as Errors, m.lisaproject as Project, m.build as Build, c.application as App, c.environment as Env, c.filename as Config, m.author as Author, l.starttime as StartTime, m.modifydate as ModifyDate FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip RIGHT JOIN middlewareconfigs c ON c.port = l.port AND c.basepath = l.basepath AND c.lisaserver = l.hostip ORDER BY ServiceName;";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;
	}
}
# JSON-encode the response
$json_response = json_encode($arr);

# Return the response
echo $json_response;
?>
