<?php
$DB_HOST = 'localhost';
$DB_USER = 'grapes_sqauser';
$DB_PASS = 'sq44$3r';
$DB_NAME = 'angularcode_grid';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$query="select distinct c.customerName, c.addressLine1, c.city, c.state, c.postalCode, c.country, c.creditLimit from customers c order by c.customerNumber";
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
