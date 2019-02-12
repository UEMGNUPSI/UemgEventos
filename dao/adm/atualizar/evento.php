<?php 

# 		Regras de erros
# 1 - Erro ao tentar atualizar os dados.
# 2 - Erro ao tentar realizar o upload do(s) arquivo(s).
# 3 - Extensão não suportada.
# 4 - Tamanho maior que o suportado.
# 5 - Erro ao tentar remover a imagem.



require_once('index.php');

$end .= "eventos/";

$id 		= 	base64_decode(filter_input(INPUT_GET, 'e', 
				FILTER_SANITIZE_SPECIAL_CHARS));

$base64_id 	= 	filter_input(INPUT_GET, 'e', 
				FILTER_SANITIZE_SPECIAL_CHARS);



if(!validaAdm($_SESSION['user'], $id)){
	# Admin não tem permissão apara editar o evento.

	$_SESSION['erro'] = base64_encode(9);
	
	header("Location: {$end}");

	die();
}

// Pasta onde o arquivo vai ser salvo
$_UP['pasta_banner'] 	= 	"{$root}uploads/img-eventos/";
$_UP['pasta_arquivo'] 	= 	"{$root}uploads/editais/";

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_POST['removerBanner']) && isset($_POST['imgBanner'])){
	$sql = "UPDATE eventos SET banner = 'padrao.png' WHERE id = {$id}";
	if(mysqli_query($link, $sql)){
		unlink($_UP['pasta_banner'].$_POST['imgBanner']);

		$_SESSION['success'] = base64_encode(7);

		header("Location: {$end}eventos.php?e={$base64_id}");
	}		
	else{
		$_SESSION['erro'] = base64_encode(7);
		
		header("Location: {$end}eventos.php?e={$base64_id}");
	}
		
	
	die();
}
if(isset($_POST['removerEdital']) && isset($_POST['arquivoEdital'])){
	$sql = "UPDATE eventos SET arquivo_edital = NULL WHERE id = {$id}";

	if(mysqli_query($link, $sql)){
		unlink($_UP['pasta_arquivo'].$_POST['arquivoEdital']);

		$_SESSION['success'] = base64_encode(8);

		header("Location: {$end}eventos.php?e={$base64_id}");
	}
		
	else{
		$_SESSION['erro'] = base64_encode(8);
		header("Location: {$end}eventos.php?e={$base64_id}");
	}
	die();
}

$titulo	= htmlentities($_POST['titulo'], ENT_QUOTES);

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM eventos WHERE titulo = '{$titulo}' AND id <> {$id}"))){
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}eventos.php?e={$base64_id}");

	die();
}

$descricao 		   	=	htmlentities($_POST['descricao'], ENT_QUOTES);
$data_inicio 	   	=	htmlentities($_POST['data_inicio'], ENT_QUOTES);
$data_fim 		   	=	htmlentities($_POST['data_fim'], ENT_QUOTES);
$organizador		=	htmlentities($_POST['organizador'], ENT_QUOTES);
$valor 			   	=	!is_null($_POST['valor']) ? 
						htmlentities($_POST['valor'], ENT_QUOTES) : 0;
$pagar_para   	 	=	htmlentities($_POST['pagar_para'], ENT_QUOTES);
$status 			=	htmlentities($_POST['status'], ENT_QUOTES);
$local 				=	htmlentities($_POST['local'], ENT_QUOTES);

$edital 		= isset($_POST['edital']) ? 1 : 0;
$submissao 		= isset($_POST['submissao']) ? 1 : 0;
$certificado	= isset($_POST['certificado']) ? 1 : 0;
$regra 			= isset($_POST['regra']) ? $_POST['regra'] : 0;

$sql = "UPDATE eventos SET titulo ='$titulo', descricao ='$descricao', data_inicio ='$data_inicio', data_fim ='$data_fim', organizador ='$organizador', valor ='$valor', pagar_para='$pagar_para', status='$status', ";

