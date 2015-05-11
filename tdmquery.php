<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>

    <title>TDM Query</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/tdmquery.css" />
</head>
<body>
    <?php include_once("menu.html"); ?>
    <div id='page-wrap'>
        <form id="myForm" action="tdmquery_db.php" method="post">
            OM.<font color="blue">ACCTNUM</font> <strong>IN</strong> <strong>(</strong> <input name="acctNum" rows="1" size="100" placeholder="71763144, 71763137"></input> <strong>)</strong><br />
            O.<font color="blue">ORDERDATE</font> >= <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input name="beginDate" type="text" placeholder="2"></input> , 111<strong>))</strong> <br />
            O.<font color="blue">ORDERDATE</font> < <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input name="endDate" type="text" placeholder="1"></input> , 111<strong>))</strong> <br />
            <input id="sub" type="submit" value="Run Query"></input>
        </form>

        <div id="result">Results displayed here</div>
    </div>

    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/my_script.js"></script>
    <script src="js/autosize.js"></script>
    <script>
        $(document).ready( function(){
            autosize(document.querySelectorAll('textarea'));
        });
    </script>
</body>
</html>
