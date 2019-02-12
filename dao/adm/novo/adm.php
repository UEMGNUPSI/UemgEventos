<?php 

require_once("index.php");

$end .= "administradores/";

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(!mysqli_num_rows(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}' AND id = 1 AND adm = 1"))){
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(9);

	header("Location: {$end}");

	die();
}

$nome 	= 	filter_input(INPUT_POST, 'nome', 
			FILTER_SANITIZE_SPECIAL_CHARS);
$senha 	= 	md5(filter_input(INPUT_POST, 'senha', 
			FILTER_SANITIZE_SPECIAL_CHARS));
$email	= 	filter_input(INPUT_POST, 'email', 
			FILTER_SANITIZE_SPECIAL_CHARS);

if(mysqli_num_rows(mysqli_query($link, "SELECT email FROM usuarios WHERE email = '{$email}'"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}");

	die();
}

$sql = "INSERT INTO usuarios(nome, email, senha, adm) VALUES ('{$nome}', '{$email}', '{$senha}', 1)";
if(mysqli_query($link, $sql)){
	mysqli_close($link);
	
	$_SESSION['success'] = base64_encode(1);

	header("Location: {$end}");

	die();
}
else{
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(1);

	header("Location: {$end}administradores.php");

	die();
}
?>