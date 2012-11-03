<? if(!$user): ?>
	<!-- User not logged in -->
	
	<h1>Welcome to BlogExpress!</h1>
	<div id="right-box">
		<?=$subview?>   <!-- Login View -->
	</div>
	
	
	<!-- Add some introduction to application -->
	<div class="left-box">
		<h2> BlogExpress is a no frills version of Twitter microblog. </h2>
		<h2> This is Class Project #2 for the class CSCIE-75, Fall 2012. </h2>
		<h3>  My two extra features are:</h3>
		<ul>  
			<li>Login Subview on this page</li>
			<li>View My Posts page</li>
		</ul>	
	</div>	
			
	
	
<? else: ?>
	<!-- User is logged in -->
	<h1>Welcome back <?=$user->first_name?>! </h1>
	
	<div class="left-box">
		<h2>You can use BlogExpress to:</h2>
		<ul>
			<li>Sign up for a new account</li>
			<li>Log in</li>
			<li>View your profile</li>
			<li>Add posts</li>
			<li>Follow and Unfollow other users</li>
			<li>View your own post stream</li>
			<li>View the poststreams of Followed users</li>
			<li>Log out</li>
		</ul>	
		<p> Please select a menu pick to proceed!</p>
		<br>
	</div>   <!-- endiv left-box -->
	
<? endif; ?>