<?php  

	require_once("index.php");

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	if(isset($_GET['id'])){
		$id_atividade 	= $_GET['id'];
		$id_evento 		= $_GET['ide'];

		$user = mysqli_fetch_array(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}'"));

		$id_usuario 	= $user['id'];
		$local 			= base64_decode($_GET['l']);

		$rows_atv = mysqli_num_rows(
			mysqli_query(
				$link, "SELECT * FROM usuario_atividade WHERE usuario = {$id_usuario} AND atividade = {$id_atividade}"
			)
		);
		
		if($resultado_id = mysqli_query($link, "SELECT vagas_disp, id_evento FROM atividades WHERE id = {$id_atividade}"))
			$vagas = mysqli_fetch_array($resultado_id,  MYSQLI_ASSOC);

		if($vagas['vagas_disp'] > 0){

			$evt =  mysqli_fetch_array(
						mysqli_query(
							$link, "SELECT id, valor FROM eventos WHERE id = {$id_evento}"
						), 
						MYSQLI_ASSOC
					);

			$rows_evt = mysqli_num_rows(
					mysqli_query(
						$link, "SELECT * FROM evento_pago WHERE usuario = {$id_usuario} AND evento = {$id_evento}"
					)
				);


			// se o número de linhas que retornou do banco for igual a 0, então o usuário não se cadastrou na atividade.
			if($evt['valor'] > 0){
				$_SESSION['erro'] = base64_encode(1);
				header("Location: {$local}");
				die();
			}
			else if($rows_evt == 0){
				$sql = "INSERT INTO evento_pago (usuario,evento,pagamento) VALUES ($id_usuario,$id_evento,1)";

				mysqli_query($link, $sql);
			}
			
			if($rows_atv == 0){

				$sql = "INSERT INTO usuario_atividade (usuario,atividade,presenca) VALUES ($id_usuario, $id_atividade,0)";

				if(mysqli_query($link,$sql)){
					$new_vaga = $vagas['vagas_disp'] - 1;

					$sql = "UPDATE atividades SET vagas_disp = {$new_vaga} WHERE id = {$id_atividade}";
					
					if(mysqli_query($link,$sql)){
						$_SESSION['success'] = base64_encode(1);
					}
				}
			}
			else{
				$sql = "DELETE FROM usuario_atividade WHERE usuario = {$id_usuario} AND atividade = {$id_atividade}";
				
				if(mysqli_query($link, $sql)){
					$new_vaga = $vagas['vagas_disp'] + 1;

					$sql = "UPDATE atividades SET vagas_disp = {$new_vaga} WHERE id = {$id_atividade}";

					if(mysqli_query($link, $sql)){
						$_SESSION['success'] = base64_encode(2);
					}
				}
			}
		}
		else{
			$_SESSION['erro'] = base64_encode(2);
		}
	}

	mysqli_close($link);

	header("Location: {$local}");
	die();