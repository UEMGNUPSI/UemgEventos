<?php  

session_start();

require_once('../bd.php');

$url = isset($_GET['l']) ? base64_decode($_GET['l']) : "/public";

if(!isset($_GET['n'])){
	$usuario = strtolower(htmlentities($_POST['usuario']));
	$senha = md5($_POST['senha']);
}
else{
	$usuario = strtolower(htmlentities($_POST['usuario']));
	$senha = $_POST['senha'];

	$_SESSION['PrimeiroAcesso'] = 1;
}

$sql = "SELECT * FROM usuarios WHERE email = '$usuario' AND senha = '$senha'";

$objBd = new bd();
$link = $objBd->conecta_mysql();

if($result = mysqli_query($link, $sql)){
	if(mysqli_num_rows($result)){
		$user = mysqli_fetch_array($result);
		$_SESSION['user'] = $user['email'];

		if($user['adm']){
			$_SESSION['admin'] = 1;
			header("Location: /public/painel/");
		}
		else{
			$_SESSION['admin'] = 0;
			header("Location: {$url}");
		}
	}
	else{
		header("Location: {$url}?erro=2");
	}
}
else{
	header("Location: {$url}?erro=2");
}

?>
