function buildMap()
{
	var script = document.createElement("script");
	
	script.type = "text/javascript";
	script.src = "http://maps.googleapis.com/maps/api/js?";
	script.src += "key=AIzaSyDbxQ8vk0UAdJczjDvDlVnt3q6_ztpSsmc&";
	script.src += "sensor=true&callback=Map";
	
	document.body.appendChild(script);
}

function movePlaneMarker()
{
	var marker = null;
	
	//marker.setPosition(coords.getAt(time));
}

function Map()
{
	var map = null;
	var options = null;
	var styler = null;
	
	var startLat = 37.00;
	var startLong = -75.50;
	
	var flightPath = null;
	var coords = [];
	var marker = null;
	
	var setupMap = function()
	{
		var map = document.getElementById("mapCanvas");
		
		map.style.width = "100%";
		map.style.height = "100%";
	};
	
	var initializeMap = function()
	{
		styler = [{
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}]
		}];
		
		options = {
			center: new google.maps.LatLng(startLat, startLong),
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.SATELLITE,
			styles: styler
		};
		
		map = new google.maps.Map(document.getElementById("mapCanvas"),
			options);
	}
	
	function loadCoords()
	{
		$.ajax({
			type: "POST",
			url: "../php/getCoordinates.php",
			success: drawPath,
			data: {flight: flight},
			dataType: "text"
		});
	}
	
	function drawPath(output)
	{
		var unparsedCoords = output.split(",");
		var lat = 0;
		var lon = 0;
		
		flightPath = new google.maps.Polyline({
			strokeColor: "#FF0000",
			strokeOpacity: 1.0,
			strokeWeight: 2
		});
		
		coords = flightPath.getPath();
		
		for(var i = 0; i < unparsedCoords.length-1; i++)
		{
			lat = unparsedCoords[i].split("+")[0];
			lon = unparsedCoords[i].split("+")[1];
			
			coords.push(new google.maps.LatLng(lat, lon));
		}
		
		flightPath.setMap(map);
		
		setupMarker();
	}
	
	function setupMarker()
	{
		marker = new google.maps.Marker({
			position: coords.getAt(0),
			map: map,
			title: "Plane's Location",
			icon: "../style/aircraftsmall.png"
		});
	}
	
	setupMap();
	initializeMap();
	loadCoords();
}