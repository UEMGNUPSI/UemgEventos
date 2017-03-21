<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$id = $_GET['id'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "DELETE FROM atividades WHERE id = $id";


if(mysqli_query($link, $sql)){
	header("Location: atividades.php?sucesso=3");
}
?>