function load()
{
	var head = document.getElementsByTagName("head")[0];
	var script = null;
	
	script = document.createElement("script");
	script.src = "../js/jquery/jquery.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/jquery/jqueryui.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/utils.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/timeSlider.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/toc.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/main.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/p11Log.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/p11.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/p12.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/scat.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/alt.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/pres.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/temp.js";
	head.appendChild(script);
	
	script = document.createElement("script");
	script.src = "../js/rh.js";
	head.appendChild(script);
}
