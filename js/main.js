var time = 0;

/*
 * Initialize all jQuery widgets (sliders, buttons, etc...)
 */
$(document).ready(function()
{
	$("#toc_item_list").hide();
	$("#loadingIconDiv").slideDown(400);
	
	$("#timeSlider").slider({
		stop: updateDisplayTime,
		slide: updateDisplayTime,
		change: updateSlider
	});
	
	$("input:button").button();
	$("#minusButton").click(decrement);
	$("#plusButton").click(increment);
	
	readTimes(flight);
});

/*
 * Hide the 'Loading Data' icon/message.
 */
$(document).ajaxStop(function()
{
	$("#loadingIconDiv").slideUp(400);
});

/*
 * readTimes()
 * 
 * Get all the time values.
 */
function readTimes(flight)
{
	$.ajax({
		type: "POST",
		url: "../php/getTimes.php",
		data: {flight: flight},
		success: saveTimes,
		dataType: "text"
	});
}

function saveTimes(output)
{
	var test = testOutput(output);
	var times = null;
	var select = document.getElementById("timeSelect");
	
	if(test === -2) {
		return;
	}
	else if(test === -1) {
		times = output.split(",");
		times.splice(0, 1);
	}
	else {
		times = output.split(",");
	}
	
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
	
	graphP11Log(flight, "red");
	graphP11(flight, "red");
	graphP12(flight, "green");
	graphScat(flight, minTime, "blue");
	buildMap();
	graphAlt(flight, minTime, "purple");
	graphPres(flight, minTime, "orange");
	graphTemp(flight, minTime, "yellow");
	graphRH(flight, minTime, "green", "orange", "purple");
	
	drawGraphs();
	
	$.ajax({
		type: "POST",
		url: "../php/getCoefficientData.php",
		success: showCoefficientData,
		data: {flight: flight, time: select.options[time].text},
		dataType: "text"
	});
	
	$.ajax({
		type: "POST",
		url: "../php/getLocationData.php",
		success: showLocationData,
		data: {flight: flight, time: select.options[time].text},
		dataType: "text"
	});
}

function drawGraphs()
{
	$.fx.speeds._default = 125;
	
	// draw the graphs
	if(!$("#p11LogCanvasDiv").is(":visible"))
		$("#p11LogCanvasDiv").show("blind", function()
	{
		if(!$("#p11CanvasDiv").is(":visible"))
			$("#p11CanvasDiv").show("blind", function()
		{
			if(!$("#p12CanvasDiv").is(":visible"))
				$("#p12CanvasDiv").show("blind", function()
			{
				if(!$("#scatCanvasDiv").is(":visible"))
					$("#scatCanvasDiv").show("blind", function()
				{
					if($("#mapCanvasDiv").css("visibility") === "hidden")
					{
						$("#mapCanvasDiv").css({visibility: "visible"});
						
						if(!$("#altCanvasDiv").is(":visible"))
							$("#altCanvasDiv").show("blind", function()
						{
							if(!$("#presCanvasDiv").is(":visible"))
								$("#presCanvasDiv").show("blind", function()
							{
								if(!$("#tempCanvasDiv").is(":visible"))
									$("#tempCanvasDiv").show("blind", function()
								{
									if(!$("#rhCanvasDiv").is(":visible"))
										$("#rhCanvasDiv").show("blind");
								});
							});
						});
					}
				});
			});
		});
	});
}

function updateGraphs(flight)
{
	var select = document.getElementById("timeSelect");
	
	graphP11Log(flight, "red");
	graphP11(flight, "red");
	graphP12(flight, "green");
	
	$.ajax({
		type: "POST",
		url: "../php/getCoefficientData.php",
		success: showCoefficientData,
		data: {flight: flight, time: select.options[time].text},
		dataType: "text"
	});
	
	$.ajax({
		type: "POST",
		url: "../php/getLocationData.php",
		success: showLocationData,
		data: {flight: flight, time: select.options[time].text},
		dataType: "text"
	});
}

function moveTimeLines()
{
	moveScatTimeLine(minTime);
	moveAltTimeLine(minTime);
	movePresTimeLine(minTime);
	moveTempTimeLine(minTime);
	moveRHTimeLine(minTime);
}

function showCoefficientData(output)
{
	if(testOutput(output) < 0)
		return;
	
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
	if(testOutput(output) < 0)
		return;
	
	var data = output.split(",");
	
	var lat = data[0] + "&#176; " + data[1] + "&#39; "
		+ parseFloat(data[2]).toFixed(1) + "&#34;";
	var lon = data[3] + "&#176; " + data[4] + "&#39; "
		+ parseFloat(data[5]).toFixed(1) + "&#34;";
	
	document.getElementById("lat").innerHTML = lat;
	document.getElementById("lon").innerHTML = lon;
	document.getElementById("alt").innerHTML = data[6];
}
