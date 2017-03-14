<?php 

session_start();

require_once('bd.class.php');	

$objBd = new bd();
$link = $objBd->conecta_mysql();

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$usuario_existe = false;

$sql = "SELECT email from usuarios where email = '$email' ";
if($resultado_id = mysqli_query($link, $sql)){
	$dados = mysqli_fetch_array($resultado_id);
	if(isset($dados['nome'])){
		$usuario_existe = true;
	}
}else{
	echo "erro ao tentar localizar or egistro de usuario no banco de dados";
}

if($usuario_existe){
	$retorno_get = '';

	if($usuario_existe){
		$retorno_get.="erro_usuario=1";
	}

	header("Location: cadastro.php?".$retorno_get);
	die();
}

if(isset($_POST['ra'])){
	$ra = $_POST['ra'];
	$curso = $_POST['curso'];
	$ano = $_POST['ano'];

	$sql = "INSERT INTO usuarios (nome,email,senha,ra,id_curso,ano,admin) values ('$nome','$email','$senha', '$ra',$curso,$ano, 0)";
}else{
	$sql = "INSERT INTO usuarios (nome,email,senha,admin) values ('$nome','$email','$senha', 0)";
}

if(mysqli_query($link, $sql)){
	header("Location: cadastro.php?sucesso=1");
}


?>