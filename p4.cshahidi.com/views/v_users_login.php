<!-- Display any message set by profile(), if user has not logged in -->
<h3><? if(isset($message)) echo $message; ?></h3><br><br>

<!--  If the $destination is set, we want to append it as a query string to the url so it sends user to 
	  /users/p_login/?destination=/users/profile after login. Destination set in /users/profile.
	
       The following would result in this Query string if $destination is set:  
      "/users/p_login/?destination=/users/profile"    (stored in $_GET['destination'])

	  And no Query string if $destination is not set:  
	  "/users/p_login" (wouldn't trigger any sort of destination redirect
-->
	  
<div class="login-box">
	<form id="form_ID" class="formular" method="POST" action="/users/p_login/<? if(isset($destination)) echo "?destination=".$destination; ?>">		

		<div class="login-info">	
			<h2>Log in:</h2>
		
			<p>Email</p>       <!-- validation based on new jQuery Validation plugin -->
			<input type="text" name="email" class="validate[required,custom[email]] text_input" id="email">
			<br><br>
			
			<p>Password</p>
			<input type="password" name="password" class="validate[required] text_input" id="password">
			<br><br>

			<!-- $error defined in login() method; not defined in index() method for landing page. Suppress it -->	
			<? if(@$error): ?>    
				<div class="error">
					Login failed. Please double check your email and password.
				</div>
				<br>
			<? endif; ?>	
			
			<input type="submit" value="Log In">
		</div> <!-- endiv login-info -->	
		
	</form>
</div>


<!-- Use new jQuery validation Plugin script -->
<script type='text/javascript'>

	// binds form submission and fields to the validation engine
	$("#formID").validationEngine('attach');

</script>	
