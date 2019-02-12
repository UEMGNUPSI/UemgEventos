<?php 
	require_once('index.php');

	$end .= "eventos/";

	$evento 		= 	base64_decode(filter_input(INPUT_POST, 'e', 
						FILTER_SANITIZE_SPECIAL_CHARS));
	
	$usuario 		= 	isset($_POST['u']) ? base64_decode(filter_input(INPUT_POST, 'u', 
						FILTER_SANITIZE_SPECIAL_CHARS)) : "";
						
	$pagamento		= 	filter_input(INPUT_POST, 'pagamento', 
						FILTER_SANITIZE_SPECIAL_CHARS);

	if(!validaAdm($_SESSION['user'], $evento)){
		# Admin não tem permissão apara editar o evento.
	
		$_SESSION['erro'] = base64_encode(9);
		
		header("Location: {$end}");
	
		die();
	}

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

  	if($usuario !== "")
		$sql = "UPDATE evento_pago SET pagamento = {$pagamento} WHERE usuario = {$usuario} AND evento = {$evento}";
	else
		$sql = "UPDATE evento_pago SET pagamento = {$pagamento} WHERE evento = {$evento}";

	echo $sql;

	if(mysqli_query($link, $sql)){
		$result = mysqli_fetch_array(
			mysqli_query(
				$link, 
				"SELECT ep.pagamento FROM usuarios u 
				 INNER JOIN evento_pago ep ON u.id = ep.usuario 
				 WHERE u.id = {$usuario} 
				 AND ep.evento = {$evento} "
			)
		);

		
	}
?>