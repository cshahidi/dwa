<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?>
	
</head>

<body>	
	<div id='menu'>
	
		<!-- Menu for users who are logged in -->
		<? if($user): ?>
			
			<a href='/users/profile'>Profile</a>			
			<a href='/posts/users/'>Follow or UnFollow</a>
			<a href='/posts/'>View All posts</a>
			<a href='/posts/myposts'>View My posts</a>			
			<a href='/posts/add'>Add a new post</a>
			<a href='/users/logout'>Logout</a>
		
		<!-- Menu options for users who are not logged in -->	
		<? else: ?>
			<a href='/users/signup'>Sign up</a>
		<? endif; ?>
	
	</div>
	
	<br>

	<?=$content;?> 

</body>
</html>