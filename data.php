<?php
	if(!isset($_GET["flight"]))
	{
		$flight = "t01";
	}
	else
	{
		$flight = $_GET["flight"];
	}
	
	if(strcmp("r01", $flight) == 0)
		$flight_title = "Spirals: LaRC, Wallops, COVE";
	else if(strcmp("r02", $flight) == 0)
		$flight_title = "CALIPSO: Eastern";
	else if(strcmp("r03", $flight) == 0)
		$flight_title = "Jackson Transit";
	else if(strcmp("r04", $flight) == 0)
		$flight_title = "Jackson Local, CALIPSO & fires";
	else if(strcmp("r05", $flight) == 0)
		$flight_title = "UC12 to LaRC, B200 to AVL, Spiral: Tusc.";
	else if(strcmp("r06", $flight) == 0)
		$flight_title = "B200 to LaRC";
	else if(strcmp("r07", $flight) == 0)
		$flight_title = "Spirals: LaRC, Wallops, COVE";
	else if(strcmp("r08", $flight) == 0)
		$flight_title = "local fire: Spirals: LaRC, Wallops, COVE";
	else if(strcmp("r09", $flight) == 0)
		$flight_title = "Groton Transit, M.A.: Brookhaven";
	else if(strcmp("r10", $flight) == 0)
		$flight_title = "Groton Local #1, M.V., Th.F. & H.F.";
	else if(strcmp("r11", $flight) == 0)
		$flight_title = "Groton Local #2, M.V., Th.F. & H.F.";
	else if(strcmp("r12", $flight) == 0)
		$flight_title = "LaRC Transit, Spiral: Wallops";
	else
		$flight_title = "B200 Test Flight";
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title><?php echo $flight_title; ?></title>
	
	<link rel="stylesheet" type="text/css" href="style/ui/jqueryui.css" />
	<link rel="stylesheet/less" type="text/css" href="style/main.less" />
	
	<script type="text/javascript" src="js/less.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.js"></script>
	<script type="text/javascript" src="js/jquery/jqueryui.js"></script>

	<script type="text/javascript">
		var flight = "<?php echo $flight; ?>";
		var minTime = 43;
	</script>
