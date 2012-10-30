<!-- Display any message set by profile(), if user has not logged in -->
<? if(isset($message)) echo $message; ?><br><br>

<!--  If the $destination is set, we want to append it as a query string to the url so it sends user to 
	  /users/p_login/?destination=/users/profile after login. Destination set in in /users/profile.
	
       The following would result in this Query string if $destination is set:  
      "/users/p_login/?destination=/users/profile"    (stored in $_GET['destination'])

	  And no Query string if $destination is not set:  
	  "/users/p_login" (wouldn't trigger any sort of destination redirect
-->
	  
<form method= "POST" action="/users/p_login/<? if(isset($destination)) echo "?destination=".$destination; ?>">		
		
	Email<br>
	<input type="text" name="email">
	<br><br>
	
	Password<br>
	<input type="password" name="password">
	<br><br>
	
	<input type="submit">
	
</form>