/* For all the links in the #menu div, see if the href matches the current url 
  (window.location.pathname) and if it does, set the class "highlighted".
  Source: Susan (on the Forum)
*/

$(document).ready(function() {	//start doc ready
	$("#menu").find("a[href='"+window.location.pathname+"']").each(function() {
		$(this).attr('class', 'highlighted');
	});
});	





