function testOutput(output)
{
	if(output[0] == "!")
	{
		errorMessage(mysqlError(output.substr(1)));
		return -2;
	}
	else if(output[0] == "@")
	{
		warningMessage(output.substr(1));
		return -1;
	}
	
	return 1;
}

function secondsToCalendar(seconds)
{
	var string = "";
	var hh, mm, ss;
	
	hh = parseInt(seconds/60/60, 10) % 24;
	mm = parseInt(seconds/60, 10) % 60;
	ss = seconds % 60;
	
	if(hh < 10)
		hh = "0" + hh;
	
	if(mm < 10)
		mm = "0" + mm;
	
	if(ss < 10)
		ss = "0" + ss;
	
	string = hh + ":" + mm + ":" + ss;
	
	return string;
}

function secondsToCalendarHHMM(seconds)
{
	var string = secondsToCalendar(seconds);
	
	string = string.substr(0, 5);
	
	return string;
}

function errorMessage(message)
{
	document.getElementById("errorInfoDiv").innerHTML += message + "<br />";
}

function warningMessage(message)
{
	document.getElementById("warningInfoDiv").innerHTML += message + "<br />";
}

function mysqlError(message)
{
	if(message.indexOf("[1044]") != -1)
		message = "User access denied to database.";
	else if(message.indexOf("[1045]") != -1)
		message = "Access denied to database.";
	else if(message.indexOf("[1054]") != -1)
		message = "Attempted to read from unknown column.";
	
	return message;
}
