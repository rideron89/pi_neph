function loadAll()
{
	loadCss("../style/ui/theme.css");
	loadCss("../style/general.css");
	loadCss("../style/pinnedDataBox.css");
	loadCss("../style/toc.css");
	loadCss("../style/graph.css");
	
	loadJs("../js/jquery/jquery.js");
	loadJs("../js/jquery/jqueryui.js");
	loadJs("../js/utils.js");
	loadJs("../js/timeSlider.js");
	loadJs("../js/toc.js");
	loadJs("../js/main.js");
	loadJs("../js/p11Log.js");
	loadJs("../js/p11.js");
	loadJs("../js/p12.js");
	loadJs("../js/scat.js");
	loadJs("../js/alt.js");
	loadJs("../js/pres.js");
	loadJs("../js/temp.js");
	loadJs("../js/rh.js");
}

function loadCss(fileName)
{
	var head = document.getElementsByTagName("head")[0];
	var script = document.createElement("link");
	
	script.setAttribute("rel", "stylesheet")
	script.setAttribute("type", "text/css")
	script.setAttribute("href", fileName)
	
	head.appendChild(script);
}

function loadJs(fileName)
{
	var head = document.getElementsByTagName("head")[0];
	var script = document.createElement("script");
	
	script.setAttribute("type","text/javascript");
	script.setAttribute("src", fileName);
	
	head.appendChild(script);
}