<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>B200 Test Flight (T01)</title>
		
		<link href="../style/ui/theme.css" rel="stylesheet"
			  type="text/css" />
		<link href="../style/general.css" rel="stylesheet" type="text/css" />
		<link href="../style/pinnedDataBox.css" rel="stylesheet"
			  type="text/css" />
		<link href="../style/graph.css" rel="stylesheet" type="text/css" />
		<link href="../style/t01.css" rel="stylesheet" type="text/css" />
		
		<script src="../js/jquery/jquery.js"></script>
		<script src="../js/jquery/jqueryui.js"></script>
		<script src="../js/utils.js"></script>
		<script src="../js/timeSlider.js"></script>
		<script src="js/main.js"></script>
		<script src="../js/p11Log.js"></script>
		<script src="../js/p11.js"></script>
		<script src="../js/scat.js"></script>
		<script src="../js/pres.js"></script>
		<script src="../js/temp.js"></script>
		<script src="../js/rh.js"></script>
	</head>
	<body>
		
		
		<span id="titleDiv">
			<a id="backLink" class="buttonLink" href="..">
				Back
			</a>
			
			B200 Test Flight (T01)
		</span>
		
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
					<input id="minusButton" type="button" value="-" />
					<div id="timeSlider"></div>
					<input id="plusButton" type="button" value="+" />
				</div>
				
				<div id="timeSliderPosition">
					<span id="rangeCurrent">______</span> sec
				</div>
				
				<br />
				
				<div id="timeSelectDiv">
					Mid time (UTC): 
					<select id="timeSelect" onchange="updateSelect()">
					</select> 
					sec
				</div>
				
			</div> <!-- timeSelectionBox -->
			
			<div id="loadingIconDiv">
				<img src="../style/loadingIcon.gif" /><br />
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
	</body>
</html>