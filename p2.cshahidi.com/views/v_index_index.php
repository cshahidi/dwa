<!--
<pre>
Hello World!
Controller: c_index.php
Method: index()
View: v_index_index.php
</pre>
-->

<? if(!$user): ?>
	<!-- User not logged in -->
	
	<h1>Welcome Stranger!</h1><br>
	<!-- Add some introduction to application -->
	
	Please <a href='/users/login'>Login</a><br>
	or <a href='/users/signup'>Sign up</a><br>	
	
<? else: ?>
	<!-- User is logged in. Show link to their profile and log out-->
	Welcome back <?=$user->first_name?><br>
	
	<a href='/users/profile'>Profile</a><br>
	<a href='/users/logout'>Logout</a><br>	
	
<? endif; ?>