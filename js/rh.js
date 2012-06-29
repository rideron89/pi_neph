function graphRH(flight, minTime, rh1Color, rh2Color, rh3Color)
{
	var url = "/" + window.location.pathname.split('/')[1] + "/php/getRHData.php";
	
	var post = $.post(url,
		{flight: flight});
	
	post.minTime = minTime
	post.rh1Color = rh1Color;
	post.rh2Color = rh2Color;
	post.rh3Color = rh3Color;
	
	post.done(RHGraph);
}

function moveRHTimeLine(minTime)
{
	var x;
	var timeLine = document.getElementById("rhTimeLine");
	var times = document.getElementById("timeSelect");
	var width = 640;
	var padding = 64;
	var maxTime = minTime + 9;

	x = width - (padding * 2);
	x = x / ((maxTime - minTime + 1) * 1000) *
		(times.options[time].text - (minTime * 1000));
	x = x + padding;

	timeLine.style.left = x + "px";
}

function RHGraph(output, statusText, jqxhr)
{
	var width = 640;
	var height = 360;
	var padding = 64;
	var secondaryColor = "black";
	var rh1Color = jqxhr.rh1Color;
	var rh2Color = jqxhr.rh2Color;
	var rh3Color = jqxhr.rh3Color;
	var alphaHigh = 1.0;
	var alphaLow = 0.2;
	var largestY = 80;
	var minTime = jqxhr.minTime;
	var maxTime = minTime + 9;
	
	var data = output.split("+");
	var rh1Data = data[0].split(",");
	var rh2Data = data[1].split(",");
	var rh3Data = data[2].split(",");
	var graph = document.getElementById("rhGraph");
	var rh1DataPoints = document.getElementById("rh1DataPoints");
	var rh2DataPoints = document.getElementById("rh2DataPoints");
	var rh3DataPoints = document.getElementById("rh3DataPoints");
	var timeLine = document.getElementById("rhTimeLine");
	var legend = document.getElementById("rhLegend");
	var context = null;
	
	data = ""; // maybe clear up some memory?
	
	var setupGraph = function()
	{
		graph.width = width;
		graph.height = height;
		
		rh1DataPoints.width = width;
		rh1DataPoints.height = height;
		
		rh2DataPoints.width = width;
		rh2DataPoints.height = height;
		
		rh3DataPoints.width = width;
		rh3DataPoints.height = height;
		
		timeLine.width = 2;
		timeLine.height = height - (padding * 2);
		timeLine.style.top = padding + "px";
		
		timeLine.getContext("2d").globalAlpha = 0.6;
		timeLine.getContext("2d").fillStyle = "red";
		timeLine.getContext("2d").fillRect(0, 0, timeLine.width,
			timeLine.height);
		
		legend.width = 210;
		legend.height = 52;
	};
	
	var clearGraph = function()
	{
		context = graph.getContext("2d");
		context.clearRect(0, 0, context.width, context.height);
		
		context = rh1DataPoints.getContext("2d");
		context.clearRect(0, 0, context.width,
			context.height);
		
		context = rh2DataPoints.getContext("2d");
		context.clearRect(0, 0, context.width,
			context.height);
		
		context = rh3DataPoints.getContext("2d");
		context.clearRect(0, 0, context.width,
			context.height);
		
		timeLine.style.left = padding + "px";
		
		context = legend.getContext("2d");
		context.clearRect(0, 0, legend.width, legend.height);
	};
	
	var drawBorder = function()
	{
		context = graph.getContext("2d");
		
		context.strokeStyle = secondaryColor;
		context.fillStyle = secondaryColor;
		context.lineWidth = 2;
	
		context.moveTo(padding, padding);
		context.lineTo(padding, (height-padding));
	
		context.moveTo(padding, (height-padding));
		context.lineTo((width-padding), (height-padding));
	
		context.fill();
		context.stroke();
	};
	
	var drawLegend = function()
	{
		context = legend.getContext("2d");
		
		context.globalAlpha = 0.7;
		context.fillStyle = "white";
		context.font = "bold 11pt sans-serif";
		
		context.fillRect(0, 0, legend.width, legend.height);
		
		context.globalAlpha = alphaHigh;
		
		context.beginPath();
		context.strokeStyle = rh1Color;
		context.fillStyle = rh1Color;
		context.moveTo(10, 12);
		context.arc(10, 12, 2, 0, (2*Math.PI), false);
		
		context.fill();
		context.stroke();
		
		context.beginPath();
		context.strokeStyle = rh2Color;
		context.fillStyle = rh2Color;
		context.moveTo(10, 27);
		context.arc(10, 27, 2, 0, (2*Math.PI), false);
		
		context.fill();
		context.stroke();
		
		context.beginPath();
		context.strokeStyle = rh3Color;
		context.fillStyle = rh3Color;
		context.moveTo(10, 42);
		context.arc(10, 42, 2, 0, (2*Math.PI), false);
		
		context.fill();
		context.stroke();
		
		context.fillStyle = "black";
		
		context.fillText("RH1, before PI-Neph inlet", 20, 15);
		context.fillText("RH2, inside PI-Neph inlet", 20, 30);
		context.fillText("RH3, after PI-Neph inlet", 20, 45);
		
		context.fill();
		context.stroke();
	};
	
	var updateTitle = function()
	{
		var title = document.getElementById("rhCanvasTitle");
		var xAxis = document.getElementById("rhXAxisTitle");
		var yAxis = document.getElementById("rhYAxisTitle");

		title.innerHTML = "Relative Humidity";
		xAxis.innerHTML = "Time From Previous Midnight UTC [sec]";
		yAxis.innerHTML = "Relative Humidity [%]";
	};
	
	var drawAxes = function()
	{
		var x, y, text;
		
		context = graph.getContext("2d");
		
		context.fillStyle = secondaryColor;
		context.strokeStyle = secondaryColor;
		context.font = "bold 11pt sans-serif";
		context.lineWidth = 1;
		
		for(var i = 0; i < 11; i++)
		{
			x = width - (padding * 2);
			x = x / 10 * i;
			x = x + padding;
			
			text = parseInt(minTime + (1 * i)) + "k";
			
			context.globalAlpha = alphaHigh;
			context.fillText(text, (x - context.measureText(text).width / 2),
				(height - padding + 20));
			
			context.globalAlpha = 0.6;
			text = secondsToCalendarHHMM(parseInt(minTime + (1 * i)) * 1000);
			context.fillText(text, (x - context.measureText(text).width / 2),
				(height-  padding + 35));
		
			context.globalAlpha = alphaLow;
			context.moveTo(x, (height - padding + 5));
			context.lineTo(x, padding);
		}
		
		for(i = 0; i < (largestY / 10 + 1); i++)
		{
			y = height - (padding * 2);
			y = y / (largestY / 10) * i;
			y = y + padding;
			
			text = largestY - (10 * i);
			
			context.globalAlpha = alphaHigh;
			context.fillText(text,
				(padding - context.measureText(text).width - 10), (y + 4));
			
			context.globalAlpha = alphaLow;
			context.moveTo((padding - 5), y);
			context.lineTo((width - padding), y);
		}
		
		context.fill();
		context.stroke();
	};
	
	var setTimeLine = function()
	{
		var x;
		var times = document.getElementById("timeSelect");
		
		x = width - (padding * 2);
		x = x / ((maxTime - minTime + 1) * 1000) *
			(times.options[0].text - (minTime * 1000));
		x = x + padding;
		
		timeLine.style.left = x + "px";
	};
	
	var plotPoints = function()
	{
		var x, y, temp;
		var times = document.getElementById("timeSelect");
		
		context = rh1DataPoints.getContext("2d");
		context.strokeStyle = rh1Color;
		context.fillStyle = rh1Color;
		context.lineWidth = 1;
		
		for(var i = 0; i < rh1Data.length-1; i++)
		{
			x = width - (padding * 2);
			x = x / ((maxTime - minTime + 1) * 1000) *
				(times.options[i].text - (minTime * 1000));
			x = x + padding;
		
			y = height - (padding * 2);
			
			temp = height - (padding * 2);
			temp = temp / largestY * (rh1Data[i]);
			
			y = y - temp;
			y = y + padding;
		
			context.moveTo(x, y);
			context.arc(x, y, 1.5, 0, (2*Math.PI), false);
		}
		
		context.fill();
		context.stroke();
		
		context = rh2DataPoints.getContext("2d");
		context.strokeStyle = rh2Color;
		context.fillStyle = rh2Color;
		context.lineWidth = 1;
		
		for(i = 0; i < rh2Data.length-1; i++)
		{
			x = width - (padding * 2);
			x = x / ((maxTime - minTime + 1) * 1000) *
				(times.options[i].text - (minTime * 1000));
			x = x + padding;
		
			y = height - (padding * 2);
			
			temp = height - (padding * 2);
			temp = temp / largestY * (rh2Data[i]);
			
			y = y - temp;
			y = y + padding;
		
			context.moveTo(x, y);
			context.arc(x, y, 1.5, 0, (2*Math.PI), false);
		}
		
		context.fill();
		context.stroke();
		
		context = rh3DataPoints.getContext("2d");
		context.strokeStyle = rh3Color;
		context.fillStyle = rh3Color;
		context.lineWidth = 1;
		
		for(i = 0; i < rh3Data.length-1; i++)
		{
			x = width - (padding * 2);
			x = x / ((maxTime - minTime + 1) * 1000) *
				(times.options[i].text - (minTime * 1000));
			x = x + padding;
		
			y = height - (padding * 2);
			
			temp = height - (padding * 2);
			temp = temp / largestY * (rh3Data[i]);
			
			y = y - temp;
			y = y + padding;
		
			context.moveTo(x, y);
			context.arc(x, y, 1.5, 0, (2*Math.PI), false);
		}
		
		context.fill();
		context.stroke();
	};
	
	setupGraph();
	clearGraph();
	drawBorder();
	drawLegend();
	updateTitle();
	drawAxes();
	setTimeLine();
	plotPoints();
}