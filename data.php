<?php
	if(isset($_GET["flight"]))
	{
		$flight = $_GET["flight"];
	}
	else
	{
		$flight = "t01";
	}
	
	$flight_titles = array(
		"t01" => "B200 Test Flight",
		"r01" => "Spirals: LaRC, Wallops, COVE",
		"r02" => "CALIPSO: Eastern",
		"r03" => "Jackson Transit",
		"r04" => "Jackson Local, CALIPSO & fires",
		"r05" => "UC12 to LaRC, B200 to AVL, Spiral: Tusc.",
		"r06" => "B200 to LaRC",
		"r07" => "Spirals: LaRC, Wallops, COVE",
		"r08" => "local fire: Spirals: LaRC, Wallops, COVE",
		"r09" => "Groton Transit, M.A.: Brookhaven",
		"r10" => "Groton Local #1, M.V., Th.F. & H.F.",
		"r11" => "Groton Local #2, M.V., Th.F. & H.F.",
		"r12" => "LaRC Transit, Spiral: Wallops"
	);
	
	$flight_start_times = array(
		"t01" => 66,
		"r01" => 43,
		"r02" => 62,
		"r03" => 43,
		"r04" => 66,
		"r05" => 54,
		"r06" => 67,
		"r07" => 64,
		"r08" => 0,
		"r09" => 0,
		"r10" => 0,
		"r11" => 0,
		"r12" => 0
	);
	
	$flight_end_times = array(
		"t01" => 75,
		"r01" => 53,
		"r02" => 72,
		"r03" => 53,
		"r04" => 76,
		"r05" => 65,
		"r06" => 76,
		"r07" => 75,
		"r08" => 0,
		"r09" => 0,
		"r10" => 0,
		"r11" => 0,
		"r12" => 0
	);
	
	function get_flight_toc_item($flight)
	{
		global $flight_titles;
		
		$output = "<div><a ";
		$output .= "class='flight_toc_item'";
		$output .= " href='data.php?flight=" . $flight . "'";
		$output .= " title='" . $flight_titles[$flight] . "'>";
		$output .= strtoupper($flight);
		$output .= "</a></div>";
		
		return $output;
	}
	
	function print_flight_toc()
	{
		global $flight;
		
		$html_output = "<div id='flight_toc_current_flight' title='Current Flight'>" . strtoupper($flight) . "</div>";
		
		$html_output .= get_flight_toc_item("t01");
		$html_output .= get_flight_toc_item("r01");
		$html_output .= get_flight_toc_item("r02");
		$html_output .= get_flight_toc_item("r03");
		$html_output .= get_flight_toc_item("r04");
		$html_output .= get_flight_toc_item("r05");
		$html_output .= get_flight_toc_item("r06");
		$html_output .= get_flight_toc_item("r07");
		$html_output .= get_flight_toc_item("r08");
		$html_output .= get_flight_toc_item("r09");
		$html_output .= get_flight_toc_item("r10");
		$html_output .= get_flight_toc_item("r11");
		$html_output .= get_flight_toc_item("r12");
		
		return $html_output;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title><?php echo $flight_titles[$flight]; ?></title>
	
	<link rel="stylesheet" type="text/css" href="style/ui/jqueryui.css" />
	<link rel="stylesheet/less" type="text/css" href="style/main.less" />
	
	<script type="text/javascript" src="js/lib/less.js"></script>
	<script type="text/javascript" src="js/lib/jquery.js"></script>
	<script type="text/javascript" src="js/lib/jqueryui.js"></script>
	
	<?php
	
		echo "<script type=\"text/javascript\">";
		echo "var flight = \"" . $flight . "\";";
		echo "var minTime = parseInt(" . $flight_start_times[$flight] . ");";
		echo "var maxTime = parseInt(" . $flight_end_times[$flight] . ");";
		echo "</script>";
	
	?>
</head>
<body>
	
	<div id="title_div">
		<h2><?php echo $flight_titles[$flight] . " (" . strtoupper($flight) . ")"; ?></h2>
	</div>
	
	<div>
		<a id="back_link" class="ui-button_link" href="/pi_neph">Back</a>
	</div>
	
	<div id="pinnedDataBox">
		<div id="browserMessage">
			Optimized for Chrome & Firefox
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
	
	<div id="graph_toc_box">
		<div id="graph_toc_label" onclick="toggle_graph_toc()">
			Graph Headers
		</div>
		
		<div id="graph_toc_item_list">
			<button class="graph_toc_item"  onclick="graph_toc_item('p11LogCanvasDiv')">
				P11, aerosol only phase function
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('p11CanvasDiv')">
				P11, aerosol only phase function (small)
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('p12CanvasDiv')">
				-P12/P11, aerosol only degree of linear polarization
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('scatCanvasDiv')">
				Linear Scattering Coefficient
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('mapCanvasDiv')">
				Aircraft Flight Path
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('altCanvasDiv')">
				GPS Altitude
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('presCanvasDiv')">
				Pressure Inside PI-Neph Chamber
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('tempCanvasDiv')">
				Temperature Inside PI-Neph Chamber
			</button><br />
			<button class="graph_toc_item" onclick="graph_toc_item('rhCanvasDiv')">
				Relative Humidity
			</button>
		</div>
	</div> <!-- graph_toc_box -->
	
	<div id="flight_toc_box">
		<div id="flight_toc_label">&uarr;&nbsp;&nbsp;&nbsp;Table of Contents&nbsp;&nbsp;&nbsp;&uarr;</div>
		<div id="flight_toc_item_list">
			<?php echo print_flight_toc(); ?>
		</div>
	</div> <!-- flight_toc_box -->
	
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
</body>

	<script type="text/javascript" src="js/utils.js"></script>
	<script type="text/javascript" src="js/timeSlider.js"></script>
	<script type="text/javascript" src="js/toc.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/p11Log.js"></script>
	<script type="text/javascript" src="js/p11.js"></script>
	<script type="text/javascript" src="js/p12.js"></script>
	<script type="text/javascript" src="js/scat.js"></script>
	<script type="text/javascript" src="js/map.js"></script>
	<script type="text/javascript" src="js/alt.js"></script>
	<script type="text/javascript" src="js/pres.js"></script>
	<script type="text/javascript" src="js/temp.js"></script>
	<script type="text/javascript" src="js/rh.js"></script>
</html>
