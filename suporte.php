<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		$login = 1;
	}else{
		$login = 0;
	}

	if(isset($_GET['sucesso'])){
		$sucesso = $_GET['sucesso'];
	}
	else{
		$sucesso = 0;
	}

	if(isset($_GET['erro'])){
		$erro = $_GET['erro'];
	}
	else{
		$erro = 0;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php 
    require_once("head.php");
    head("UEMG Eventos");
  ?>
	

	<style type="text/css">
		.form-suport{
			border: 1px solid #ddd;
			border-radius: 2px;

			padding: 4px 12px;
		}
	</style>
</head>
<body>
	<?php 
		if($erro == 1){
	?>
  			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Erro ao tentar enviar a mensagem, tente novamente mais tarde!</strong>
			</div>
	<?php  
		}
		if($sucesso == 1){
	?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
			  <strong>Mensagem enviada com sucesso!</strong> 
			</div>
	<?php  
		}
		include('login.php');
		$navSuporte = "class='active'";
		require_once("nav.php");
	?>

	<div class="container">
		<div class="col-md-12 body-sub" style="padding: 30px 30px; margin-top: 40px;">
			<h2 style="margin-top: 0">Suporte</h2>
			<hr>
			<div class="col-md-12">
				
				<h4>Encontrou algum problema? Critica? Sugenstão?</h4>
				<p style="font-size: 18px">Então preencha o formulário abaixo!</p>
				<form method="post" action="enviar.php">
					<div class="form-group">
	                  <label for="nome">Nome:</label><br>
	                  <input class="form-suport" type="text" id="nome" name="nome" placeholder="Máx: 36 caracteres" maxlength="36" onkeypress="return char(event)">
	                </div>
	                <div class="form-group">
	                  <label for="email">Email:</label><br>
	                  <input class="form-suport" type="email" id="email" name="email" placeholder="Ex: exemplo@exemplo.com" required="true">
	                </div>
	                <div class="form-group">
	                  <label for="assunto">Assunto:</label><br>
	                  <input class="form-suport" type="text" id="assunto" name="assunto" placeholder="Máx: 45 caracteres" maxlength="45" required="true" required="true">
	                </div>
	                <div class="form-group">
	                  <label for="mensagem">Mensagem:</label><br>
	                  <textarea maxlength="600" class="form-suport" name="mensagem" id="mensagem" rows="5" placeholder="Caso tenha encontrado um erro, descreva-o com maior detalhes. E caso seja uma crítica ou sugestão também escreva aqui." required="true"></textarea>
	                </div>
	                <div class="form-group">
	                  <button class="btn btn-cadastrar">Enviar</button>
	                </div>
				</form>
			</div>
		</div>
			

		</div>
		
	</div>

	<script type="text/javascript">
		
		function char(e)
		{
			var expressao;

			expressao = /[a-zA-Z\s]/;

			if(expressao.test(String.fromCharCode(e.keyCode)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

	</script>
	<?php require_once("footer.php"); ?>
</body>

</html>