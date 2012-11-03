<h1>Pick Users to Follow/Unfollow</h1>

<form method='POST' action='/posts/p_follow'>

	<? foreach($users as $user): ?>
		<div id="users">  
			<!-- Print this user's name -->
			<h3>
			    <?=$user['first_name']?> <?=$user['last_name']?>
			<h3>
			
			<!-- If there exists a connection with this user, show a unfollow link -->
			<? if(isset($connections[$user['user_id']])): ?>
				<a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>
			
			<!-- Otherwise, show the follow link -->
			<? else: ?>
				<a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
			<? endif; ?>
		</div>
	
		<br>
	
	<? endforeach; ?>
	
</form>