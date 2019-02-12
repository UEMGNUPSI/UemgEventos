<?php 

	require_once('index.php');

	$end .= "eventos/";

	$titulo			=	htmlentities($_POST['titulo'], ENT_QUOTES);
	$descricao		=	htmlentities($_POST['descricao'], ENT_QUOTES);
	$data_inicio	=	htmlentities($_POST['data_inicio'], ENT_QUOTES);
	$data_fim		=	htmlentities($_POST['data_fim'], ENT_QUOTES);
	$organizador	=	htmlentities($_POST['organizador'], ENT_QUOTES);
	$valor 			=	!is_null($_POST['valor']) ? 
						htmlentities($_POST['valor'], ENT_QUOTES) : 0;
	$pagar_para   	=	htmlentities($_POST['pagar_para'], ENT_QUOTES);
	$status			=	htmlentities($_POST['status'], ENT_QUOTES);
	$local			= 	htmlentities($_POST['local'], ENT_QUOTES);

	$edital 		= 	isset($_POST['edital']) ? 1 : 0;
	$submissao 		= 	isset($_POST['submissao']) ? 1 : 0;
	$certificado 	= 	isset($_POST['certificado']) ? 1 : 0;
	$regra 			= 	isset($_POST['regra']) ? $_POST['regra'] : 0;

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM eventos WHERE titulo = '{$titulo}'"))){
		mysqli_close($link);
		
		$_SESSION['erro'] = base64_encode(11);

		header("Location: {$end}eventos.php");

		die();
	}

	$sql = "INSERT INTO eventos
			(titulo, descricao, data_inicio, data_fim, 
			 organizador, valor, pagar_para, banner, status, 
			 id_local, edital, arquivo_edital, submissao_projeto, 
			 certificado, regra, adm) 
			 VALUES 
			 ('{$titulo}', '{$descricao}', '{$data_inicio}', '{$data_fim}', '{$organizador}', '{$valor}', '{$pagar_para}', ";
	
	if($_FILES['banner']['size'] > 0 || $_FILES['arquivo']['size'] > 0){
		// Pasta onde o arquivo vai ser salvo
		$_UP['pasta_banner'] 	= 	"{$root}uploads/img-eventos/";
		$_UP['pasta_arquivo'] 	= 	"{$root}uploads/editais/";

		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 2;		 // 2Mb

		// Array com as extensões permitidas
		$_UP['extensoes'] = array('png', 'jpg','jpeg','pdf');

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if (($_FILES['banner']['error'] != 0 && $_FILES['banner']['error'] != 4) || ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)){
			mysqli_close($link);
			
			$_SESSION['erro'] = base64_encode(1);

			header("Location: {$end}eventos.php");

			die();
		}
		
		if($_FILES['banner']['error'] != 4){
			$ext_banner = substr(strstr($_FILES['banner']['type'], "/"), 1);
			if(array_search($ext_banner, $_UP['extensoes']) === false){
				mysqli_close($link);
				
				$_SESSION['erro'] = base64_encode(3);

				header("Location: {$end}eventos.php");
				
				die();
			}
		}

		if($_FILES['arquivo']['error'] != 4){
			$ext_arquivo = substr(strstr($_FILES['arquivo']['type'], "/"), 1);
		
			if(array_search($ext_arquivo, $_UP['extensoes']) === false){
				mysqli_close($link);
				
				$_SESSION['erro'] = base64_encode(4);

				header("Location: {$end}eventos.php");
					
				die();
			}
		}

		// Faz a verificação do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['banner']['size']) {
			$_SESSION['erro'] = base64_encode(5);

			header("Location: {$end}eventos.php");
			
			die();
		}

		if($_UP['tamanho'] < $_FILES['arquivo']['size']){
			$_SESSION['erro'] = base64_encode(6);

			header("Location: {$end}eventos.php");
			
			die();
		}

		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		// Renomeia o arquivo

		$nome_banner_final = $_FILES['banner']['size'] > 0 ? $_FILES['banner']['name'] : "";
		$nome_arquivo_final = $_FILES['arquivo']['size'] > 0 ? $_FILES['arquivo']['name'] : "";

		// Salvar banner

		if($_FILES['banner']['size'] > 0){
	
			$nome_banner_final = $_FILES['banner']['name'];
	
			$nome_banner_final = md5(htmlentities($nome_banner_final, ENT_QUOTES)).'.'.$ext_banner;
	
			while(file_exists($_UP['pasta_banner'] . $nome_banner_final)){
				$nome_banner_final = md5(htmlentities($_FILES['banner']['name'], ENT_QUOTES).rand(1,9999)).'.'.$ext_banner;
			}
	
			# O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta.
			if(move_uploaded_file($_FILES['banner']['tmp_name'], $_UP['pasta_banner'] . $nome_banner_final)){

				if($ext_banner === "png")
					$src = imagecreatefrompng($_UP['pasta_banner'].$nome_banner_final);

				if($ext_banner === "jpg" || $ext_banner === "jpeg")
					$src = imagecreatefromjpeg($_UP['pasta_banner'].$nome_banner_final);

				list($width, $height) = getimagesize($_UP['pasta_banner'].$nome_banner_final);

				$dst = imagecreatetruecolor(1140, 500);

				imagecopyresampled($dst, $src, 0, 0, 0, 0, 1140, 500, $width, $height);

				if($ext_banner === "png")
					imagepng($dst, $_UP['pasta_banner'].$nome_banner_final);

				if($ext_banner === "jpg" || $ext_banner === "jpeg")
					imagejpeg($dst, $_UP['pasta_banner'].$nome_banner_final);
	
				$sql .= "'$nome_banner_final', ";
			}
			else{
				
				$_SESSION['erro'] = base64_encode(1);

				header("Location: {$end}eventos.php");
			
				die();
			}
		}
		else{
			$sql .= "'padrao.png', ";
		}
		
		$sql .= "'$status', '$local', $edital, ";

		// Salvar Edital

		if($_FILES['arquivo']['size'] > 0){
			// chdir("../".$_UP['pasta_arquivo']);

			$nome_arquivo_final = $_FILES['arquivo']['name'];

			$nome_arquivo_final = "[".$_POST['titulo']."] ".$nome_arquivo_final;
			$i = 1;
			while(file_exists($_UP['pasta_arquivo'] . $nome_arquivo_final)){
				$arquivo_sem_extensao = substr($nome_arquivo_final, 0, -4);

				$nome_arquivo_final = $arquivo_sem_extensao."($i).".$ext_arquivo;
				
				$i++;
			}
			unset($i);
			
			# O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta.
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta_arquivo'] . $nome_arquivo_final)){

				$sql .= "'$nome_arquivo_final', ";
			}
			else{
				mysqli_close($link);
				
				$_SESSION['erro'] = base64_encode(1);

				header("Location: {$end}eventos.php");
			
				die();
			}
		}
		else{
			$sql .= "NULL, ";
		}
	}
	else{
		$sql .= "'padrao.png', '{$status}', {$local}, {$edital}, NULL, ";
	}

	$sql .= "{$submissao}, {$certificado}, {$regra}, {$_SESSION['id']})";

	if(mysqli_query($link, $sql)){
		$last_id = mysqli_fetch_array(mysqli_query($link, "SELECT id FROM eventos ORDER BY id DESC"));

		mysqli_close($link);

		$_SESSION['success'] = base64_encode(1);

		header("Location: {$end}eventos.php?e=".base64_encode($last_id['id']));

		die();
	}
	else{
		mysqli_close($link);
		unlink($_UP['pasta_banner'] . $nome_banner_final);
		unlink($_UP['pasta_arquivo'] . $nome_arquivo_final);

		$_SESSION['erro'] = base64_encode(1);

		header("Location: {$end}eventos.php");

		die();
	}
?>