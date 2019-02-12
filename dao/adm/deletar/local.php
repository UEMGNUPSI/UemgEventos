<?php 

require_once("index.php");

$end .= "locais/";

$id	= base64_decode(filter_input(INPUT_GET, 'l', 
	  FILTER_SANITIZE_SPECIAL_CHARS));

$objBd = new bd();
$link = $objBd->conecta_mysql();

$sql = "SELECT e.id FROM eventos e
		INNER JOIN locais l ON e.id_local = l.id
		WHERE l.id = {$id}";

if(!mysqli_num_rows(mysqli_query($link, $sql))){
	if(mysqli_query($link, "DELETE FROM locais WHERE id = {$id}")){
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