<h1><?=$h1?></h1>
<? if(empty($posts)): ?>


	<? if ((@$must_follow_yourself)): ?>  
		<!-- This if statement is only run if user is trying to View their own posts but is not 
			following themselves. Variable defined only in myposts(), not index() which also loads this view, 
			so suppress. -->	
	
		<div class = "msg">
			You need to follow yourself first!<br><br>
			
			<!-- Print this user's name -->
			<?=$user->first_name?> <?=$user->last_name?>
			
			<!-- There is no connection for the user to themselves, show the follow link -->
			<a href='/posts/follow/<?=$user->user_id?>'>Follow</a>
		</div>	

		
	<? else: ?>	
			<!-- View list of all users to follow --> 
			<div class="msg">
				You need to follow someone to see a feed!<br><br>
				Find friends to follow <a href="/posts/users">here</a>	
			</div>	
	<? endif; ?>

	
<? else: ?>
	<!-- Great! There are posts to be followed -->

	<? foreach ($posts as $post): ?>

		<!-- $post is each individual row of the $posts table. Print time in readable form -->
		<div id="post">  <!-- Validation error on duplicate id, but class="post" css doesn't work -->
		  <h2>
			 <?=$post['first_name']?> <?=$post['last_name']?> posted on 
			 <?=Time::display($post['created'])?>:	
		  </h2><br>
		  <p>
			<?=$post['content']?>
		  </p>
		</div>
		
		<br><br>
	<? endforeach; ?>


<? endif; ?>