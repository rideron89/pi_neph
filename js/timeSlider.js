function updateSlider()
{
	document.getElementById("timeSelect").value = time;

	updateGraphs();
}

function updateSelect()
{
	$("#timeSlider").slider("value",
		document.getElementById("timeSelect").value);
	
	updateDisplayTime();
	
	document.getElementById("timeSelect").value = time;

	updateGraphs();
}

function updateDisplayTime()
{
	time = $("#timeSlider").slider("value");
	
	document.getElementById("rangeCurrent").innerHTML =
		document.getElementById("timeSelect").options[time].text;
	
	moveTimeLines();
}

/*
	* decrement()
	* 
	* Decrement the Time range's value by it's 'step'.
	*/
function decrement()
{
	var currentValue = $("#timeSlider").slider("value");
	var minValue = $("#timeSlider").slider("option", "min");
	var step = $("#timeSlider").slider("option", "step");
	
	if(currentValue > minValue)
		$("#timeSlider").slider("value", currentValue-step);

	updateDisplayTime();
	updateSlider();
}


/*
	* increment()
	* 
	* Increment the Time range's value by it's 'step'.
	*/
function increment()
{
	var currentValue = $("#timeSlider").slider("value");
	var maxValue = $("#timeSlider").slider("option", "max");
	var step = $("#timeSlider").slider("option", "step");
	
	if(currentValue < maxValue)
		$("#timeSlider").slider("value", currentValue+step);

	updateDisplayTime();
	updateSlider();
}
