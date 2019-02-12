<?php 

require_once('index.php');

$end .= "eventos/";

# Validação ID Evento
	if(!isset($_GET['e'])){
		$_SESSION['erro'] = base64_encode(9);

		header("Location: {$end}");

		die();
	}

	$evento 		= 	base64_decode(filter_input(INPUT_GET, 'e',
						FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_evento 	=	filter_input(INPUT_GET, 'e',
						FILTER_SANITIZE_SPECIAL_CHARS);
# Fim Validação ID Evento

if(!validaAdm($_SESSION['user'], $evento)){
	# Admin não tem permissão apara editar a atividade.
	$_SESSION['erro'] = base64_encode(9);
	header("Location: {$end}eventos.php?e={$base64_evento}");

	die();
}

# Validação ID Atividades
	if(!isset($_GET['a'])){
		$_SESSION['erro'] = base64_encode(9);
		header("Location: {$end}eventos.php?e={$base64_evento}");

		die();
	}

	$id 		= 	base64_decode(filter_input(INPUT_GET, 'a', 
					FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_id 	= 	filter_input(INPUT_GET, 'a', 
					FILTER_SANITIZE_SPECIAL_CHARS);
# Fim Validação ID Atividades

$_UP['pasta'] = "{$root}uploads/img-atividades/";			# Pasta onde o arquivo vai ser salvo

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_POST['removerImg'])){
	$sql = "UPDATE atividades SET img = 'padrao.png' WHERE id = {$id}";

	if(mysqli_query($link, $sql)){
		unlink($_UP['pasta'].$_POST['removerImg']);

		$_SESSION['success'] = base64_encode(7);

		header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");
	}		
	else
		$_SESSION['erro'] = base64_encode(7);

		header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");
	
	die();
}

$titulo			    = 	  	htmlentities($_POST['titulo'], ENT_QUOTES);
$descricao			= 	  	htmlentities($_POST['descricao'], ENT_QUOTES);
$categoria			=	  	htmlentities($_POST['categoria'], ENT_QUOTES);
$vagas_disp			=		htmlentities($_POST['vagas_disp'], ENT_QUOTES);
$ministrante		= 	 	htmlentities($_POST['ministrante'], ENT_QUOTES);
$data_inicio		= 	  	htmlentities($_POST['data_inicio'], ENT_QUOTES);
$hora_inicio		= 	  	htmlentities($_POST['hora_inicio'], ENT_QUOTES);
$hora_fim			= 	  	htmlentities($_POST['hora_fim'], ENT_QUOTES);
$local_atividade 	= 	   	htmlentities($_POST['local_atividade'], ENT_QUOTES);

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM atividades WHERE titulo = '$titulo' AND id <> {$id}"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");

	die();
}

$sql = "UPDATE atividades SET titulo='$titulo',
		descricao='$descricao', vagas_total=$vagas_disp, vagas_disp=$vagas_disp, ministrante='$ministrante', data_inicio='$data_inicio', hora_inicio='$hora_inicio', hora_fim='$hora_fim', local_atividade='$local_atividade', "; 

if($_FILES['arquivo']['size'] > 0){

	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 2;		 // 2Mb

	// Array com as extensões permitidas
	$_UP['extensoes'] = array('png', 'jpg','jpeg');

	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['arquivo']['error'] != 0) {
		$_SESSION['erro'] = base64_encode(2);
		
		header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");

		die();
	}

	if($_FILES['arquivo']['error'] != 4){
		$ext_banner = substr(strstr($_FILES['arquivo']['type'], "/"), 1);
		if(array_search($ext_banner, $_UP['extensoes']) === false){
			$_SESSION['erro'] = base64_encode(3);

			header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");
			
			die();
		}
	}

	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
		$_SESSION['erro'] = base64_encode(4);
		header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");
			
		die();
	}

	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	// Renomeia o arquivo

	$nome_banner_final = $_FILES['arquivo']['name'];

	$nome_banner_final = md5(htmlentities($nome_banner_final, ENT_QUOTES)).'.'.$ext_banner;

	$banner = mysqli_fetch_array(mysqli_query($link, "SELECT img FROM atividades WHERE id = {$id} AND img <> 'padrao.png'"));

	while(file_exists($_UP['pasta'] . $nome_banner_final)){
		$nome_banner_final = md5(htmlentities($_FILES['arquivo']['name'], ENT_QUOTES).rand(1,9999)).'.'.$ext_banner;
	}

	# O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta.
	if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_banner_final)){

		if($ext_banner === "png")
			$src = imagecreatefrompng($_UP['pasta'].$nome_banner_final);

		if($ext_banner === "jpg" || $ext_banner === "jpeg")
			$src = imagecreatefromjpeg($_UP['pasta'].$nome_banner_final);

		list($width, $height) = getimagesize($_UP['pasta'].$nome_banner_final);

		$dst = imagecreatetruecolor(180, 180);

		imagecopyresampled($dst, $src, 0, 0, 0, 0, 180, 180, $width, $height);

		if($ext_banner === "png")
			imagepng($dst, $_UP['pasta'].$nome_banner_final);

		if($ext_banner === "jpg" || $ext_banner === "jpeg")
			imagejpeg($dst, $_UP['pasta'].$nome_banner_final);

		$sql .= "img='$nome_banner_final', ";
	}
	else{
		$_SESSION['erro'] = base64_encode(2);

		die($sql);

		header("Location: {$end}atividade.php?&e={$base64_evento}&a={$base64_id}");
	
		die();
	}
}

$sql .= "id_categoria = $categoria, id_evento = {$evento} WHERE id = {$id}";

if(mysqli_query($link, $sql)){
	mysqli_close($link);
	if(isset($banner['img']))
		if(file_exists($_UP['pasta'] . $banner['img']))
			unlink($_UP['pasta'].$banner['img']);
		
	$_SESSION['success'] = base64_encode(2);

	header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");

	die();
}
else{
	unlink($_UP['pasta'] . $nome_banner_final);
	mysqli_close($link);
	
	$_SESSION['erro'] = base64_encode(2);

	header("Location: {$end}atividade.php?e={$base64_evento}&a={$base64_id}");

	die();
}
?>