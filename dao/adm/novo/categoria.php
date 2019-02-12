<?php 

require_once("index.php");

$end .= "categorias/";

$objBd = new bd();
$link = $objBd->conecta_mysql();

$titulo = 	filter_input(INPUT_POST, 'titulo', 
			FILTER_SANITIZE_SPECIAL_CHARS);

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM categorias WHERE titulo = '{$titulo}'"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}");

	die();
}

if(mysqli_query($link, "INSERT INTO categorias(titulo) VALUES ('{$titulo}')")){
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