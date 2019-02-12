<?php

	require_once("index.php");

	$id = base64_decode(filter_input(INPUT_GET, 'a', 
				FILTER_SANITIZE_SPECIAL_CHARS));
	
	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$teste_admin = mysqli_fetch_array(mysqli_query($link, $sql), MYSQLI_ASSOC);

	if(!validaAdm($_SESSION['user'], $id)){

		$_SESSION['erro'] = base64_encode(9);

		header("Location: {$end}projetos.php");

	    die();
	}

	if(isset($_GET['arq'])){
		$arq = $_GET['arq'];
		$file = substr(strstr($arq, '.', true), 0);
		chdir('/public/uploads/projetos/');

		if(unlink($arq)){
			
			$_SESSION['success'] = base64_encode(3);

			header("Location: {$end}projetos.php");
		}
		else{
			$_SESSION['erro'] = base64_encode(3);

			header("Location: {$end}projetos.php");
		}
	}
?>