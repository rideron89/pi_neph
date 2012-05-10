var time = 0;

$(document).ready(function()
{
	$("#loadingIconDiv").slideDown(400);
	
	$("#timeSlider").slider({
		slide: updateDisplayTime,
		change: updateSlider
	});
	
	$("input:button").button();
	
	$("#minusButton").click(decrement);
	$("#plusButton").click(increment);
	
	readTimes();
});

$(document).ajaxStop(function()
{
	$("#loadingIconDiv").slideUp(400);
});

/*
 * readTimes()
 * 
 * Get all the time values.
 */
function readTimes()
{
	$.ajax({
		type: "POST",
		url: "../php/getTimes.php",
		data: {flight: "t01"},
		success: saveTimes,
		dataType: "text"
	});
}

function saveTimes(output)
{
	if(output[0] == "!")
	{
		document.getElementById("errorInfoDiv").innerHTML = output;
		return;
	}
	
	var times = output.split(",");
	var select = document.getElementById("timeSelect");
	
	// save the times
	for(var i = 0; i < times.length-1; i++)
		select.options[select.options.length] =
			new Option(times[i], i);

	// configure the time slider
	time = document.getElementById("timeSelect").value;
	document.getElementById("rangeCurrent").innerHTML =
		document.getElementById("timeSelect").options[time].text;
	$("#timeSlider").slider("option", "max",
		document.getElementById("timeSelect").length - 1);
	
	graphP11Log("t01");
	graphP11("t01");
	graphScat("t01");
	
	$.ajax({
		type: "POST",
		url: "../php/getCoefficientData.php",
		success: showCoefficientData,
		data: {flight: "t01", time: select.options[time].text},
		dataType: "text"
	});
	
	/*$.ajax({
		type: "POST",
		url: "../php/getLocationData.php",
		success: showLocationData,
		data: {flight: "t01", time: select.options[time].text},
		dataType: "text"
	});*/
}

function updateGraphs()
{
	var select = document.getElementById("timeSelect");
	
	graphP11Log("t01");
	graphP11("t01");
	
	moveScatTimeLine();
	
	$.ajax({
		type: "POST",
		url: "../php/getCoefficientData.php",
		success: showCoefficientData,
		data: {flight: "t01", time: select.options[time].text},
		dataType: "text"
	});
	
	/*$.ajax({
		type: "POST",
		url: "php/scripts/getLocationData.php",
		success: showLocationData,
		data: {time: select.options[time].text},
		dataType: "text"
	});*/
}

function showCoefficientData(output)
{
	var data = output.split(",");
	
	var calendar = secondsToCalendar(data[2]);
	var scat = parseFloat(data[6]).toFixed(2);
	var pres = parseFloat(data[7]).toFixed(2);
	var rh1 = parseFloat(data[8]).toFixed(2);
	var rh2 = parseFloat(data[8]).toFixed(2);
	var rh3 = parseFloat(data[8]).toFixed(2);
	var temp = parseFloat(data[11]).toFixed(2);
	
	document.getElementById("startUTC").innerHTML = data[0];
	document.getElementById("endUTC").innerHTML = data[1];
	document.getElementById("calendar").innerHTML = calendar;
	document.getElementById("scat").innerHTML = scat;
	document.getElementById("pres").innerHTML = pres;
	document.getElementById("rh1").innerHTML = rh1;
	document.getElementById("rh2").innerHTML = rh2;
	document.getElementById("rh3").innerHTML = rh3;
	document.getElementById("temp").innerHTML = temp;
}

function showLocationData(output)
{
	var data = output.split(",");
	
	var lat = data[0] + "&#176; " + data[1] + "&#39; "
		+ parseFloat(data[2]).toFixed(1) + "&#34;";
	var lon = data[3] + "&#176; " + data[4] + "&#39; "
		+ parseFloat(data[5]).toFixed(1) + "&#34;";
	
	document.getElementById("lat").innerHTML = lat;
	document.getElementById("lon").innerHTML = lon;
	document.getElementById("alt").innerHTML = data[6];
}