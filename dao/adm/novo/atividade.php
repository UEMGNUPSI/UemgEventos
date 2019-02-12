<?php 

require_once('index.php');

$end .= "eventos/";

# Validação ID Evento
	if(!isset($_GET['e'])){
		
		$_SESSION['erro'] = base64_encode(9);

		header("Location: {$end}");

		die();
	}

	$evento 		= 	base64_decode(filter_input(INPUT_GET, 
						'e', FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_evento 	=	filter_input(INPUT_GET, 
						'e', FILTER_SANITIZE_SPECIAL_CHARS);
# Fim Validação ID Evento

if(!validaAdm($_SESSION['user'], $evento)){
	# Admin não tem permissão apara editar a atividade.
	$_SESSION['erro'] = base64_encode(9);
	header("Location: {$end}evento.php?e={$base64_evento}");

	die();
}

$titulo				=	htmlentities($_POST['titulo'], ENT_QUOTES);
$descricao			=	htmlentities($_POST['descricao'], ENT_QUOTES);
$categoria			=	htmlentities($_POST['categoria'], ENT_QUOTES);
$vagas_disp			=	htmlentities($_POST['vagas_disp'], ENT_QUOTES);
$ministrante		=	htmlentities($_POST['ministrante'], ENT_QUOTES);
$data_inicio		=	htmlentities($_POST['data_inicio'], ENT_QUOTES);
$hora_inicio		=	htmlentities($_POST['hora_inicio'], ENT_QUOTES);
$hora_fim			=	htmlentities($_POST['hora_fim'], ENT_QUOTES);
$local_atividade	=	htmlentities($_POST['local_atividade'], ENT_QUOTES);

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(mysqli_num_rows(mysqli_query($link, "SELECT titulo FROM atividades WHERE titulo = '$titulo'"))){
	mysqli_close($link);

	$_SESSION['erro'] = base64_encode(11);

	header("Location: {$end}atividade.php?e={$base64_evento}");

	die();
}

$sql = "INSERT INTO atividades
		(titulo, descricao, vagas_total, vagas_disp, 
		 ministrante, data_inicio, hora_inicio, hora_fim, 
		 local_atividade, img, id_categoria, id_evento) 
		VALUES 
		('{$titulo}', '{$descricao}', {$vagas_disp}, {$vagas_disp}, 
		'{$ministrante}', '{$data_inicio}', '{$hora_inicio}', '{$hora_fim}', 
		'{$local_atividade}', "; 

if($_FILES['arquivo']['size'] > 0){
	// Pasta onde o arquivo vai ser salvo
	$_UP['pasta'] = "{$root}uploads/img-atividades/";

	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 2; 			// 2Mb

	// Array com as extensões permitidas
	$_UP['extensoes'] = array('png', 'jpg', 'jpeg');

	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
	$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['arquivo']['error'] != 0) {
		header("Location: {$end}atividade.php?erro=".base64_encode(2)."&e={$base64_evento}");
		die();
	}

	if($_FILES['arquivo']['error'] != 4){
		$ext_banner = substr(strstr($_FILES['arquivo']['type'], "/"), 1);
		if(array_search($ext_banner, $_UP['extensoes']) === false){
			$_SESSION['erro'] = base64_encode(3);

			header("Location: {$end}atividade.php?e={$base64_evento}");
			
			die();
		}
	}

	// Faz a verificação do tamanho do arquivo
	if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
		$_SESSION['erro'] = base64_encode(4);

		header("Location: {$end}atividade.php?e={$base64_evento}");
			
		die();
	}

	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	// Renomeia o arquivo

	$nome_banner_final = $_FILES['arquivo']['name'];

	$nome_banner_final = md5(htmlentities($nome_banner_final, ENT_QUOTES)).'.'.$ext_banner;

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

		$sql .= "'$nome_banner_final', ";
	}
	else{
		$_SESSION['erro'] = base64_encode(2);

		header("Location: {$end}atividade.php?e={$base64_evento}");
	
		die();
	}

}
else{
	$sql .= "'padrao.png', ";
}

$sql .= "$categoria, $evento)";



if(mysqli_query($link, $sql)){
	$last_id = mysqli_fetch_array(mysqli_query($link, "SELECT id FROM atividades WHERE id_evento = $evento ORDER BY id DESC"));

	$_SESSION['success'] = base64_encode(1);

	header("Location: {$end}atividade.php?e={$base64_evento}&a=".base64_encode($last_id['id']));

	die();
}
else{
	unlink($_UP['pasta'] . $nome_banner_final);

	$_SESSION['erro'] = base64_encode(1);

	header("Location: {$end}atividade.php?e={$base64_evento}");

	die();
}

?>