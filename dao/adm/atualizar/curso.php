<?php 

require_once('index.php');

$end .= "cursos/"; 

$id 	= 	base64_decode(filter_input(INPUT_GET, 'c', 
			FILTER_SANITIZE_SPECIAL_CHARS));

$titulo = 	filter_input(INPUT_POST, 'titulo', 
			FILTER_SANITIZE_SPECIAL_CHARS);

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM cursos WHERE titulo = '{$titulo}' AND id <> {$id}"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}cursos.php?c=".base64_encode($id));

	die();
}

if(mysqli_query($link, "UPDATE cursos SET titulo = '{$titulo}' WHERE id = {$id}")){
	mysqli_close($link);
	
	$_SESSION['success'] = base64_encode(2);

	header("Location: {$end}");
	
	die();
}
else{
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(2);

	header("Location: {$end}cursos.php");
	
	die();
}
?>