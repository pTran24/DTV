<!DOCTYPE html>
<html>
	<head>
		<title>Delete New Network Flow</title>
		<link rel="stylesheet" href="/css/banner.css" />
        <link rel="stylesheet" href="/css/menu.css" />
        <link rel="stylesheet" href="/css/network.css" />
        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/menu.js" /></script>
    </head>
    <body>
        <?php include_once("../menu.html"); ?>		
		<div id="page-wrap">
			<?php //CREATE CONNECTION, GET FORM INFORMATION
				// Create connection
				$con=mysqli_connect("localhost:3333","grapes_sqauser","sq44$3r", "networkreference");
				$masterPassword = 'testing';
				if (mysqli_connect_errno($con)){
					//Check connection
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$allEmpty = FALSE;
				
				//If "delete" post or "pass" field is filled out
				if (isset($_POST['delete']) || isset($_POST['pass'])){
					$environmentPost = $_POST['environmentDelete'];
					$typePost = $_POST['typeDelete'];
					$sourceLocationPost = $_POST['sourceLocationDelete'];
					$sourcePost = $_POST['sourceDelete'];
					$sourceIPPost = $_POST['sourceIPDelete'];
					$destinationPost = $_POST['destinationDelete'];
					$destinationLocationPost = $_POST['destinationLocationDelete'];
					$destinationIPPost = $_POST['destinationIPDelete'];
					$destinationPortPost = $_POST['destinationPortDelete'];
					$protocolPost = $_POST['protocolDelete'];
					$URLPost = $_POST['URLDelete'];
					$notePost = $_POST['noteDelete'];
				}
				else{
					$environmentPost = NULL;
					$typePost = NULL;
					$sourceLocationPost = NULL;
					$sourcePost = NULL;
					$sourceIPPost = NULL;
					$destinationPost = NULL;
					$destinationLocationPost = NULL;
					$destinationIPPost = NULL;
					$destinationPortPost = NULL;
					$protocolPost = NULL;
					$URLPost = NULL;
					$notePost = NULL;
					$allEmpty = TRUE;
				}
				$passwordPost = NULL;
			?>
			<?php //FUNCTION DEFINITION
				function storeColumns(&$con){
					//Grabs COLUMN names from database, returns an array.
					
					$columnNames = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='networkreference' AND `TABLE_NAME`='networkflows'";
					$columnNames = mysqli_query($con, $columnNames);
					$numColumns = mysqli_num_rows($columnNames);
					for ($i=0; $i<$numColumns; $i++){
						$column = mysqli_fetch_row($columnNames);
						$columnArray[$i] = $column[0];
					}
					return $columnArray;
				}
			?>
		
			<?php //USER INTERFACE
				$deleteArray = array($environmentPost, $typePost, $sourceLocationPost, $sourcePost, $sourceIPPost, $destinationPost, $destinationLocationPost, $destinationIPPost, $destinationPortPost, $protocolPost, $URLPost, $notePost);
				$columnTables = storeColumns($con);
				if ($allEmpty){
					echo "<script>alert('You entered this page indirectly. Press OK to redirect.')</script>";
					#echo "<meta http-equiv='refresh' content='.5; url=SQANetworkFlows.php'>";
					echo "<meta http-equiv='refresh' content='.5; url=/networkflows/SQANetworkFlows.php'>";
				}
				echo "The following is the record you are about to <b>DELETE</b>:<br><br>";
				echo "<table border='1'>";
				echo "<tr>";
				
				foreach($columnTables as $value){
					echo"<td>$value</td>";
				}
				echo "</tr><tr>";
				foreach($deleteArray as $value){
					echo"<td>$value</td>";
				}
				echo "</tr></table>";
				echo "<br>If you wish to <b>DELETE</b> the file, please enter the password to continue:";
				echo <<< FORM
				<form action='deleteform.php' method='post'>
					<div id="noDisplay">
						<input type='textbox' name='environmentDelete' value="$environmentPost"></input>
						<input type='textbox' name='typeDelete' value="$typePost"></input>
						<input type='textbox' name='sourceLocationDelete' value="$sourceLocationPost"></input>
						<input type='textbox' name='sourceDelete' value="$sourcePost"></input>
						<input type='textbox' name='sourceIPDelete' value="$sourceIPPost"></input>
						<input type='textbox' name='destinationDelete' value="$destinationPost"></input>
						<input type='textbox' name='destinationLocationDelete' value="$destinationLocationPost"></input>
						<input type='textbox' name='destinationIPDelete' value="$destinationIPPost"></input>
						<input type='textbox' name='destinationPortDelete' value="$destinationPortPost"></input>
						<input type='textbox' name='protocolDelete' value="$protocolPost"></input>
						<input type='textbox' name='URLDelete' value="$URLPost"></input>
						<input type='textbox' name='noteDelete' value="$notePost"></input>
					</div>
					
					<input type='password' name='pass'><br>
					Please enter a reason for the record deletion:<br>
					<input type='text' name='deleteReason'><br>
					<input type='submit' name='submit' value='Delete Record'>
				</form>
FORM;
			?>
	
			<?php //TAKE ACTION BASED ON USER INPUT
				
				if (isset($_POST['pass']) && $_POST['pass'] == $masterPassword){
					$deletion = "DELETE FROM networkflows WHERE " . "(environment = '$environmentPost') AND " . "(type = '$typePost') AND " . 
								"(sourceLocation = '$sourceLocationPost') AND " . "(source = '$sourcePost') AND " .  "(sourceIP = '$sourceIPPost') AND " .
								"(destination = '$destinationPost') AND " . "(destinationLocation = '$destinationLocationPost') AND " . 
								"(destinationIP = '$destinationIPPost') AND " . "(destinationPort = '$destinationPortPost') AND " . 
								"(protocol = '$protocolPost') AND " . "(URL = '$URLPost') AND" . "(note = '$notePost')";
					
					$deletePost = $_POST['deleteReason'];
					$recycleEntry = "INSERT INTO recyclebin (environment, type, sourceLocation, source, sourceIP, destination, destinationLocation, destinationIP, destinationPort, protocol, URL, note, deleteReason)" .
					" VALUES ('$environmentPost', '$typePost', '$sourceLocationPost', '$sourcePost', '$sourceIPPost', '$destinationPost', '$destinationLocationPost', '$destinationIPPost', '$destinationPortPost', '$protocolPost', '$URLPost', '$notePost', '$deletePost')";
					
					if (!mysqli_query($con, $deletion)){
						die('Error: ' . mysqli_error($con));
					}
					else if (!mysqli_query($con, $recycleEntry)){
						die('Error: ' . mysqli_error($con));
					}
					else{
						echo "<script>alert('Record was succesfully deleted!')</script>";
						#echo "<meta http-equiv='refresh' content='.5; url=SQANetworkFlows.php'>";
						echo "<meta http-equiv='refresh' content='.5; url=/networkflows/SQANetworkFlows.php'>";
					}
				}
				
				else if (isset($_POST['pass'])){
					echo "<script>alert('Password was incorrect, no change was made. You will be redirected to the networkflows page.')</script>";
					#echo "<meta http-equiv='refresh' content='.5; url=SQANetworkFlows.php'>";
					echo "<meta http-equiv='refresh' content='.5; url=/networkflows/SQANetworkFlows.php'>";
				}
			?>
		</div>
	</body>
</html>
