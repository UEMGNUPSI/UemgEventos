<?php 

require_once("index.php");

$end .= "administradores/";

$id		= 	base64_decode(filter_input(INPUT_GET, 'a',
			FILTER_SANITIZE_SPECIAL_CHARS));

$nome 	= 	filter_input(INPUT_POST, 'nome',
			FILTER_SANITIZE_SPECIAL_CHARS);

$senha 	= 	isset($_POST['senha']) ? md5(filter_input(INPUT_POST, 'senha',
			FILTER_SANITIZE_SPECIAL_CHARS)) : 0;
			
$email 	= 	filter_input(INPUT_POST, 'email',
			FILTER_SANITIZE_SPECIAL_CHARS);

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(!mysqli_num_rows(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}' AND id = 1 AND adm = 1"))){
	mysqli_close($link);
	$_SESSION['erro'] = base64_encode(9);
	header("Location: {$end}");

	die();
}

if(mysqli_num_rows(mysqli_query($link, "SELECT email FROM usuarios WHERE email = '{$email}' AND id <> {$id}"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}administradores.php?a=".base64_encode($id));

	die();
}

if($senha){
	$sql = "UPDATE usuarios SET nome = '$nome', senha = '$senha', email = '$email'  WHERE id = $id";
}else{
	$sql = "UPDATE usuarios SET nome = '$nome', email = '$email'  WHERE id = $id";
}

if(mysqli_query($link, $sql)){
	mysqli_close($link);

	$_SESSION['success'] = base64_encode(2);
	
	header("Location: {$end}administradores.php?a=".base64_encode($id));

	die();
}
else{
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(2);

	header("Location: {$end}administradores.php?a=".base64_encode($id));

	die();
}
?>