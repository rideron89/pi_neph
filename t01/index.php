<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>B200 Test Flight (T01)</title>
		<link href="../style/general.css" rel="stylesheet" type="text/css" />
		<link href="../style/pinnedDataBox.css" rel="stylesheet"
			  type="text/css" />
		<link href="../style/graph.css" rel="stylesheet" type="text/css" />
		<link href="../style/t01.css" rel="stylesheet" type="text/css" />
		<script src="../js/jquery172.js"></script>
		<script src="../js/jqueryui/jqueryui1819.js"></script>
		<script src="../js/utils.js"></script>
		<script src="../js/timeRange.js"></script>
		<script src="js/main.js"></script>
		<script src="../js/p11Log.js"></script>
	</head>
	<body>
		<div id="titleDiv">
			B200 Test Flight (T01)
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
				
				<div id="timeSlider">
					<input id="timeMinus" type="button" value="-"
						onclick="decrement()" />
					<input id="timeRange" type="range" min="0" max="0" step="1"
						value="0" onchange="updateRange()" />
					<input id="timePlus" type="button" value="+"
						onclick="increment()" />
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
		</div> <!-- canvasBox -->
	</body>
</html>