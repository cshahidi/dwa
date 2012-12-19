<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	

	<!-- SEO "meta" description -->
	<meta name="description" content="Portside Capital Holdings LLC is a private investment company that
				identifies opportunities in distressed residential real estate for acquisition. " />
	
	<!-- Global JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	
	<!-- Add the JavaScript (jQuery) that finds the current menu item and sets it to active -->
	<script src="/js/highlightmenu.js" type="text/javascript" > </script>
				
	<!-- Global CSS -->
	<link  href="/css/master.css" rel="stylesheet" type="text/css">
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?> 
	
</head>

<body>	
	<div id="wrapper">
	
		<!-- HEADER -->
		<div id="header">
			<h1>Portside Capital Holdings LLC</h1> 
		</div> 	
	
		<!-- NAVIGATION MENU -->	
		<div id= "menu">
		
			<!-- Navigation Menu for users who are logged in (either partner or principal -->
			<? if($user): ?>
				<? if($user->role=="partner"): ?>
					<ul class="mainmenu">  <!-- In case we need another menu in future -->
						<li><a href="/">Home</a></li>	
						<li><a href="/leads/add">Partners</a> <!-- will later have own landing page -->
							<ul>
								<li><a href="/leads/add">Add Lead</a></li>
							</ul>	
						</li>	
						<li><a href="/futurepage/">Investors (TBD)</a></li>
						<li><a href="/futurepage/">Team (TBD)</a></li>
						<li><a href="/futurepage/">Contact Us (TBD)</a></li>
						<li><a href='/users/logout'>Logout</a></li>		
					</ul>						
						
				<? elseif ($user->role=="principal"): ?>	
					<ul class="mainmenu"> 
						<li><a href="/">Home</a></li>						
						<li><a href="/leads/track">Principals</a>
							<ul>
								<li><a href="/leads/track">View & Track Leads</a></li>						  
							</ul>				  
						</li>			
						<li><a href="/futurepage/">Investors (TBD)</a></li>
						<li><a href="/futurepage/">Team (TBD)</a></li>
						<li><a href="/futurepage/">Contact Us (TBD)</a></li>						
						<li><a href='/users/logout'>Logout</a></li>				  
					</ul>	
				<? endif; ?>					
					
			<!-- Menu options for users who are NOT logged in -->	
			<? else: ?>
				<ul class="mainmenu"> 
					<li><a href="/">Home</a></li>	
					<li><a href="/users/login/partner">Partners</a></li> 					
					<li><a href="/users/login/principal">Principals</a></li> 					
					<li><a href="/futurepage/">Investors (TBD)</a></li>
					<li><a href="/futurepage/">Team (TBD)</a></li>
					<li><a href="/futurepage/">Contact Us (TBD)</a></li>				  	  			  
				</ul>									
			<? endif; ?>
		
		</div>  <!-- endiv menu -->
	
		<br>

		<!-- MAIN CONTENT -->
		<div id ="content">
			<?=$content;?> 
		</div>	
		
		<!-- FOOTER (div ensures that the Content will not flow out of wrapper) -->
		<div id="footer">
			Copyright &copy; 2012 PORTSIDE CAPITAL HOLDINGS LLC, Camran Shahidi			
		</div>		
		
	</div>    <!-- endiv wrapper -->
</body>
</html>