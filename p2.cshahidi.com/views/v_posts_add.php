<form method="POST" action="/posts/p_add">

	<? if($add_another_post): ?>
		<div class="msg">
			Your post has been added. Add another?
		</div>
		<br>
	<? endif; ?>	

	<h1>New Post:</h1>
	<textarea name="content" cols="50" rows="5"></textarea> <br><br>	

	<input type="submit">
</form>

