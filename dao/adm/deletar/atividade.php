<?php 

require_once("index.php");

$end .= "eventos/";

if(isset($_GET['e'])){
	$evento 		= 	base64_decode(filter_input(INPUT_GET, 'e', 
					FILTER_SANITIZE_SPECIAL_CHARS));
	$base64_evento 	= 	filter_input(INPUT_GET, 'e', 
					FILTER_SANITIZE_SPECIAL_CHARS);
}
else{
	$_SESSION['erro'] = base64_encode(9);

	header("Location: {$end}");
}

if(isset($_GET['a'])){
	$id	= base64_decode(filter_input(INPUT_GET, 'a', FILTER_SANITIZE_SPECIAL_CHARS));
}
else{
	$_SESSION['erro'] = base64_encode(9);

	header("Location: {$end}atividades.php?e={$base64_evento}");
	die();
}

if(!validarAdm($_SESSION['user'], $evento)){
	$_SESSION['erro'] = base64_encode(9);
	header("Location: {$end}");
	
	die();
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "SELECT u.nome titulo, ua.presenca FROM usuarios u 
		INNER JOIN evento_pago ep ON u.id = ep.usuario 
		INNER JOIN eventos e ON ep.evento = e.id
		INNER JOIN usuario_atividade ua ON u.id = ua.usuario
		INNER JOIN atividades a ON ua.atividade = a.id
		WHERE e.id = {$evento} 
		AND a.id = {$id} 
		AND ep.pagamento = 1 ";

if(!mysqli_num_rows(mysqli_query($link, $sql))){
	if(mysqli_query($link, "DELETE FROM atividades WHERE id = $id")){
		mysqli_close($link);
		
		$_SESSION['success'] = base64_encode(3);
		
		header("Location: {$end}atividades.php?e={$base64_evento}");
	
		die();
	}
}

mysqli_close($link);

$_SESSION['erro'] = base64_encode(12);

header("Location: {$end}atividades.php?e={$base64_evento}");

die();

?>