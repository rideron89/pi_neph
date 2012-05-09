function updateRange()
{
	time = document.getElementById("timeRange").value;

	document.getElementById("rangeCurrent").innerHTML =
		document.getElementById("timeSelect").options[time].text;

	document.getElementById("timeSelect").value = time;

	updateGraphs();
}

function updateSelect()
{
	time = document.getElementById("timeSelect").value;

	document.getElementById("rangeCurrent").innerHTML =
		document.getElementById("timeSelect").options[time].text;

	document.getElementById("timeRange").value = time;

	updateGraphs();
}

/*
	* decrement()
	* 
	* Decrement the Time range's value by it's 'step'.
	*/
function decrement()
{
	var range = document.getElementById("timeRange");

	if(range.value > range.min)
		range.value = parseInt(range.value) - parseInt(range.step);

	updateRange();
}

/*
	* increment()
	* 
	* Increment the Time range's value by it's 'step'.
	*/
function increment()
{
	var range = document.getElementById("timeRange");

	if(range.value < range.max)
		range.value = parseInt(range.value) + parseInt(range.step);

	updateRange();
}