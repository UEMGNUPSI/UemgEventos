<?php 

require_once("index.php");

$end .= "eventos/";

$id	= base64_decode(filter_input(INPUT_GET, 'e', 
	  FILTER_SANITIZE_SPECIAL_CHARS));

if(!validarAdm($_SESSION['user'], $id)){
	$_SESSION['erro'] = base64_encode(9);
	
	header("Location: {$end}");

	die();
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

chdir('/public/uploads/img-eventos/');

$arquivos = mysqli_query($link, "SELECT banner, arquivo_edital edital FROM eventos WHERE id = {$id}");

$arquivos = mysqli_fetch_array($arquivos);

if(!mysqli_num_rows(mysqli_query($link, "SELECT id FROM atividades WHERE id_evento = {$id}"))){
	if(mysqli_query($link, "DELETE FROM eventos WHERE id = {$id}")){
		if($arquivos['banner'] != 'padrao.png'){
			unlink("{$root}uploads/img-eventos/{$arquivos['banner']}");
		}

		unlink("{$root}uploads/editais/{$arquivos['edital']}");

		mysqli_close($link);

		$_SESSION['success'] = base64_encode(3);

		header("Location: {$end}");

		die();
	}
}
else{
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(3);

	header("Location: {$end}");

	die();
}
?>