# UPLOAD DO BANNER
if($_FILES['banner']['size'] > 0 || $_FILES['arquivo']['size'] > 0){

	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 2; 		// 2Mb

	// Array com as extensões permitidas
	$_UP['extensoes'] = array('png', 'jpg','jpeg','pdf');

	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if (($_FILES['banner']['error'] != 0 && $_FILES['banner']['error'] != 4) || ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4)) {

		$_SESSION['erro'] = base64_encode(2);

		header("Location: {$end}eventos.php?e={$base64_id}");
		die();
	}
	
	if($_FILES['banner']['error'] != 4){
		$ext_banner = substr(strstr($_FILES['banner']['type'], "/"), 1);
		if(array_search($ext_banner, $_UP['extensoes']) === false){
			
			$_SESSION['erro'] = base64_encode(3);

			header("Location: {$end}eventos.php?e={$base64_id}");
			
			die();
		}
	}
	
	if($_FILES['arquivo']['error'] != 4){
		$ext_arquivo = substr(strstr($_FILES['arquivo']['type'], "/"), 1);
	
		if(array_search($ext_arquivo, $_UP['extensoes']) === false){
			$_SESSION['erro'] = base64_encode(4);

			header("Location: {$end}eventos.php?e={$base64_id}");
				
			die();
		}
	}
	
	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['banner']['size']) {
		$_SESSION['erro'] = base64_encode(5);

		header("Location: {$end}eventos.php?e={$base64_id}");
		
		die();
	}

	if($_UP['tamanho'] < $_FILES['arquivo']['size']){
		$_SESSION['erro'] = base64_encode(6);
		header("Location: {$end}eventos.php?e={$base64_id}");
		
		die();
	}

	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	// Renomeia o arquivo
	
	$nome_banner_final = $_FILES['banner']['size'] > 0 ? $_FILES['banner']['name'] : "";
	$nome_arquivo_final = $_FILES['arquivo']['size'] > 0 ? $_FILES['arquivo']['name'] : "";

	
	
	// Salvar Banner

	if($_FILES['banner']['size'] > 0){
		// chdir("../".$_UP['pasta_banner']);

		$nome_banner_final = $_FILES['banner']['name'];

		$nome_banner_final = md5(htmlentities($nome_banner_final, ENT_QUOTES)).'.'.$ext_banner;

		$banner = mysqli_fetch_array(mysqli_query($link, "SELECT banner FROM eventos WHERE id = {$id} AND banner <> 'padrao.png'"));

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

			$sql .= "banner = '{$nome_banner_final}', ";
		}
		else{
			$_SESSION['erro'] = base64_encode(2);

			die("olar");

			header("Location: {$end}eventos.php?e={$base64_id}");
		
			die();
		}
	}

	$sql .= "id_local='{$local}',edital={$edital}, ";

	// Salvar Edital

	if($_FILES['arquivo']['size'] > 0){
		// chdir("../".$_UP['pasta_arquivo']);

		$nome_arquivo_final = $_FILES['arquivo']['name'];

		$nome_arquivo_final = "[".$_POST['titulo']."] ".$nome_arquivo_final;

		$arq = mysqli_fetch_array(mysqli_query($link, "SELECT arquivo_edital FROM eventos WHERE id = {$id}"));
		
		while(file_exists($_UP['pasta_arquivo'] . $nome_arquivo_final)){
			$nome_arquivo_final = "[".$_POST['titulo']."] ".$_FILES['arquivo']['name'];
		}

		# O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta.
		if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta_arquivo'] . $nome_arquivo_final)){

			$sql .= "arquivo_edital = '{$nome_arquivo_final}', ";
		}
		else{
			$_SESSION['erro'] = base64_encode(2);

			header("Location: {$end}eventos.php?e={$base64_id}");
		
			die();
		}
	}
}

$sql .= "submissao_projeto=$submissao, certificado=$certificado, regra=$regra WHERE id ='$id'";

if(mysqli_query($link, $sql)){
	if(isset($banner['banner']))
		if(file_exists($_UP['pasta_banner'] . $banner['banner'])){
			unlink($_UP['pasta_banner'].$banner['banner']);
		}
	if(isset($arq['arquivo_edital']))
		if(file_exists($_UP['pasta_arquivo'] . $arq['arquivo_edital'])){
			unlink($_UP['pasta_arquivo'].$arq['arquivo_edital']);
		}

	$_SESSION['success'] = base64_encode(2);

	header("Location: {$end}eventos.php?e={$base64_id}");

	die();
}
else{
	unlink($_UP['pasta_banner'] . $nome_banner_final);
	unlink($_UP['pasta_arquivo'] . $nome_arquivo_final);

	$_SESSION['erro'] = base64_encode(2);

	header("Location: {$end}eventos.php?e={$base64_id}");

	die();
}
?>