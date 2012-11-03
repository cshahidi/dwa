<h1>Pick Users to Follow/Unfollow</h1>

<form method='POST' action='/posts/p_follow'>

	<? foreach($users as $user): ?>
		<div id="users">      <!-- Validation error on duplicate id; but class="users" css doesn't work-->
			<!-- Print this user's name -->
			<h3><?=$user['first_name']?> <?=$user['last_name']?></h3>
			
			<!-- If there exists a connection with this user, show a unfollow link -->
			
				<? if(isset($connections[$user['user_id']])): ?>
					<a class="follow-link" href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>
				<!-- Otherwise, show the follow link -->
				<? else: ?>
					<a class="follow-link" href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
				<? endif; ?>
				
		</div>
		<br>
	
	<? endforeach; ?>
	
</form>