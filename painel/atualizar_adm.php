<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$id = $_GET['id'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$email = $_POST['email'];

if(!empty($senha)){
	$senha = md5($_POST['senha']);
}else{
	$senha = 0;
}

$objBd = new bd();
$link = $objBd->conecta_mysql();



if($senha != 0){
	$sql = "UPDATE usuarios SET nome = '$nome', senha = '$senha', email = '$email'  WHERE id = $id";
}else{
	$sql = "UPDATE usuarios SET nome = '$nome', email = '$email'  WHERE id = $id";
}

if(mysqli_query($link, $sql)){
	header("Location: administradores.php?sucesso=2");
}
?>