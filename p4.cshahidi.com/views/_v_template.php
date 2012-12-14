<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- Global JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	
	<!-- Add the JavaScript (jQuery) that finds the current menu item and sets it to active -->
	<script src="/js/highlightmenu.js" type="text/javascript" > </script>
				
	<!-- Global CSS -->
	<link  href="/css/master.css" rel="stylesheet" type="text/css">
				
	<!-- Controller Specific JS/CSS -->

	<!-- <?php echo @$client_files; ?> -->
	
</head>

<body>	
	<div id="wrapper">
		<div id= "menu">
		
			<!-- Navigation Menu for users who are logged in (either parnter or principal -->
			<? if($user): ?>
				<? if($user->role=="partner"): ?>
					<ul class="mainmenu">  <!-- In case we need another menu in future -->
						<li><a href="/">Home</a></li>	
						<li><a href="/leads/add">Partners</a> <!-- will later have own landing page -->
							<ul>
								<li><a href="leads/add">Add Lead</a></li>
							</ul>	
						</li>	
						<li><a href="/future_page/">Investors (TBD)</a></li>
						<li><a href="/future_page/">Team (TBD)</a></li>
						<li><a href="/future_page/">Contact Us (TBD)</a></li>
						<li><a href='/users/logout'>Logout</a></li>		
					</ul>						
						
				<? elseif ($user->role=="principal"): ?>	
					<ul class="mainmenu"> 				
						<li><a href="/leads/track">Principals</a>
							<ul>
								<li><a href="/leads/track">View & Track Leads</a></li>
								<li><a href="/calculator">Offer Price Calculator</a></li>						  
							</ul>				  
						</li>			
						<li><a href="/future_page/">Investors (TBD)</a></li>
						<li><a href="/future_page/">Team (TBD)</a></li>
						<li><a href="/future_page/">Contact Us (TBD)</a></li>						
						<li><a href='/users/logout'>Logout</a></li>				  
					</ul>	
									
					
			<!-- Menu options for users who are NOT logged in -->	
			<? else: ?>
				<ul class="mainmenu"> 
					<li><a href="/">Home</a></li>	
					<li><a href="/users/signup/partner">Partners</a></li> 	  
					<li><a href="/users/signup/principal">Principals</a></li>
					<li><a href="/future_page/">Investors (TBD)</a></li>
					<li><a href="/future_page/">Team (TBD)</a></li>
					<li><a href="/future_page/">Contact Us (TBD)</a></li>				  	  			  
				</ul>						
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