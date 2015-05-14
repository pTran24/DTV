<!DOCTYPE html>
<html>
<head>
    <title>Network Flows</title>
    <link rel="stylesheet" href="../css/banner.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="../css/network.css" />
    <link rel="stylesheet" href="../css/flexselect.css" type="text/css" media="screen" />
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/liquidmetal.js" type="text/javascript"></script>
    <script src="../js/jquery.flexselect.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
            $("select.flexselect").flexselect();
        });
    </script>
</head>
<body>
    <?php include_once("../banner_nav.html"); ?>
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

        #Database Connection Info
        $con=mysqli_connect("$host","$user","$pw","networkreference");
        if (mysqli_connect_errno($con)){
            //Check connection
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $environmentPost = NULL;
        $typePost = NULL;
        $sourcePost = NULL;
        $sourceLocationPost = NULL;
        $destinationPost = NULL;
        $destinationLocationPost = NULL;
        $orderPost = NULL;

        //If $_POST is defined. Set Post Variables.
        if (isset($_POST['submit'])) {
            $environmentPost = fillPost('Environment');
            $typePost = fillPost('Type');
            $sourceLocationPost = fillPost('SourceLocation');
            $sourcePost = fillPost('Source');
            $destinationPost = fillPost('Destination');
            $destinationLocationPost = fillPost('DestinationLocation');
            $orderPost = fillPost('Order');
        }
        ?>

        <?php //FUNCTION DEFINITIONS
        //Grabs column values from the database, returns an array. Note: Title = COLUMN
        function storeTitles($fieldName, &$con){
            $Query = "SELECT $fieldName FROM networkflows";
            //$fieldQuery = mysqli_query($con, "SELECT $fieldName FROM networkflows") or die(mysqli_error);
            $fieldQuery = mysqli_query($con, "$Query") or die(mysqli_error);
            $fieldRows = mysqli_num_rows($fieldQuery);
            for ($i=0; $i<$fieldRows; $i++){
                $title = mysqli_fetch_row($fieldQuery);
                $titleArray[$i] = $title[0];
            }
            $titleArray = array_unique($titleArray);
            $titleArray = array_slice($titleArray, 0);
            $fieldRows = count($titleArray);
            return $titleArray;
        }

        //Grabs COLUMN NAMES from database, returns an array.
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

        //Determines if a value is in the post data or not.
        //Assists with marking a box as checked after a search is made.
        function valueContained ($value, $postName){
            if (!isset($_POST['submit'])){
                //If there's no post data yet.
                return false;
            }
            if (is_array($postName)){
                for ($i=0; $i<count($postName); $i++){
                    if ($postName[$i] == $value){
                        return true;
                    }
                }
                return false;
            }
            else{
            //The value and postName are strings
                if ($value == $postName){
                    return true;
                }
                return false;
            }
        }

        //Outputs each array onto the page for search UI
        function displayArray($title, $array, $isCheckbox, $postName){
            //echo "<td>";
            //echo "<b>$title:</b><br>";
            //Output checkbox
            if ($isCheckbox){
                echo "<td>";
                echo "<b>$title:</b><br>";
                foreach($array as $value){
                    $checkValue = valueContained($value, $postName);
                    if ($checkValue){
                    //Check it if a user just submitted a form with it checked.
                        echo "<input type='checkbox' name=$title" . '[] ' . "value =$value checked = 'yes'>$value";
                        //echo "This is value: $title[1] \n";
                        //echo "<input type='checkbox' name=$title[0] value =$value checked = 'yes'>$value";
                        echo "<br>";
                    }
                    else{
                        echo "<input type='checkbox' name=$title" . '[] ' . " value =$value>$value";
                        echo "<br>";
                    }
                }
                echo "</td>";
            }
            else{
                //Output dropdown
                echo "<b>$title:</b><br />";
                echo "<select name=$title>";
                //echo "<option>Select $title </option>";
                foreach($array as $value){
                    $selectValue = valueContained ($value, $postName);
                    if ($selectValue){
                        //Check it if a user just submitted a form with it checked.
                        echo "<option value='" . $value . "' selected='yes'>$value</option>";
                    }
                    else{
                        echo "<option value='" . $value . "'>$value</option>";
                    }
                }//End foreach
                echo '</select><br />';
            }
            //echo "</td>"; //Organizing 'Search' dropdowns 2014-05-26
        }
        function fillPost ($postName){
            //Fills the post data into the page. If it's not filled in or the dropdown isn't specified, returns a null value.
            if (isset($_POST[$postName])){
                $value = $_POST[$postName];
            }
            else{
                $value = NULL;
            }
            return $value;
        }
        ?>
        <?php //CREATE TITLE ARRAYS FROM EXISTING DATA
            $environmentTitles = storeTitles('environment', $con);
            sort ($environmentTitles);
            $typeTitles = storeTitles('type', $con);
            sort ($typeTitles);
            $sourceLocationTitles = storeTitles('sourceLocation', $con);
            sort ($sourceLocationTitles);
            $sourceTitles = storeTitles('source', $con);
            sort ($sourceTitles);
            $destinationTitles = storeTitles('destination', $con);
            sort ($destinationTitles);
            $destinationLocationTitles = storeTitles('destinationLocation', $con);
            sort ($destinationLocationTitles);
            $columnTitles = storeColumns($con);
        ?>

        <div id="search">
            <h3>Query Options:</h3>
            <?php //OUTPUT SEARCH INTERFACE
            echo "<form action='/networkflows/SQANetworkFlows.php' method='post'>";
            echo "<table><tr>";
            displayArray ('Environment', $environmentTitles, 1, $environmentPost);
            displayArray ('Type', $typeTitles, 1, $typePost);
            echo "<td>";
            displayArray ('SourceLocation', $sourceLocationTitles, 0, $sourceLocationPost);
            displayArray ('Source', $sourceTitles, 0, $sourcePost);
            displayArray ('DestinationLocation', $destinationLocationTitles, 0, $destinationLocationPost);
            displayArray ('Destination', $destinationTitles, 0, $destinationPost);
            displayArray ('Order', $columnTitles, 0, $orderPost);
            echo "</td>";
            echo "</tr></table>";
            echo '<input type="submit" name="submit" value="Search Records"> ';
            echo <<<BUTTONS
            <button type="button" onclick="window.open('/networkflows/SQANetworkFlows.php', '_self')">Clear Search</button>
            <button type="button" onclick="window.open('/networkflows/deleted.php', '_self')">Deleted Records</button>
BUTTONS;
            echo "</form>";
        ?>
        </div>

        <?php //CREATE Search Query.
        //$resultClause = "SELECT * FROM networkflows where environment = 'Sources'";
        $resultClause = "SELECT * FROM networkflows";

        if (!isset($_POST['submit'])) {
            $resultClause = "SELECT * FROM networkflows ORDER BY environment, type, sourceLocation, sourceIP, destination LIMIT 10;";
        }

        $whereExists = FALSE;
        $orderExists = FALSE;
        $resultQuery = mysqli_query($con, $resultClause);

        $environmentTotal = count($environmentTitles);
        $environmentCount = count($environmentPost);
        $typeTotal = count($typeTitles);
        $typeCount = count($typePost);

        //Create Query if user defined
        if ($environmentCount > 0){
            $resultClause .= ' WHERE (';
            for ($i=0 ;$i<$environmentCount-1; $i++){
                    $resultClause .= "environment = '$environmentPost[$i]' OR ";
            }
            $resultClause .= "environment =  '$environmentPost[$i]')";
            $whereExists = TRUE;
        }
        if ($typeCount > 0){
            if ($whereExists){
                $resultClause .= ' AND (';
            }
            else{
                $resultClause .= ' WHERE (';
            }
            for ($y=0 ;$y<$typeCount-1; $y++){
                $resultClause .= "type = '$typePost[$y]' OR ";
            }
            $resultClause .= "type =  '$typePost[$y]')";
            $whereExists = TRUE;
        }
        if ($sourceLocationPost != ''){
            if ($whereExists){
                $resultClause = $resultClause . " AND (sourceLocation = '$sourceLocationPost')";
            }
            else{
                $resultClause = $resultClause . " WHERE (sourceLocation = '$sourceLocationPost')";
            }
            $whereExists = TRUE;
        }
        if ($sourcePost != ''){
            if ($whereExists){
                $resultClause = $resultClause . " AND (source = '$sourcePost')";
            }
            else{
                $resultClause = $resultClause . " WHERE (source = '$sourcePost')";
            }
            $whereExists = TRUE;
        }
        if ($destinationPost != ''){
            if ($whereExists){
                $resultClause = $resultClause . " AND (destination = '$destinationPost')";
            }
            else{
                $resultClause = $resultClause . " WHERE (destination = '$destinationPost')";
            }
            $whereExists = TRUE;
        }
        if ($destinationLocationPost != ''){
            if ($whereExists){
                $resultClause = $resultClause . " AND (destinationLocation = '$destinationLocationPost')";
            }
            else{
                $resultClause = $resultClause . " WHERE (destinationLocation = '$destinationLocationPost')";
            }
            $whereExists = TRUE;
        }
        if ($orderPost != ''){
            $resultClause = $resultClause . " ORDER BY " . $orderPost;
            $orderExists = TRUE;
        }
        if ($whereExists || $orderExists){
            $resultQuery = mysqli_query($con, $resultClause);
        }
        ?>

        <?php //CREATE RESULT TABLE
        $querySize = mysqli_num_rows($resultQuery);
        echo "<div id='results'>";
        echo "<h3>Query Results:</h3>";
        echo "Total rows returned: <b>$querySize</b> <br>";
        //$resultClause = str_replace("*","all",$resultClause);
        echo "Your search query: <b>$resultClause</b> <br>";

        echo '<form action="/networkflows/newform.php" method=post>';
        echo '<input type="submit" name="add" value="Add New Entry">';
        echo '</form>';

        if ($querySize > 0){
            echo "<table border='1' cellspacing='2'><tr>";
            echo "<th></th><th>Row#</th>";
            foreach($columnTitles as $value) {
                echo "<th>" . $value . "</th>";
            }
            echo "</tr>";

            for ($i=1; $i<$querySize+1; $i++) {
                $row = mysqli_fetch_array($resultQuery);
                echo "<tr>";
                $environmentValue = $row['environment'];
                $typeValue = $row['type'];
                $sourceLocationValue = $row['sourceLocation'];
                $sourceValue = $row['source'];
                $sourceIPValue = $row['sourceIP'];
                $destinationValue = $row['destination'];
                $destinationLocationValue = $row['destinationLocation'];
                $destinationIPValue = $row['destinationIP'];
                $destinationPortValue = $row['destinationPort'];
                $protocolValue = $row['protocol'];
                $URLValue = $row['URL'];
                $noteValue = $row['note'];

                echo <<< COPYVALUES
                <td><form action='/networkflows/newform.php' method='post'>
                    <div id='noDisplay'>
                        <input type='textbox' name='environmentCopy' value="$environmentValue"></input>
                        <input type='textbox' name='typeCopy' value="$typeValue"></input>
                        <input type='textbox' name='sourceLocationCopy' value="$sourceLocationValue"></input>
                        <input type='textbox' name='sourceCopy' value="$sourceValue"></input>
                        <input type='textbox' name='sourceIPCopy' value="$sourceIPValue"></input>
                        <input type='textbox' name='destinationCopy' value="$destinationValue"></input>
                        <input type='textbox' name='destinationLocationCopy' value="$destinationLocationValue"></input>
                        <input type='textbox' name='destinationIPCopy' value="$destinationIPValue"></input>
                        <input type='textbox' name='destinationPortCopy' value="$destinationPortValue"></input>
                        <input type='textbox' name='protocolCopy' value="$protocolValue"></input>
                        <input type='textbox' name='URLCopy' value="$URLValue"></input>
                        <input type='textbox' name='noteCopy' value="$noteValue"></input>
                    </div>

                    <input type="submit" value="Copy Record" name="copy">
                    <input type="submit" value="Edit Record" name="edit">
                </form>
COPYVALUES;
                echo <<< DELETEVALUES
                <form action='/networkflows/deleteform.php' method='post'>
                <div id='noDisplay'>
                    <input type='textbox' name='environmentDelete' value="$environmentValue"></input>
                    <input type='textbox' name='typeDelete' value="$typeValue"></input>
                    <input type='textbox' name='sourceLocationDelete' value="$sourceLocationValue"></input>
                    <input type='textbox' name='sourceDelete' value="$sourceValue"></input>
                    <input type='textbox' name='sourceIPDelete' value="$sourceIPValue"></input>
                    <input type='textbox' name='destinationDelete' value="$destinationValue"></input>
                    <input type='textbox' name='destinationLocationDelete' value="$destinationLocationValue"></input>
                    <input type='textbox' name='destinationIPDelete' value="$destinationIPValue"></input>
                    <input type='textbox' name='destinationPortDelete' value="$destinationPortValue"></input>
                    <input type='textbox' name='protocolDelete' value="$protocolValue"></input>
                    <input type='textbox' name='URLDelete' value="$URLValue"></input>
                    <input type='textbox' name='noteDelete' value="$noteValue"></input>
                </div>
                <input type="submit" value="Delete Record" name="delete">
                </form></td>
DELETEVALUES;
                //Values in the outputted table. Populate Result Table
                echo <<< TABLEVALUES
                <td>$i</td>
                <td>$environmentValue</td>
                <td>$typeValue</td>
                <td>$sourceLocationValue</td>
                <td>$sourceValue</td>
                <td>$sourceIPValue</td>
                <td>$destinationValue</td>
                <td>$destinationLocationValue</td>
                <td>$destinationIPValue</td>
                <td>$destinationPortValue</td>
                <td>$protocolValue</td>
                <td>$URLValue</td>
                <td>$noteValue</td>
TABLEVALUES;
                echo "</tr>";
            }//End For loop
        }//End If statement
        else {
            echo "<br>No results found...";
        }
        echo "</table></div>";
        //END CREATE RESULT TABLE
        ?>
    </div>
</body>
</html>
