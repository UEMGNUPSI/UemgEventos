<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$id = $_GET['id'];
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$evento = $_POST['evento'];
$categoria = $_POST['categoria'];
$vagas_total = $_POST['vagas_total'];
$vagas_disp = $_POST['vagas_disp'];
$ministrante = $_POST['ministrante'];
$data_inicio = $_POST['data_inicio'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fim = $_POST['hora_fim'];
$local_atividade = $_POST['local_atividade'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

	$sql = "UPDATE atividades SET titulo ='$titulo', descricao ='$descricao', vagas_total='$vagas_total', vagas_disp='$vagas_disp', ministrante='$ministrante',
	data_inicio ='$data_inicio', hora_inicio ='$hora_inicio', hora_fim ='$hora_fim', local_atividade ='$local_atividade', id_categoria='$categoria', id_evento='$evento' WHERE id ='$id'";


if(mysqli_query($link, $sql)){
	header("Location: atividades.php?sucesso=2");
}
?>