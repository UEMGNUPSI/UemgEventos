<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}


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

$atividade_existe = false;

$sql = "SELECT titulo from atividades where titulo = '$titulo' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['titulo'])){
		$atividade_existe = true;
	}
}else{
	echo "erro ao tentar localizar o registro de atividade no banco de dados";
}

if($atividade_existe){
	$retorno_get = '';

	if($atividade_existe){
		$retorno_get.="erro_atividade=1";
	}

	header("Location: atividade.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO atividades(titulo, descricao, vagas_total, vagas_disp, ministrante, data_inicio, hora_inicio, hora_fim, local_atividade, id_categoria, id_evento) values 
('$titulo', '$descricao', '$vagas_total', '$vagas_disp', '$ministrante', '$data_inicio', '$hora_inicio', '$hora_fim', '$local_atividade', '$categoria', '$evento')";
if(mysqli_query($link, $sql)){
	header("Location: atividades.php?sucesso=1");
}
?>