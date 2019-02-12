<?php 
	require_once("../utilitarios.php");

	if(intval(getId($_SESSION['user'])) !== 1){
		$_SESSION['erro'] = base64_encode(9);
		header("Location: ../");

		die();
	}

	if(isset($_GET['s'])){
		$id = base64_decode(filter_input(INPUT_GET, 's', FILTER_SANITIZE_SPECIAL_CHARS));

		$res = mysqli_query(banco(), "SELECT * FROM suporte WHERE id = $id");

		$sup = mysqli_fetch_array($res, MYSQLI_ASSOC);

	}
	else{
		$_SESSION['erro'] = base64_encode(9);
		header("Location: ../");

		die();
	}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<?php
		require_once("../head.php");

		head("{$sup['nome']}");
  	?>

  	<style type="text/css">
  		.div-mensagem{
  			background: #f7f7f7;
  			margin: 30px 0;

  			padding: 12px 20px;

  			border: 1px solid #ddd;
  			border-radius: 4px;
  		}
  	</style>
 </head>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("nupsi");

	navTopEvento("<span class='icon glyphicon glyphicon-comment'></span> NUPSI", "", "../nupsi/");
	
	include_once("{$root}dialog.php");

	switch(isset($_SESSION['success']) && base64_decode($_SESSION['success'])){
		case '2':
		dialog("success", "Administrador atualizado com sucesso!");
		break;
	}

	switch(isset($_SESSION['erro']) && base64_decode($_SESSION['erro'])){
		case '2':
		dialog("erro", "Não foi possível atualizar este administrador!<br />Tente novamente mais tarde.");
		break;
		case '9':
		dialog("alert", "Você não tem permissão para acessar essa página!");
		break;
		case '11':
		dialog("alert", "E-mail existente.<br />Tente outro e-mail para o administrador.");
		break;
	}
?>
		<section class="corpo col-sm-11 col-md-10">
			<section class="row top-admin" style='padding-bottom: 15px'>
				<h4>Mensagens do Usuário</h4>
			</section>
			<?php if(empty($sup['nome'])){ ?>
			<div class="col-md-12">
				<?php echo "<h4>E-mail: ".$sup['email']."</h4>";  ?>
			</div>
			<?php }else{ ?>
			<div class="col-md-6">
				<?php echo "<h4>Nome: ".$sup['nome']."</h4>";  ?>
			</div>
			<div class="col-md-6">
				<?php echo "<h4>E-mail: ".$sup['email']."</h4>";  ?>
			</div>
			<?php }
				echo "<div class='col-md-12'> <h4>Assunto: ".$sup['assunto']."</h4>"; 
				echo "<div class='div-mensagem'><h4>".$sup['mensagem']."</h4></div></div>"; 
			?>
		</section>
	</section>
</main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>
	
 </body>
 </html>