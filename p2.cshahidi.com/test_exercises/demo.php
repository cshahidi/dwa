<!DOCTYPE html>

<html>
<head>

<title></title>

<?php

if($_GET){


$winning_number = rand(1,5);

foreach($_GET as $contestant => $name){

$ids[$name]= $i++;

if ($winning_number==$i){
$contestants[$name]="Winner";

} else{

$contestants[$name]="Loser";
}


};

}
?>
</head>

<body>

<form action="demo.php" method="get">
<input type="text" name="contestant1" value="<?=$_GET['contestant1']?>"><br>
<input type="text" name="contestant2" value="<?=$_GET[contestant2]?>"><br>
<input type="text" name="contestant3" value="<?=$_GET[contestant3]?>"><br>
<input type="text" name="contestant4" value="<?=$_GET[contestant4]?>"><br>
<input type="text" name="contestant5" value="<?=$_GET[contestant5]?>"><br>
<input type="submit" value="Pick a winner!">
</form>
<br>
AND the winning number is...<H1><?=$winning_number?></H1><br>
<? foreach($contestants as $name => $winner_or_loser) : ?>
<?=$name?> is a <?=$winner_or_loser?> <br>
<? endforeach; ?>

</body>
</html>