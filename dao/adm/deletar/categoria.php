<?php 

require_once("index.php");

$end .= "categorias/";

$id	= base64_decode(filter_input(INPUT_GET, 'c', 
	  FILTER_SANITIZE_SPECIAL_CHARS));

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "SELECT a.id FROM atividades a
		INNER JOIN categorias c ON a.id_categoria = c.id
		WHERE c.id = {$id}";

if(!mysqli_num_rows(mysqli_query($link, $sql))){
	if(mysqli_query($link, "DELETE FROM categorias WHERE id = {$id}")){
		mysqli_close($link);

		$_SESSION['success'] = base64_encode(3);

		header("Location: {$end}");

		die();
	}
}

mysqli_close($link);

$_SESSION['erro'] = base64_encode(3);

header("Location: {$end}");

die();

?>