<!DOCTYPE html>   

<html>
<head>
	<title>Raffle Version 2</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<?
	# When debugging, we can print_r the $_POST. NOw, it's commented out because we don't need it.
	//print_r($_POST);
	
	# Initialize contestants array 
	$index ="";
	$value="";
	$contestants = ""; 
	
	# Only do the following if we have $_POST variables. i.e. if the form has been submitted
	if($_POST) {
		# Pick and print a winning number
			$num_of_contestants = count($_POST);
			$winning_number = rand(1, $num_of_contestants);		
			
	
		# Loop through contestants, seeing if any won
		# $input_name will be the name of the input field such as "contestant1" or "contestant2"
		# $value will be whatever was typed into that field (e.g. Susan)
			foreach ($_POST as $input_name => $value) {
				
				# Generate a random number
				$random_number = rand(1, $num_of_contestants);

				# See if their generated random number matches the winning number

					# First, we use this test to make sure the field was actually filled in and is not blank
					if($value != "") {
					
						if ($random_number == $winning_number) {
							# Note how we're storing our results in an array called $contestants. 
							# Again, $value was the name that was typed in (e.g. 'Susan')
							$contestants[$value] = "Winner";
						}
						else {
							$contestants[$value] = "Loser";
						}
					}	
			}  # end foreach	
	}
	?>
</head>

<body>
	<form method="POST" action="raffle_v2_Q1.php">
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
	 print_r($_POST);
	?>
	</pre>
	
	<!-- Print the results only if we have $_POST; i.e. if the form was submitted -->
	<? if(implode($_POST) != ""): ?>               <!-- alternate control structure -->
	
		The winning number is <?=$winning_number?>!<br><br>
		
		<? foreach ($contestants as $index => $value): ?>
					<?=$index?> is a <?=$value?>! <br>
		<? endforeach; ?> 
		
		<br>
	
	<? endif; ?>
</body>
</html>

	
