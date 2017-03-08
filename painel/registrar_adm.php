<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$nome = $_POST['nome'];
$senha = md5($_POST['senha']);
$email = $_POST['email'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

$usuario_existe = false;

$sql = "SELECT email from usuarios where email = '$email' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['email'])){
		$usuario_existe = true;
	}
}else{
	echo "erro ao tentar localizar or egistro de usuario no banco de dados";
}

if($usuario_existe){
	$retorno_get = '';

	if($usuario_existe){
		$retorno_get.="erro_usuario=1";
	}

	header("Location: adm.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO usuarios(nome, email, senha, admin) values ('$nome', '$email', '$senha', 1)";
if(mysqli_query($link, $sql)){
	header("Location: administradores.php?sucesso=1");
}
?>