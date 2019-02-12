<?php 

	session_start();

	require_once('../bd.class.php');

	if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
		header("Location: ../index.php");
	}

	$sucesso = 0;

	$objBd = new bd();
	$link = $objBd->conecta_mysql();


	if(isset($_GET['codigo'])){
		$ra = $_GET['codigo'];

		$ra1 = strstr($ra, '-', true);

		$ra2 = substr(strstr($ra, '-'), 1);

		$ra = $ra1.$ra2;
		
		$sql ="SELECT * FROM usuarios WHERE ra = $ra";

		if($result_user = mysqli_query($link, $sql)){

			$user = mysqli_fetch_array($result_user);

			$sql = "UPDATE usuario_atividade ua INNER JOIN usuarios u ON u.id = ua.usuario INNER JOIN atividades a ON ua.atividade = a.id SET ua.presenca = 1 WHERE ua.atividade = ".$_SESSION['atividade']." AND u.ra = $ra";

			if(mysqli_query($link, $sql)){
				$sucesso = 1;
			}
			else{
				$sucesso = 3;
			}
		}
		else{
			$sucesso = 2;
		}
	}
	
	echo $sql;	

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<title>Presença</title>
    
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 align="center" style="font-size: 7rem !important;">Leitor de código de barras</h1>
				</div>
				
			</div>
		</div>
		<div class="col-lg-12">
			<a class='btn btn-danger btn-voltar' style="font-size: 5rem !important;" <?php echo "href='atividade.php?id=".$_SESSION['atividade']."&ide=".$_SESSION['evento']."'" ?> role='button'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true' style='padding-right: 9px'></span>Voltar</a>
		</div>
		<div class="container">
			<div class="row" align="center">
				<a class="btn btn-info btn-leitor" href="http://zxing.appspot.com/scan?ret=http://uemgeventos-br.umbler.net/painel/presenca_mobile.php?codigo={CODE}"><span class="glyphicon glyphicon-barcode" style="position: relative; top: 1rem;"></span> Leitor</a>
			</div>
		</div>
    

    <?php if($sucesso == 1){ ?>
    	<div class="alert alert-success" role="alert" style="margin: 12rem 1rem;">
        <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
        <strong style="text-align: center !important;">Presença cadastrada com sucesso!</strong> 
      </div>
      <div class="container" style="margin: 8rem 1rem;">
      	<div class="row" style="text-align: center;">
      		<h2>Participante: <?php echo $user['nome'] ?></h2>
      	</div>
      </div>
    <?php } ?>
    <?php if($sucesso == 2){ ?>
    	<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
        <strong>Usuário não encontrado! Por favor marque a presença manualmente.</strong> 
      </div>

      <div class="container">
      	<div class="row">
      		<form action="presenca_mobile.php" method="post">
      			<label for="nome">Nome:</label>
      			<input type="text" name="nome" placeholder="Preencha com o nome do participante!">
      			<button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Marcar</button>
      		</form>
      	</div>
      </div>
    <?php } ?>

    <?php if($sucesso == 3){ ?>
    	<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
        <strong>Não foi possível conectar com o banco, tente novamente mais tarde!</strong> 
      </div>
    <?php } ?>
      
</body>
</html>