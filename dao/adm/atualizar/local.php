<?php 

require_once('index.php');

$end .= "locais/";

$id 		= 	base64_decode(filter_input(INPUT_GET, 'l', 
							 FILTER_SANITIZE_SPECIAL_CHARS));
$base64_id 	= 	filter_input(INPUT_GET, 'l', 
							 FILTER_SANITIZE_SPECIAL_CHARS);
			
$titulo 	= 	filter_input(INPUT_POST, 'titulo', 
							 FILTER_SANITIZE_SPECIAL_CHARS);

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM locais WHERE titulo = '{$titulo}' AND id <> {$id}"))){
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}locais.php?l={$base64_id}");

	die();
}

if(mysqli_query($link, "UPDATE locais SET local = '{$titulo}' WHERE id = {$id}")){
	mysqli_close($link);

	$_SESSION['success'] = base64_encode(2);
	
	header("Location: {$end}locais.php?l={$base64_id}");
	
	die();
}
else{
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(2);

	header("Location: {$end}locais.php?l={$base64_id}");
	
	die();
}
?>