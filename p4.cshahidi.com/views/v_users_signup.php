<h2>Please Sign up for New Account</h2>

<form method="POST" action="/users/p_signup">

	<div class="login-info">
		<p>First Name</p>
		<input type="text" name="first_name">
		<br>
		
		<p>Last Name</p>
		<input type="text" name="last_name">
		<br>
		
		<p>Email</p>
		<input type="text" name="email">
		<br>
		
		<p>Password</p>
		<input type="password" name="password">
		<br><br>
		
		<!-- Insert in $_POST the $role variable ("partner" vs "principal") signup() has set -->
		<input type="hidden" name="role" value="$role")
		
		
		<input type="submit" value="Sign Up">
	</div>	
</form>
		