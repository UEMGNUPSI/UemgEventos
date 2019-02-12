<?php 

session_start();

require_once('../../config.php');

if(!isset($_GET['e'])){
	if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == true){
		header("Location: /UemgEventos/index.php");
	}
}
else{
	$token = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);
	$novaSenha = md5(filter_input(INPUT_POST, 'novaSenha', FILTER_SANITIZE_SPECIAL_CHARS));

	require_once('../bd.php');

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$user = mysqli_fetch_array(mysqli_query($link, "SELECT email, data FROM requisitar_senha WHERE token = '{$token}'"));

	$horaRequisicao = new DateTime($user['data']);
	$horaAgora = new DateTime(date("Y-m-d H:i"));

	$interval = $horaRequisicao->diff($horaAgora);
	echo $user['data'];
	echo $interval->format(" %R %d %H %i ");

	if(intval($interval->format("%d")) === 0 &&
	  (intval($interval->format("%H")) === 0) &&
	  ($interval->format("%R") === "+") &&
	  (intval($interval->format("%i")) < 10)){
		if(mysqli_query($link, "UPDATE usuarios SET senha = '{$novaSenha}' WHERE email = '{$user['email']}'")){
			if(mysqli_query($link, "DELETE FROM requisitar_senha WHERE token = '{$token}'"))
				header("Location: ../../index.php?success=3");
		}
	}
	else{
		header("Location: ../../recuperar_senha.php?t={$token}");
	}
	mysqli_close($link);
	die();
}

die();

require_once('../bd.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();

$nome = !empty($_POST['nome'])? $_POST['nome'] : '0';
$email = !empty($_POST['email'])? $_POST['email'] : '0';
$senha = !empty($_POST['senha'])? md5($_POST['senha']) : '0';

$ra = !empty($_POST['ra'])? $_POST['ra'] : '0';
$curso = !empty($_POST['curso'])? $_POST['curso'] : '0';
$ano = !empty($_POST['ano'])? $_POST['ano'] : '0';

$nasc = !empty($_POST['nasc'])? $_POST['nasc'] : '0';
$tel = !empty($_POST['tel'])? $_POST['tel'] : '0';
$cnpj = !empty($_POST['cnpj'])? $_POST['cnpj'] : '0';

$instituicao = !empty($_POST['instituicao'])? $_POST['instituicao'] : '0';

$cpf = !empty($_POST['cpf'])? $_POST['cpf'] : '0';


$sql = "UPDATE usuarios SET ";

if(!empty($nome)){
	$sql.="nome = '$nome', ";
}

if(!empty($email)){
	$sql.="email = '$email', ";
}

if(!empty($senha)){
	$sql.="senha = '$senha', ";
}

if(!empty($ra)){
	if(strlen($ra) != 7){
		header("Location: perfil.php?erro=4");

		die();
	}

	$sql.="ra = '$ra', ";
}

if(!empty($curso)){
	$sql.="id_curso = $curso, ";
}

if(!empty($ano)){
	$sql.="ano = $ano, ";
}

if(!empty($cpf)){

	if(strlen($cpf) != 11){
		header("Location: perfil.php?erro=3");

		die();
	}

	$sql.="cpf = '$cpf', ";
}

if(!empty($nasc)){
	$sql.="data_nascimento = '$nasc', ";
}

if(!empty($tel)){
	$sql.="telefone = '$tel', ";
}

if(!empty($cnpj)){
	$sql.="cnpj = '$cnpj', ";
}

if(!empty($instituicao)){
	$sql.="instituicao = '$instituicao', ";
}

$sql .= " admin = 0 WHERE id = ".$_SESSION['id'];
echo $sql;
if(mysqli_query($link, $sql)){

	header("Location: validar_acesso.php?l=3");
}
else{
	
	header("Location: perfil.php?erro=1");
}

?>