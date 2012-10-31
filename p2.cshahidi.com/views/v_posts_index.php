<? if(empty($posts)): ?>
	You need to follow someone to see a feed!<br>
	Find friends to follow <a href="/posts/users">here</a>

<? else: ?>
	<? foreach ($posts as $post): ?>

		<!-- $post is each individual row of the $posts table. Print time in readable form -->
		<h2>
			<?=$post['first_name']?> <?=$post['last_name']?> posted on 
			<?=Time::display($post['created'])?>:
		</h2>
		<?=$post['content']?>
		
		<br><br>
	<? endforeach; ?>

<? endif; ?>