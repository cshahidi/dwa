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
	
<? else: ?>
	<!-- User is logged in. Show link to their profile and log out-->
	Welcome back <?=$user->first_name?>!<br>
	
<? endif; ?>