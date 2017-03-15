<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$id = $_GET['id'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "DELETE FROM categorias WHERE id = $id";


if(mysqli_query($link, $sql)){
	header("Location: categorias.php?sucesso=3");
}
?>