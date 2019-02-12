<?php 

require_once("index.php");

$end .= "cursos/";

$id	= base64_decode(filter_input(INPUT_GET, 'c', 
	  FILTER_SANITIZE_SPECIAL_CHARS));

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "SELECT u.id FROM usuarios u
		INNER JOIN cursos c ON u.id_curso = c.id
		WHERE c.id = {$id}";

if(!mysqli_num_rows(mysqli_query($link, $sql))){
	if(mysqli_query($link, "DELETE FROM cursos WHERE id = {$id}")){
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