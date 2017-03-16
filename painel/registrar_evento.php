<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}


$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$organizador = $_POST['organizador'];
$valor = $_POST['valor'];
$pagar_para = $_POST['pagar_para'];


$objBd = new bd();
$link = $objBd->conecta_mysql();

$evento_existe = false;

$sql = "SELECT titulo from eventos where titulo = '$titulo' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['titulo'])){
		$evento_existe = true;
	}
}else{
	echo "erro ao tentar localizar o registro de evento no banco de dados";
}

if($evento_existe){
	$retorno_get = '';

	if($evento_existe){
		$retorno_get.="erro_evento=1";
	}

	header("Location: evento.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO eventos(titulo, descricao, data_inicio, data_fim, organizador, valor, pagar_para) values ('$titulo', '$descricao', '$data_inicio', '$data_fim', 
'$organizador', '$valor', '$pagar_para')";
if(mysqli_query($link, $sql)){
	header("Location: eventos.php?sucesso=1");
}
?>