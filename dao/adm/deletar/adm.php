<?php 

require_once("index.php");

$end .= "administradores/";

$id = base64_decode(filter_input(INPUT_GET, 'a', FILTER_SANITIZE_SPECIAL_CHARS));

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(!mysqli_num_rows(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}' AND id = 1 AND adm = 1"))){
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(9);

	header("Location: {$end}");

	die();
}

if(mysqli_query($link, "DELETE FROM usuarios WHERE id = {$id} AND adm = 1")){
	mysqli_close($link);
	
	$_SESSION['success'] = base64_encode(3);

	header("Location: {$end}");

	die();
}
else{
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(3);

	header("Location: {$end}");

	die();
}
?>