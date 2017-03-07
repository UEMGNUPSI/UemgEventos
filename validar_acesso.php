<?php  

session_start();

require_once('bd.class.php');

$usuario = $_POST['usuario'];
$senha = md5($_POST['senha']);

$sql = "SELECT email, admin FROM usuarios WHERE email = '$usuario' AND senha = '$senha'";

$objBd = new bd();
$link = $objBd->conecta_mysql();

$resultado_id = mysqli_query($link, $sql);

if($resultado_id){
	$dados_usuario = mysqli_fetch_array($resultado_id);
	if(isset($dados_usuario['email'])){
		$_SESSION['usuario'] = $dados_usuario['email'];
		$_SESSION['admin'] = $dados_usuario['admin'];
		if($_SESSION['admin'] == 0){
			header("Location: index.php");
		}else{
			header("Location: /UemgEventos/painel/eventos.php");
		}
	}else{
		header("Location: index.php?erro=2");
	}
}else{
	echo 'Erro na execução da consulta';
}

?>