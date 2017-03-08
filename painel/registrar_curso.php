<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$titulo = $_POST['titulo'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

$curso_existe = false;

$sql = "SELECT titulo from cursos where titulo = '$titulo' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['titulo'])){
		$curso_existe = true;
	}
}else{
	echo "erro ao tentar localizar or egistro de usuario no banco de dados";
}

if($curso_existe){
	$retorno_get = '';

	if($curso_existe){
		$retorno_get.="erro_curso=1";
	}

	header("Location: curso.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO cursos(titulo) values ('$titulo')";
if(mysqli_query($link, $sql)){
	header("Location: cursos.php?sucesso=1");
}
?>