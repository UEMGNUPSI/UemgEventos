<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$titulo = $_POST['titulo'];

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
	echo "erro ao tentar localizar or egistro de usuario no banco de dados";
}

if($atividade_existe){
	$retorno_get = '';

	if($atividade_existe){
		$retorno_get.="erro_atividade=1";
	}

	header("Location: atividade.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO atividades(titulo) values ('$titulo')";
if(mysqli_query($link, $sql)){
	header("Location: atividades.php?sucesso=1");
}
?>