<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$id = $_GET['id'];
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$data_inicial = $_POST['data_inicial'];
$data_fim = $_POST['data_fim'];
$organizador = $_POST['organizador'];
$valor = $_POST['valor'];
$pagar_para = $_POST['pagar_para'];


$objBd = new bd();
$link = $objBd->conecta_mysql();

	$sql = "UPDATE eventos SET titulo ='$titulo', descricao ='$descricao', data_inicial ='$data_inicial', data_fim ='$data_fim', organizador ='$organizador', valor ='$valor', 
	pagar_para='$pagar_para' WHERE id ='$id'";


if(mysqli_query($link, $sql)){
	header("Location: eventos.php?sucesso=2");
}
?>