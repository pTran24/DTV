<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>

    <title>TDM Query</title>
    <link rel="stylesheet" href="css/banner.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="css/tdmquery.css" />
<!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />-->
</head>
<body>
    <?php include_once("menu.html"); ?>
    <div id='page-wrap'>
        <form id="tdmForm" action="run_tdmquery.php" method="post">
            OM.<font color="blue">ACCTNUM</font> <strong>IN</strong> <strong>(</strong> <input id="acctNum" name="acctNum" rows="1" size="100" placeholder="71763144, 71763137"></input> <strong>)</strong><br />
            O.<font color="blue">ORDERDATE</font> >= <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input id="beginDate" name="beginDate" type="text" placeholder="2"></input> , 111<strong>))</strong> <br />
            O.<font color="blue">ORDERDATE</font> < <font color="purple">CONVERT</font><strong>(</strong>DATETIME,CONVERT<strong>(</strong>VARCHAR<strong>(</strong><font color="green">10</font><strong>)</strong>, GETDATE<strong>()</strong>- <input id="endDate" name="endDate" type="text" placeholder="1"></input> , 111<strong>))</strong> <br />
			<br />
            <input id="sub" type="submit" value="Run Query"></input>
        </form>
		<br />
		<ul id="tabs">
      		<li><a id="query">Query</a></li>
      		<li><a id="result">Result</a></li>
      		<li><a id="download">Download</a></li>
		</ul>
		<div class="container" id="queryC">1Some content</div>
		<div class="container" id="resultC">2Some content</div>
		<div class="container" id="downloadC">Your download has began.</div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
	<!--<script src="js/tdm_query.js"></script>-->
	<!--<script src="js/autosize.js"></script>-->
	<script>
	$(document).ready(function() {    
		$('#tabs li a:not(:first)').addClass('inactive');
		$('.container').hide();
		$('.container:first').show();

		$('#tabs li a').click(function(){
    		var t = $(this).attr('id');
  			if($(this).hasClass('inactive')){ //this is the start of our condition 
    			$('#tabs li a').addClass('inactive');           
    			$(this).removeClass('inactive');
    			$('.container').hide();
    			$('#'+ t + 'C').fadeIn('slow');
 			}
		});
	});
	</script>
</body>
</html>
