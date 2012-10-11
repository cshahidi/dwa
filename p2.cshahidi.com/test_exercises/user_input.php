<!DOCTYPE html>   

<html>
<head>
	<title>User Input</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

</head>

<body>
	<form method="POST" action="user_input.php">
		Enter 5 contestants <br>
		<input type="text" name="contestant1"><br>
		<input type="text" name="contestant2"><br>
		<input type="text" name="contestant3"><br>
		<input type="text" name="contestant4"><br>
		<input type="text" name="contestant5"><br>
		<input type="submit" value="Pick a winner!"><br>
	</form>
	
	<pre>
	<?
	 print_r($_POST)
	?>
	</pre>
		
</body>
</html>

	
