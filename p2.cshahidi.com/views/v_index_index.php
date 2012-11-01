<? if(!$user): ?>
	<!-- User not logged in -->
	
	<h1>Welcome Stranger!</h1>
	<div class="subview">
		<?=$subview?>
	</div>
	<!-- Add some introduction to application -->
	
<? else: ?>
	<!-- User is logged in -->
	<div class = "welcome">
		Welcome back <?=$user->first_name?>!
	</div>	
	<br>
	
<? endif; ?>