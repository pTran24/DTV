<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Chart.js demo</title>
        <!-- import plugin script -->
        <script src='../js/Chart.min.js'></script>
    </head>
    <body>
        <!-- line chart canvas element -->
        <canvas id="buyers" width="600" height="400"></canvas>
        <div id="legendDiv"></div>
		<?php $label = '"January","February","March","AprilFool","May","June"'; ?>
		<script>
            // line chart data
            var firstCol = getRandomColor();
			var lightenFirst = LightenDarkenColor(firstCol, 99);
			var buyerData = {
                //labels : ["January","February","March","April","May","June"],
                labels : [<?php echo $label; ?>],
                datasets : [
                	{
                	    label: 	"First Data Set",
						//fillColor : "rgba(172,194,132,0.4)",
						fillColor : "#fff",
                	    strokeColor : firstCol,
                	    //strokeColor : "#ACC26D",
                	    pointColor : lightenFirst,
                	    pointStrokeColor : "#9DB86D",
                	    pointHighlightFill: "#fff",
                	    data : [203,156,99,251,305,247]
                	},
					{
                	    label: "My Second dataset",
                	    fillColor: "#fff",
                	    //strokeColor: "rgba(151,187,205,1)",
                	    strokeColor: getRandomColor(),
                	    pointColor: "rgba(151,187,205,1)",
                	    pointStrokeColor: "#fff",
                	    pointHighlightFill: "#fff",
                	    pointHighlightStroke: "rgba(151,187,205,1)",
                	    data: [28, 48, 40, 19, 86, 27, 90]
                	}
            	]
            }
            // get line chart canvas
            var myLineChart = new Chart(document.getElementById('buyers').getContext('2d')).Line(buyerData, {datasetStrokeWidth: 5});
            // draw line chart
			document.getElementById("legendDiv").innerHTML = myLineChart.generateLegend();
			
			function getRandomColor() {
			    var letters = '0123456789ABCDEF'.split('');
			    var color = '#';
			    for (var i = 0; i < 6; i++ ) {
			        color += letters[Math.floor(Math.random() * 15)];
			    }
			    return color;
			}
			
			function LightenDarkenColor(col, amt) {
		    	var usePound = false;
			    if (col[0] == "#") {
			        col = col.slice(1);
			        usePound = true;
			    }
			 
			    var num = parseInt(col,16);
			    var r = (num >> 16) + amt;
			 
			    if (r > 255) r = 255;
			    else if  (r < 0) r = 0;
			 
			    var b = ((num >> 8) & 0x00FF) + amt;
			 
			    if (b > 255) b = 255;
			    else if  (b < 0) b = 0;
			 
			    var g = (num & 0x0000FF) + amt;
			 
			    if (g > 255) g = 255;
			    else if (g < 0) g = 0;
			 
			    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
			}

        </script>
    </body>
</html>
