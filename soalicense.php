<!DOCTYPE html>
<html>
	<head>
		<title>SOAtest License</title>
		<link rel="stylesheet" href="/css/banner.css" />
		<link rel="stylesheet" href="/css/menu.css" />
		<link rel="stylesheet" href="/css/soatest.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/js/menu.js" /></script>
		<script src="/js/jquery.pivot.js"></script>
	</head>
	<body>
		<?php include_once("/menu.html"); ?>
		<?php
			$csv_output = "";
			
			#Database Connection Info
			$con=mysqli_connect("localhost:3333","grapes_sqauser","sq44$3r","soatest");
			#$con=mysqli_connect("localhost","grapes_sqauser","sq44$3r","soatest"); #MAMP conn
			if (mysqli_connect_errno($con)){
				echo "Failed to conenct to MySQL: " . mysqli_connecterror();
			}
			$sqlSelect = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') as DATE, concat(`username`,' - ',`email`) as INFO,`hostname` as HOST, TRUNCATE((count(1) * 0.23300971), 0) as REFRESHES FROM `licenselog` l, `userinfo` u WHERE l.username = u.userid AND`time` > NOW() - INTERVAL 1 WEEK group by DATE_FORMAT(`time`, '%Y-%m-%d'), username order by DATE_FORMAT(time, '%Y-%m-%d') asc, REFRESHES desc";
			$queryResult = mysqli_query($con, "$sqlSelect") or die(mysqli_error);
			$queryRowNum = mysqli_num_rows($queryResult);
		
			$noTokenQuery = "SELECT time, username, hostname, CONCAT(major,'.', minor) AS version FROM `licenselog` WHERE statusmsg = 'NO_MORE_TOKENS' order by time desc LIMIT 20";
			$noTokenResult = mysqli_query($con, "$noTokenQuery") or die(mysqli_error);
			
			$columnNames = [];
			while ($column = mysqli_fetch_field($queryResult)){
				array_push($columnNames, "$column->name");
				$csv_output .= '"'.$column->name.'",';
			}

			$noTokenArr = [];
			array_push($noTokenArr, ["Latest NO TOKEN Errors","USER","HOST","VERSION"]);
			while ($row = mysqli_fetch_assoc($noTokenResult)){
				array_push($noTokenArr, $row);
			}

		?>	
		
		<div id="page-wrap">
		<div id='legend'>
		<!-- Legend Table-->
			<div class="legendItem greenbg">Has Reserved License</div>
			<div class='legendItem redbg' >Holding lisence over 8 hours</div>
			<!--<span style="font-style: italic; color:#b22222"> - Last "NO TOKEN" Error: </span> -->
			<table id="noTokenTable">
			<?php 
				foreach ($noTokenArr as $line){
					echo "<tr>";
					foreach ($line as $item){
						echo "<td>$item</td>";
					}
					echo "</tr>";
				}
			?>
			</table>
		</div>
		<!-- Results Table-->
		<div id="res"></div>
	
		<!-- Raw Data Table-->
		<table id="sourceTable" class="noDisplay">
			<tbody>
				<tr>
					<!-- <?php foreach ($columnNames as $col){ echo "<th>$col</th>"; }?> -->
					<th data-pivot-pivot="true" data-pivot-dataid="idforpivot" data-pivot-sortbycol="2">DATE</th>
					<th data-pivot-groupbyrank="1">USER</th>
					<th data-pivot-groupbyrank="2">HOST</th>
					<th data-pivot-result="true">REFRESHES</th>
				</tr>
    	        <?php //populate data rows
    	        foreach ($queryResult as $row){
    	            echo "<tr>";
    	            foreach ($row as $data){
    	                echo "<td>$data</td>";
    	            }
    	            echo "</tr>";
    	        }
    	        ?>

			</tbody>
		</table>
		</div>
		
		<script>
		    $(document).ready(function(){
				$('#res').pivot({
		    	    source: $('#sourceTable'),
		    	    formatFunc: function (n) { return jQuery.fn.pivot.formatDK(n, 2); },
		    	    parseNumFunc: function (n) { return +((typeof n === "string") ? +n.replace('.', '').replace(',', '.') : n); },
		    	    bCollapsible : false
		    	});
				$(".level1 .resultcell0").each(function(){
					if ($(this).text() > 8){
						$(this).addClass("redbg");
					}
				});
				var reserved = ["ELS-E89206", "ELS-H35311", "ELS-F11932", "ELS-F19153", "v-pxibm01096", "ELS-H65618", "ELS-H42826", "ELS-E89206", "ELS-H42933", "ELS-H19361", "v-pxibm01075", "v-pxibm01082", "v-pxibm01067", "ELS-H28431"];
				$(".level1 .level1").each(function(){
					if (jQuery.inArray($(this).text(), reserved) > -1){
							$(this).addClass("greenbg");
					}
				});
				$("#noTokenTable").hover(function() {
					$(this).find("tr:nth-child(n+3)").toggle();
				});
			});
		</script>
	</body>
</html>
