<?php 
$link = mysqli_connect('localhost:3333','grapes_sqauser','sq44$3r'); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 
echo 'Connection OK'; mysqli_close($link); 
?> 