</head>
<body>
	
	<div id="title_div">
		<h2><?php echo $flight_title . " (" . strtoupper($flight) . ")"; ?></h2>
	</div>
	
	<div>
		<a id="back_link" class="ui-button_link" href="/pi_neph">Back</a>
	</div>
	
	<div id="pinnedDataBox">
		<div id="browserMessage">
			Optimized for Google Chrome
		</div>
		
		<br />
		
		<div id="timeSelectionBox">
			<div id="timeSliderLabel">
				Graph Time (Seconds)
			</div>
			
			<div id="timeSliderDiv">
				<input id="minusButton" class="ui-button_link-small" type="button" value="-" />
				<div id="timeSlider"></div>
				<input id="plusButton" class="ui-button_link-small" type="button" value="+" />
			</div>
			
			<div id="timeSliderPosition">
				<span id="rangeCurrent">______</span> sec
			</div>
			
			<br />
			
			<div id="timeSelectDiv">
				Mid time (UTC): 
				<select id="timeSelect" class="ui-select_box" onchange="updateSelect()"></select> 
				sec
			</div>
			
		</div> <!-- timeSelectionBox -->
		
		<div id="loadingIconDiv">
			<img src="style/images/ajax-loader.gif" /><br />
			Data is loading...
		</div>
		
		<div id="dataInformationBox">
			Start UTC: <span id="startUTC"></span> sec<br />
			End UTC: <span id="endUTC"></span> sec<br />
			HH:MM:SS UTC: <span id="calendar"></span><br />
			SCAT: <span id="scat"></span> 1/Mm<br />
			PRES: <span id="pres"></span> Pa<br />
			TEMP: <span id="temp"></span> K<br />
			RH1 (inlet): <span id="rh1"></span>%<br />
			RH2 (chamber): <span id="rh2"></span>%<br />
			RH3 (outlet): <span id="rh3"></span>%<br />
			Aircraft Latitude: <span id="lat"></span><br />
			Aircraft Longitude: <span id="lon"></span><br />
			GPS Altitude: <span id="alt"></span> feet
		</div>
		
		<div id="errorInfoDiv">
		</div>
		
		<div id="warningInfoDiv">
		</div>
	</div> <!-- pinnedDataBox -->
	
	<div id="toc_box">
		<div id="toc_label" onclick="toggleToc()">
			Table of Contents
		</div>
		
		<div id="toc_item_list">
			<button class="toc_item"  onclick="tocItem('p11LogCanvasDiv')">
				P11, aerosol only phase function
			</button><br />
			<button class="toc_item" onclick="tocItem('p11CanvasDiv')">
				P11, aerosol only phase function (small)
			</button><br />
			<button class="toc_item" onclick="tocItem('p12CanvasDiv')">
				-P12/P11, aerosol only degree of linear polarization
			</button><br />
			<button class="toc_item" onclick="tocItem('scatCanvasDiv')">
				Linear Scattering Coefficient
			</button><br />
			<button class="toc_item" onclick="tocItem('altCanvasDiv')">
				GPS Altitude
			</button><br />
			<button class="toc_item" onclick="tocItem('presCanvasDiv')">
				Pressure Inside PI-Neph Chamber
			</button><br />
			<button class="toc_item" onclick="tocItem('tempCanvasDiv')">
				Temperature Inside PI-Neph Chamber
			</button><br />
			<button class="toc_item" onclick="tocItem('rhCanvasDiv')">
				Relative Humidity
			</button>
		</div>
	</div> <!-- tocBox -->
	
	<div id="canvasBox">
		<div id="p11LogCanvasDiv" class="canvasDiv">
			<div id="p11LogCanvasTitle" class="canvasTitle"></div>
			<div id="p11LogYAxisTitle" class="yAxisTitle"></div>
			<div id="p11LogXAxisTitle" class="xAxisTitle"></div>
			<canvas id="p11LogGraph" class="graph"></canvas>
			<canvas id="p11LogDataPoints" class="dataPoints"></canvas>
		</div>
		
		<div id="p11CanvasDiv" class="canvasDiv">
			<div id="p11CanvasTitle" class="canvasTitle"></div>
			<div id="p11YAxisTitle" class="yAxisTitle"></div>
			<div id="p11XAxisTitle" class="xAxisTitle"></div>
			<canvas id="p11Graph" class="graph"></canvas>
			<canvas id="p11DataPoints" class="dataPoints"></canvas>
		</div>
		
		<div id="p12CanvasDiv" class="canvasDiv">
			<div id="p12CanvasTitle" class="canvasTitle"></div>
			<div id="p12YAxisTitle" class="yAxisTitle"></div>
			<div id="p12XAxisTitle" class="xAxisTitle"></div>
			<canvas id="p12Graph" class="graph"></canvas>
			<canvas id="p12DataPoints" class="dataPoints"></canvas>
		</div>
		
		<div id="scatCanvasDiv" class="canvasDiv">
			<div id="scatCanvasTitle" class="canvasTitle"></div>
			<div id="scatYAxisTitle" class="yAxisTitle"></div>
			<div id="scatXAxisTitle" class="xAxisTitle"></div>
			<canvas id="scatGraph" class="graph"></canvas>
			<canvas id="scatDataPoints" class="dataPoints"></canvas>
			<canvas id="scatTimeLine" class="timeLine"></canvas>
		</div>
		
		<div id="mapCanvasDiv" class="canvasDiv">
			<div id="mapTitle"></div>
			<div id="mapCanvas"></div>
		</div>
		
		<div id="altCanvasDiv" class="canvasDiv">
			<div id="altCanvasTitle" class="canvasTitle"></div>
			<div id="altYAxisTitle" class="yAxisTitle"></div>
			<div id="altXAxisTitle" class="xAxisTitle"></div>
			<canvas id="altGraph" class="graph"></canvas>
			<canvas id="altDataPoints" class="dataPoints"></canvas>
			<canvas id="altTimeLine" class="timeLine"></canvas>
		</div>
		
		<div id="presCanvasDiv" class="canvasDiv">
			<div id="presCanvasTitle" class="canvasTitle"></div>
			<div id="presYAxisTitle" class="yAxisTitle"></div>
			<div id="presXAxisTitle" class="xAxisTitle"></div>
			<canvas id="presGraph" class="graph"></canvas>
			<canvas id="presDataPoints" class="dataPoints"></canvas>
			<canvas id="presTimeLine" class="timeLine"></canvas>
		</div>
		
		<div id="tempCanvasDiv" class="canvasDiv">
			<div id="tempCanvasTitle" class="canvasTitle"></div>
			<div id="tempYAxisTitle" class="yAxisTitle"></div>
			<div id="tempXAxisTitle" class="xAxisTitle"></div>
			<canvas id="tempGraph" class="graph"></canvas>
			<canvas id="tempDataPoints" class="dataPoints"></canvas>
			<canvas id="tempTimeLine" class="timeLine"></canvas>
		</div>
		
		<div id="rhCanvasDiv" class="canvasDiv">
			<div id="rhCanvasTitle" class="canvasTitle"></div>
			<div id="rhYAxisTitle" class="yAxisTitle"></div>
			<div id="rhXAxisTitle" class="xAxisTitle"></div>
			<canvas id="rhGraph" class="graph"></canvas>
			<canvas id="rh1DataPoints" class="dataPoints"></canvas>
			<canvas id="rh2DataPoints" class="dataPoints"></canvas>
			<canvas id="rh3DataPoints" class="dataPoints"></canvas>
			<canvas id="rhTimeLine" class="timeLine"></canvas>
			<canvas id="rhLegend" class="legend"></canvas>
		</div>
	</div> <!-- canvasBox -->
	
	<script src="js/utils.js"></script>
	<script src="js/timeSlider.js"></script>
	<script src="js/toc.js"></script>
	<script src="js/main.js"></script>
	<script src="js/p11Log.js"></script>
	<script src="js/p11.js"></script>
	<script src="js/p12.js"></script>
	<script src="js/scat.js"></script>
	<script src="js/map.js"></script>
	<script src="js/alt.js"></script>
	<script src="js/pres.js"></script>
	<script src="js/temp.js"></script>
	<script src="js/rh.js"></script>
</body>
</html>
