var url = "";
var load = false;

function load_more_refresh () {
	if (url === undefined) {
		$("#load_more").html ("Il n'y a plus rien à charger");
		$("#load_more").addClass ("disable");
	} else {
		$("#load_more").html ("Charger plus d'archives");
	}
}

function load_more_posts () {
	load = true;
	$.get (url, function (data) {
		$("#pagination").before ($("#archives li.disable", data));
		
		url = $("#pagination a.pager-next", data).attr ("href");
		
		load_more_refresh ();
		load = false;
	});
}

$(document).ready (function () {
	url = $("#pagination a.pager-next").attr ("href");
	$("#pagination a").remove ();
	
	$("#pagination").append ("<a id=\"load_more\" href=\"#\"></a>");
	load_more_refresh ();
	
	$("#load_more").click (function () {
		load_more_posts ();
		
		return false;
	});
});
