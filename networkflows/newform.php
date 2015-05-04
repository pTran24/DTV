<!DOCTYPE html>
<html>
<head>
	<title>Change Existing Network Flows</title>
	<link rel="stylesheet" href="../css/banner.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="../css/network.css" />
    <link rel="stylesheet" href="../css/flexselect.css" type="text/css" media="screen" />
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/menu.js" /></script>
    <script src="../js/liquidmetal.js" type="text/javascript"></script>
    <script src="../js/jquery.flexselect.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
        });
    </script>

</head>
<body>
    <?php include_once("../menu.html"); ?>
	<div id="page-wrap">
		<?php //CREATE CONNECTION, GET FORM INFORMATION
        # Read in config file
        $configfile = fopen("../Wamp.conf", "r") or die("Unable to open file!");
        while(!feof($configfile)) {
            $line = fgets($configfile);
            if (preg_match("/mysqlhost=(.*)/", $line, $match)) {
                $host = $match[1];
            }
            if (preg_match("/mysqlusr=(.*)/", $line, $match)) {
                $user = $match[1];
            }
            if (preg_match("/mysqlpw=(.*)/", $line, $match)) {
                $pw = $match[1];
            }
        }
        fclose($configfile);

        $con=mysqli_connect("$host","$user","$pw", "networkreference");
		$masterPassword = 'testing';
		if (mysqli_connect_errno($con)){
			//Check connection
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$environmentAdd = NULL;
		$typeAdd = NULL;
		$sourceLocationAdd = NULL;
		$sourceAdd = NULL;
		$sourceIPAdd = NULL;
		$destinationAdd = NULL;
		$destinationLocationAdd = NULL;
		$destinationIPAdd = NULL;
		$destinationPortAdd = NULL;
		$protocolAdd = NULL;
		$URLAdd = NULL;
		$noteAdd = NULL;

		if (isset($_POST['copy']) || isset($_POST['edit'])){
			//Copies information from a form being copied from SQA Network Flows.
			//Previous form name is copy
			$environmentAdd = $_POST['environmentCopy'];
			$typeAdd = $_POST['typeCopy'];
			$sourceLocationAdd = $_POST['sourceLocationCopy'];
			$sourceAdd = $_POST['sourceCopy'];
			$sourceIPAdd = $_POST['sourceIPCopy'];
			$destinationAdd = $_POST['destinationCopy'];
			$destinationLocationAdd = $_POST['destinationLocationCopy'];
			$destinationIPAdd = $_POST['destinationIPCopy'];
			$destinationPortAdd = $_POST['destinationPortCopy'];
			$protocolAdd = $_POST['protocolCopy'];
			$URLAdd = $_POST['URLCopy'];
			$noteAdd = $_POST['noteCopy'];
		}

		$environmentModify = NULL;
		$typeModify = NULL;
		$sourceLocationModify = NULL;
		$sourceModify = NULL;
		$sourceIPModify = NULL;
		$destinationModify = NULL;
		$destinationLocationModify = NULL;
		$destinationIPModify = NULL;
		$destinationPortModify = NULL;
		$protocolModify = NULL;
		$URLModify = NULL;
		$noteModify = NULL;

		//Copies information from the form to retain the data.
		if (isset($_POST['modify'])){
			$environmentModify = $_POST['environmentEdit'];
			$typeModify = $_POST['typeEdit'];
			$sourceLocationModify = $_POST['sourceLocationEdit'];
			$sourceModify = $_POST['sourceEdit'];
			$sourceIPModify = $_POST['sourceIPEdit'];
			$destinationModify = $_POST['destinationEdit'];
			$destinationLocationModify = $_POST['destinationLocationEdit'];
			$destinationIPModify = $_POST['destinationIPEdit'];
			$destinationPortModify = $_POST['destinationPortEdit'];
			$protocolModify = $_POST['protocolEdit'];
			$URLModify = $_POST['URLEdit'];
			$noteModify = $_POST['noteEdit'];
		}

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
		$passwordPost = NULL;

		if(isset($_POST['add']) || isset($_POST['modify'])){
			//Fills the post information if records are either editted or added.
			$environmentPost = fillPost('environment');
			$typePost = fillPost('type');
			$sourceLocationPost = fillPost('sourceLocation');
			$sourcePost = fillPost('source');
			$sourceIPPost = fillPost('sourceIP');
			$destinationPost = fillPost('destination');
			$destinationLocationPost = fillPost('destinationLocation');
			$destinationIPPost = fillPost('destinationIP');
			$destinationPortPost = fillPost('destinationPort');
			$protocolPost = fillPost('protocol');
			$URLPost = fillPost('URL');
			$notePost = fillPost('note');
			$passwordPost = fillPost('password');
		}
		?>
		<?php //FUNCTION DEFINITION
		function storeTitles($fieldName, &$con){
			//Returns an array of all of the existing titles in the database.
			$fieldQuery = mysqli_query($con, "SELECT $fieldName FROM networkflows") or die(mysqli_error);
			$fieldRows = mysqli_num_rows($fieldQuery);
			for ($i=0; $i<$fieldRows; $i++){
				$title = mysqli_fetch_row($fieldQuery);
				$titleArray[$i] = $title[0];
			}
			$titleArray = array_unique($titleArray);
			$titleArray = array_slice($titleArray, 0);
			return $titleArray;
		}

		function storeColumns(&$con){
			$columnNames = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='networkreference' AND `TABLE_NAME`='networkflows'";
			$columnNames = mysqli_query($con, $columnNames);
			$numColumns = mysqli_num_rows($columnNames);
			for ($i=0; $i<$numColumns; $i++){
				$column = mysqli_fetch_row($columnNames);
				$columnArray[$i] = $column[0];
			}
			return $columnArray;
		}

		function notEmpty($postName){
			//Returns whether or not a post is invalid.
			if ($postName != NULL && $postName != ''){
				return true;
			}
			return false;
		}

		function insertDropdown ($array, $name, $copy){
			echo "<td>";
			echo "<select class='flexselect' name='$name' style='width:80%'>";
			foreach($array as $value){
				if (notEmpty($copy) && $value == $copy){
				echo <<< TEXTLITERAL
				<option value='$value' selected='selected'>$value<br>
TEXTLITERAL;
				}
				else{
					echo <<< TEXTLITERAL
					<option value='$value'>$value<br>
TEXTLITERAL;
				}
			}
			echo "</td>";
		}

		function insertTextbox ($name, $copy){
			echo "<td>";
			if (notEmpty($copy)){
				echo <<< TEXTLITERAL
				<input type="textbox" name="$name" value="$copy">
TEXTLITERAL;
			}
			else{
				echo <<< TEXTLITERAL
				<input type="textbox" name="$name">
TEXTLITERAL;
				}
				echo "</td>";
			}

			function fillPost ($postName){
				//Fills the post data into the page. If it's not filled in or the dropdown isn't specified, returns a null value.
				if (isset($_POST[$postName]) && $_POST[$postName] != "Select a $postName" && $_POST[$postName] != "Select an $postName"){
					$value = $_POST[$postName];
				}
				else{
					$value = NULL;
				}
				return $value;
			}
		?>

		<?php //GET EXISTING TITLES
			$environmentTitles = storeTitles('Environment', $con);
			sort ($environmentTitles);
			$typeTitles = storeTitles('Type', $con);
			sort($typeTitles);
			$sourceLocationArray = storeTitles('sourceLocation', $con);
			sort ($sourceLocationArray);
			$destinationLocationArray = storeTitles('DestinationLocation', $con);
			sort ($destinationLocationArray);
		?>
		<?php //CREATE USER INTERFACE
		if (isset($_POST['copy'])){
			echo "<b>Fields have been copied.<br> Edit any fields required, then click 'Add New Entry' to confirm.</b>";
		}
		else if (isset($_POST['edit'])){
			echo "<b>Edit existing record information below:</b><br>";
		}
		$columnTables = storeColumns($con);
		echo "<form action='/networkflows/newform.php' method='post'>";

		if (isset($_POST['edit'])){
			//Copy over values so they can be editted.
			echo <<< EDITVALUES
			<div id="noDisplay">
			<input type='textbox' name='environmentEdit' value="$environmentAdd"></input>
			<input type='textbox' name='typeEdit' value="$typeAdd"></input>
			<input type='textbox' name='sourceLocationEdit' value="$sourceLocationAdd"></input>
			<input type='textbox' name='sourceEdit' value="$sourceAdd"></input>
			<input type='textbox' name='sourceIPEdit' value="$sourceIPAdd"></input>
			<input type='textbox' name='destinationEdit' value="$destinationAdd"></input>
			<input type='textbox' name='destinationLocationEdit' value="$destinationLocationAdd"></input>
			<input type='textbox' name='destinationIPEdit' value="$destinationIPAdd"></input>
			<input type='textbox' name='destinationPortEdit' value="$destinationPortAdd"></input>
			<input type='textbox' name='protocolEdit' value="$protocolAdd"></input>
			<input type='textbox' name='URLEdit' value="$URLAdd"></input>
			<input type='textbox' name='noteEdit' value="$noteAdd"></input>
			</div>
EDITVALUES;
		}
		echo "<table border='1' width='100%'>";
		//Output first 6 column names.
		echo "<tr>";
		for($i=0; $i<6; $i++){
			$value = $columnTables[$i];
			echo "<td>$value</td>";
		}
		echo "</tr>";
		//Output first 5 row entries.
		echo "<tr>";
		insertDropdown ($environmentTitles, 'environment', $environmentAdd);
		insertDropdown ($typeTitles, 'type', $typeAdd);
		insertDropdown ($sourceLocationArray, 'sourceLocation', $sourceLocationAdd);
		insertTextbox ('source', $sourceAdd);
		insertTextbox ('sourceIP', $sourceIPAdd);
		insertTextbox ('destination', $destinationAdd);
		echo "</tr>";
		//Output last 5 column names.
		echo "<tr>";
		for($i=6; $i<count($columnTables); $i++){
		    $value = $columnTables[$i];
		    echo "<td>$value</td>";
		}
		echo "<td>Password</td>";
		echo "</tr>";
		//Output last 5 column row entries.
		echo "<tr>";
		insertDropdown ($destinationLocationArray, 'destinationLocation', $destinationLocationAdd);
		insertTextbox ('destinationIP', $destinationIPAdd);
		insertTextbox ('destinationPort', $destinationPortAdd);
		insertTextbox ('protocol', $protocolAdd);
		insertTextbox ('URL', $URLAdd);
		insertTextbox ('note', $noteAdd);
		//Output password box.
		echo "<td>" . '<input type="password" name="password">' . "</td>";
		echo "</tr><tr>";

		if (isset($_POST['edit'])){
			echo "<td>" . '<input type="submit" name="modify" value="Edit Existing Entry">' . "</td>";
		}
		else{
			echo "<td>" . '<input type="submit" name="add" value="Add New Entry">' . "</td>";
		}
		echo "</tr></<table>";
		echo "</form>";
        ?>
        <?php //PROCESS INPUT
		if (notEmpty($passwordPost) && $passwordPost != $masterPassword){
			echo "<script>alert('The password is incorrect. No form was submitted')</script>";
		}
		else if (notEmpty($passwordPost) && $passwordPost == $masterPassword){
			//IF NEW ENTRY
			if (isset($_POST['add'])){
				$entry = "INSERT INTO networkflows (environment, type, sourceLocation, source, sourceIP, destination, destinationLocation, destinationIP, destinationPort, protocol, URL, note)
				VALUES ('$_POST[environment]', '$_POST[type]', '$_POST[sourceLocation]', '$_POST[source]', '$_POST[sourceIP]', '$_POST[destination]', '$_POST[destinationLocation]', '$_POST[destinationIP]', '$_POST[destinationPort]', '$_POST[protocol]', '$_POST[URL]', '$_POST[note]')";
				if (!mysqli_query($con, $entry)){
					die('Error: ' . mysqli_error($con));
				}
				else{
					echo "<script>alert('Record successfully added at the bottom of the table!')</script>";
				}
			}
			else if (isset($_POST['modify']) && notEmpty($environmentModify) && notEmpty($typeModify)){
			//IF EDITTING ENTRY
				$entry = "UPDATE networkflows SET environment = '$environmentPost', type = '$typePost',
					sourceLocation = '$sourceLocationPost', source = '$sourcePost', sourceIP = '$sourceIPPost',
					destination = '$destinationPost', destinationLocation = '$destinationLocationPost',
					destinationIP = '$destinationIPPost', destinationPort = '$destinationPortPost',
					protocol = '$protocolPost', URL = '$URLPost', note='$notePost'" .
					" WHERE (environment = '$environmentModify') AND " . "(type = '$typeModify') AND " .
					"(sourceLocation = '$sourceLocationModify') AND " . "(source = '$sourceModify') AND " .  "(sourceIP = '$sourceIPModify') AND " .
					"(destination = '$destinationModify') AND " . "(destinationLocation = '$destinationLocationModify') AND " .
					"(destinationIP = '$destinationIPModify') AND " . "(destinationPort = '$destinationPortModify') AND " .
					"(protocol = '$protocolModify') AND " . "(URL = '$URLModify') AND " . "(note='$noteModify')";
				if (!mysqli_query($con, $entry)){
					die('Error: ' . mysqli_error($con));
				}
				else{
					echo "<script>alert('Record was succesfully editted!')</script>";
				}
			}

			else{
				echo "<script>alert('No records were changed. If you are trying to edit, start from the SQANetworkFlows page.')</script>";
			}
			#echo "<meta http-equiv='refresh' content='.5; url=SQANetworkFlows.php'>";
			echo "<meta http-equiv='refresh' content='.5; url=/networkflows/SQANetworkFlows.php'>";
			mysqli_close($con);
		}//End: Else if
		//End: PROCESS INPUT
		?>
	</div>
</body>
</html>
