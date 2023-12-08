<?php
 
$dataPoints = array( 
	array("y" => 10, "label" => "Roads and highways" ),
	array("y" => 4, "label" => "Residential" ),
	array("y" => 12, "label" => "Schools" ),
	array("y" => 3, "label" => "Safety & security" ),
	array("y" => 7, "label" => "I&F" ),
	array("y" => 2, "label" => "Animal welfare" ),
	array("y" => 1, "label" => "Others" )   
);	
 
?>
<!DOCTYPE HTML>
<html>
<head>
    <style>
        .canvasjs-chart-credit {
            display: none;
        }
    </style>
<script>
	window.onload = function() {
	
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light2",
		title:{
			text: "No. of concerns received per concern type"
		},
		axisY: {
			title: ""
		},
		data: [{
			type: "column",
			yValueFormatString: "#,##0.## concerns",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	}
</script>
</head>
<body>
	<div id="chartContainer" style="height: 380px; width: 80%;"></div>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>