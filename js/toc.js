function toggle_graph_toc()
{
	$("#graph_toc_item_list").toggle("blind", 50);
}

function graph_toc_item(element)
{
	element = "#" + element;
	
	var top = $(element).offset().top - 85;
	
	$("html,body").animate({
		scrollTop: top
	});
}