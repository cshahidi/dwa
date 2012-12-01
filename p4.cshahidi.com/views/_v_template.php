<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- Global JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	
	<!-- Add the JavaScript (jQuery) that finds the current menu item and sets it to active -->
	<!-- DOESN'T WORK -->
	<script src="/js/highlightmenu.js" type="text/javascript" > </script>
				
	<!-- Global CSS -->
	<link  href="/css/master.css" rel="stylesheet" type="text/css">
				
	<!-- Controller Specific JS/CSS -->
	<!-- <?php echo @$client_files; ?> -->
	
</head>

<body>	
	<div id="wrapper">
		<div id= "menu">
		
			<!-- Navigation Menu for users who are logged in -->
			<? if($user): ?>
				<ul id="mainmenu">  <!-- In case we need another menu in future -->
				  <li><a href="/">Home</a></li>	
				  <li><a href="/users/profile">Profile</a></li>	
				  <li><a href='/posts/users/'>Follow or UnFollow</a></li>
				  <li><a href='/posts/'>View All Posts</a></li>
				  <li><a href='/posts/myposts'>View My Posts</a></li>
				  <li><a href='/posts/add'>Add Post</a></li>
				  <li><a href='/users/logout'>Logout</a></li>					
				</ul>				

					
			<!-- Menu options for users who are not logged in -->	
			<? else: ?>
				<ul id="mainmenu">  <!-- In case we need another menu in future -->
				  <li><a href='/users/signup'>Sign up</a></li>	
				</ul>			
			<? endif; ?>
		
		</div>  <!-- endiv menu -->
	
		<br>

		<div id ="content">
			<?=$content;?> 
		</div>	
		
		<!-- Footer div ensures that the Content will not flow out of wrapper -->
		<div id="footer">
			Copyright &copy; 2012 CS
		</div>		
		

	</div>    <!-- endiv wrapper -->
</body>
</html>