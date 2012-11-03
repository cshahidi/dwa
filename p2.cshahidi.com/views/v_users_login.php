<!-- Display any message set by profile(), if user has not logged in -->
<? if(isset($message)) echo $message; ?><br><br>

<!--  If the $destination is set, we want to append it as a query string to the url so it sends user to 
	  /users/p_login/?destination=/users/profile after login. Destination set in /users/profile.
	
       The following would result in this Query string if $destination is set:  
      "/users/p_login/?destination=/users/profile"    (stored in $_GET['destination'])

	  And no Query string if $destination is not set:  
	  "/users/p_login" (wouldn't trigger any sort of destination redirect
-->
	  

<form method= "POST" action="/users/p_login/<? if(isset($destination)) echo "?destination=".$destination; ?>">		

	<div id="login-info">	
		<h2>Log in:</h2>
	
		<p>Email</p>
		<input type="text" name="email">
		<br><br>
		
		<p>Password</p>
		<input type="password" name="password">
		<br><br>

		<!-- $error defined in login() method; not defined in index() method for landing page. Suppress it -->	
		<? if(@$error): ?>    
			<div class="error">
				Login failed. Please double check your email and password.
			</div>
			<br>
		<? endif; ?>	
		
		<input type="submit">
	</div> <!-- endiv login-info -->	
	
</form>


