/* For all the links in the #menu div, see if the href matches the current url 
  (window.location.pathname) and if it does, add the class "active".
  Source: Susan (on the Forum)
*/
$("#menu ul li").find("a[href='"+window.location.pathname+"']").each(function() {
	 $(this).attr('class', 'active');
});





