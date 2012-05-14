function toggleToc()
{
	$("#tocItems").toggle("blind", 50);
}

function tocItem(element)
{
	element = "#" + element;
	
	var top = $(element).offset().top - 25;
	
	$("html,body").animate({
		scrollTop: top
	});
}