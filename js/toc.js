function toggleToc()
{
	$("#toc_item_list").toggle("blind", 50);
}

function tocItem(element)
{
	element = "#" + element;
	
	var top = $(element).offset().top - 85;
	
	$("html,body").animate({
		scrollTop: top
	});
}