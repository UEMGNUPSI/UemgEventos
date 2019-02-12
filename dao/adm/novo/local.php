<?php 

require_once("index.php");

$end .= "locais/";

$objBd = new bd();
$link = $objBd->conecta_mysql();

$titulo = 	filter_input(INPUT_POST, 'titulo', 
			FILTER_SANITIZE_SPECIAL_CHARS);

if(mysqli_num_rows(mysqli_query($link, "SELECT local FROM locais WHERE local = '{$titulo}'"))){
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(1);

	header("Location: {$end}locais.php");

	die();
}

if(mysqli_query($link, "INSERT INTO locais(local) values ('{$titulo}')")){
	mysqli_close($link);

	$_SESSION['success'] = base64_encode(1);

	header("Location: {$end}");

	die();
}
else{
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(1);

	header("Location: {$end}");

	die();
}
?>