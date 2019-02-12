<?php 

session_start();

require_once('../bd.php');	

$objBd = new bd();
$link = $objBd->conecta_mysql();

$nome = mb_convert_case(mb_convert_case($_POST['nome'], MB_CASE_LOWER, "UTF-8"), MB_CASE_TITLE, "UTF-8");
$cpf = $_POST['cpf'];
$nasc = $_POST['nasc'];
$curso = isset($_POST['curso']) && !empty($_POST['curso']) ? $_POST['curso'] : 1;
$ra = isset($_POST['ra']) && !empty($_POST['ra']) ? $_POST['ra'] : "Não Informado";
$ano = isset($_POST['ano']) && !empty($_POST['ano']) ? $_POST['ano'] : "Não Informado";
$tel = isset($_POST['tel']) && !empty($_POST['tel']) ? $_POST['tel'] : "Não Informado";
$cnpj = isset($_POST['cnpj']) && !empty($_POST['cnpj']) ? $_POST['cnpj'] : "Não Informado";
$instituicao = isset($_POST['instituicao']) && !empty($_POST['instituicao']) ? htmlspecialchars($_POST['instituicao'], ENT_QUOTES, 'UTF-8') : "Não Informado";

$email = strtolower(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
$senha = md5($_POST['senha']);


$url = "Location: ../../cadastro.php";

// echo "nome: ".$nome."<br>";
// echo "cpf: ".$cpf."<br>";
// echo "nasc: ".$nasc."<br>";
// echo "curso: ".$curso."<br>";
// echo "ra: ".$ra."<br>";
// echo "ano: ".$ano."<br>";
// echo "tel: ".$tel."<br>";
// echo "cnpj: ".$cnpj."<br>";
// echo "instituicao: ".$instituicao."<br>";
// echo "email: ".$email."<br>";
// echo "senha: ".$senha."<br>";


$sql = "SELECT id, email, ra, cpf FROM usuarios WHERE email = '$email' OR ra = '$ra' OR cpf = '$cpf'";

if($resultado_id = mysqli_query($link, $sql)){
	if(mysqli_num_rows($resultado_id)){
		$result = mysqli_fetch_array($resultado_id);
		
		$erro = "";

		$i = 0;

		if($result['email'] === $email){
			$erro .= "E-mail";
			$i = 1;
		}
		if($i && $result['ra'] === $ra){
			$erro .= ", RA";
		}
		else if(!$i && $result['ra'] === $ra){
			$erro .= "RA";
			$i = 1;
		}
		if($i && $result['cpf'] === $cpf){
			$erro .= ", CPF";
		}
		else if(!$i && $result['cpf'] === $cpf){
			$erro .= "CPF";
		}

		$erro = base64_encode($erro);
		
		header("{$url}?erro={$erro}");
		die();
	}
}else{
	header("{$url}?erro=1");
	die();
}

$sql = "INSERT INTO usuarios (nome, email, senha, ra, ano, cpf, data_nascimento, telefone, cnpj, instituicao, adm, id_curso) VALUES ('$nome','$email','$senha', '$ra', '$ano', '$cpf', '$nasc', '$tel', '$cnpj', '$instituicao', 0, $curso)";


die($sql);

if(mysqli_query($link, $sql)){
	echo "<form id='PrimeiroAcesso' method='post' action='validar_acesso.php?n=1'>";
		echo "<input type='hidden' name='usuario' value='$email' />";
		echo "<input type='hidden' name='senha' value='$senha' />";
	echo "</form>";

	echo "<script>";
		echo "document.getElementById('PrimeiroAcesso').submit()";
	echo "</script>";
	die();
}
else{
	header("{$url}?erro=1");
	die();
}

?>