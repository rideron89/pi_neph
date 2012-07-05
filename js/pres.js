function graphPres(flight, minTime, maxTime, color)
{
	var url = "/" + window.location.pathname.split('/')[1] + "/php/getScatData.php";
	
	var post = $.post(url,
		{flight: flight, request: "pressure"});
	
	post.minTime = minTime;
	post.maxTime = maxTime;
	post.color = color;
	
	post.done(PresGraph);
}

function movePresTimeLine(minTime, maxTime)
{
	var x;
	var timeLine = document.getElementById("presTimeLine");
	var times = document.getElementById("timeSelect");
	var width = 640;
	var padding = 64;

	x = width - (padding * 2);
	x = x / ((maxTime - minTime) * 1000) *
		(times.options[time].text - (minTime * 1000));
	x = x + padding;

	timeLine.style.left = x + "px";
}

function PresGraph(output, statusText, jqxhr)
{
	var width = 640;
	var height = 360;
	var padding = 64;
	var primaryColor = jqxhr.color;
	var secondaryColor = "black";
	var alphaHigh = 1.0;
	var alphaLow = 0.2;
	var largestY = 120;
	var minTime = jqxhr.minTime;
	var maxTime = jqxhr.maxTime;

	var data = output.split(",");
	var graph = document.getElementById("presGraph");
	var dataPoints = document.getElementById("presDataPoints");
	var timeLine = document.getElementById("presTimeLine");
	var context = null;
	
	var setupGraph = function()
	{
		graph.width = width;
		graph.height = height;
		
		dataPoints.width = width;
		dataPoints.height = height;
		
		timeLine.width = 2;
		timeLine.height = height - (padding * 2);
		timeLine.style.top = padding + "px";
		
		timeLine.getContext("2d").globalAlpha = 0.5;
		timeLine.getContext("2d").fillStyle = "red";
		timeLine.getContext("2d").fillRect(0, 0, timeLine.width,
			timeLine.height);
	};
	
	var clearGraph = function()
	{
		context = graph.getContext("2d");
		context.clearRect(0, 0, context.width, context.height);
		
		context = dataPoints.getContext("2d");
		context.clearRect(0, 0, context.width, context.height);
		
		timeLine.style.left = padding + "px";
	};
	
	var drawBorder = function()
	{
		context = graph.getContext("2d");
	
		context.strokeStyle = secondaryColor;
		context.fillStyle = secondaryColor;
		context.lineWidth = 2;
	
		context.moveTo(padding, padding);
		context.lineTo(padding, (height - padding));
	
		context.moveTo(padding, (height - padding));
		context.lineTo((width - padding), (height - padding));
	
		context.fill();
		context.stroke();
	};
	
	var updateTitle = function()
	{
		var title = document.getElementById("presCanvasTitle");
		var xAxis = document.getElementById("presXAxisTitle");
		var yAxis = document.getElementById("presYAxisTitle");

		title.innerHTML = "Pressure Inside the PI-Neph Measurement Chamber ";
		xAxis.innerHTML = "Time From Previous Midnight UTC [sec]";
		yAxis.innerHTML = "Pressure Measured [Pa]";
	};
	
	var drawAxes = function()
	{
		var x, y, text;
		
		context = graph.getContext("2d");
		
		context.fillStyle = secondaryColor;
		context.strokeStyle = secondaryColor;
		context.font = "bold 11pt sans-serif";
		context.lineWidth = 1;
		
		for(var i = 0; i < (maxTime - minTime + 1); i++)
		{
			x = width - (padding * 2);
			x = x / (maxTime - minTime) * i;
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
		
		for(i = 0; i < 7; i++)
		{
			y = height - (padding * 2);
			y = y / 6 * i;
			y = y + padding;
			
			text = largestY - (20 * i);
			if(text >= 1)
				text += "k";
			
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
		x = x / ((maxTime - minTime) * 1000) *
			(times.options[0].text - (minTime * 1000));
		x = x + padding;
		
		timeLine.style.left = x + "px";
	};
	
	var plotPoints = function()
	{
		var x, y, temp;
		var times = document.getElementById("timeSelect");
		
		context = dataPoints.getContext("2d");
		
		context.strokeStyle = primaryColor;
		context.fillStyle = primaryColor;
		context.lineWidth = 1;
		
		for(var i = 0; i < data.length-1; i++)
		{
			x = width - (padding * 2);
			x = x / ((maxTime - minTime) * 1000) *
				(times.options[i].text - (minTime * 1000));
			x = x + padding;
		
			y = height - (padding * 2);
			
			temp = height - (padding * 2);
			temp = temp / largestY * (data[i] / 1000);
			
			y = y - temp;
			y = y + padding;
		
			context.moveTo(x, y);
			context.arc(x, y, 1.5, 0, (2*Math.PI), false);
		}
		
		context.fill();
		context.stroke();
	};
	
	if(data[0][0] === "!")
	{
		errorMessage(data[0].substr(1));
	}
	else if(data[0][0] === "@")
	{
		warningMessage(data[0].substr(1));
	}
	else
	{
		setupGraph();
		clearGraph();
		drawBorder();
		updateTitle();
		drawAxes();
		setTimeLine();
		plotPoints();
		
		if(!$("#presCanvasDiv").is(":visible"))
			$("#presCanvasDiv").show("blind", 500);
	}
}