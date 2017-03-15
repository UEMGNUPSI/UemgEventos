<?php 

session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$titulo = $_POST['titulo'];

$objBd = new bd();
$link = $objBd->conecta_mysql();

$categoria_existe = false;

$sql = "SELECT titulo from categorias where titulo = '$titulo' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['titulo'])){
		$categoria_existe = true;
	}
}else{
	echo "erro ao tentar localizar or egistro de usuario no banco de dados";
}

if($categoria_existe){
	$retorno_get = '';

	if($categoria_existe){
		$retorno_get.="erro_categoria=1";
	}

	header("Location: categoria.php?".$retorno_get);
	die();
}




$sql = "INSERT INTO categorias(titulo) values ('$titulo')";
if(mysqli_query($link, $sql)){
	header("Location: categorias.php?sucesso=1");
}
?>