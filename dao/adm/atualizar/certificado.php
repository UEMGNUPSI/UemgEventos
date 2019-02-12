<?php 

	require_once('index.php');

	$end .= "eventos/";

	$id 		= 	base64_decode(filter_input(INPUT_GET, 'e', 
					FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_id 	= 	filter_input(INPUT_GET, 'e', 
					FILTER_SANITIZE_SPECIAL_CHARS);

	if(!validaAdm($_SESSION['user'], $id)){
		$_SESSION['erro'] = base64_encode(9);
		header("Location: ../eventos/");
		
		die();
	}

	$sql = "SELECT e.regra, u.id, COUNT(ua.presenca) AS presenca, e.certificado FROM eventos e INNER JOIN atividades a ON e.id = a.id_evento INNER JOIN usuario_atividade ua ON a.id = ua.atividade INNER JOIN usuarios u ON ua.usuario = u.id WHERE e.id = $id AND ua.presenca = 1 GROUP BY u.id ORDER BY u.id";

	$objBd = new bd();
	$link = $objBd->conecta_mysql();
	
	// echo $sql;

	if($result = mysqli_query($link, $sql)){

		$row = mysqli_num_rows($result);

		if($row){
			while($user = mysqli_fetch_assoc($result)){
				$sql = "SELECT id FROM atividades WHERE id_evento = $id";

				$num = mysqli_num_rows(mysqli_query($link, $sql));

				$porcentagem = ($user['presenca']/$num)*100;

				if($user['regra'] <= $porcentagem){

					$sql = "INSERT INTO certificados(evento, usuario) VALUES ($id, ".$user['id'].")";
					if(mysqli_query($link, $sql)){
						$_SESSION['success'] = base64_encode(9);
					}
					else{
						$_SESSION['erro'] = base64_encode(10);
					}
				}
			}
			
		}
		else{
			$_SESSION['erro'] = base64_encode(10);
		}
	}
	else{
		$_SESSION['erro'] = base64_encode(10);
	}

	header("Location: {$end}eventos.php?e={$base64_id}");

?>