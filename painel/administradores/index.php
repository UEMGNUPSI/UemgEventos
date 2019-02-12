<?php 

require_once("../utilitarios.php");

if(intval(getId($_SESSION['user'])) !== 1){
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
		
		head("Administradores");
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
  require_once("../nav.php");
  navbar("administradores");

  navTop("<span class='icon glyphicon glyphicon-user'></span> Administradores");

  include_once("{$root}dialog.php");
	if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '1':
				dialog("success", "Novo administrador salvo com sucesso!");
			break;
			case '2':
				dialog("success", "Administrador atualizado com sucesso!");
			break;
			case '3':
				dialog("success", "Administrador excluido com sucesso!");
			break;
		}
	}
	
	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '1':
				dialog("erro", "Não foi possível salvar este administrador!<br />Tente novamente mais tarde.");
			break;
			case '2':
				dialog("erro", "Não foi possível atualizar este administrador!<br />Tente novamente mais tarde.");
			break;
			case '3':
				dialog("erro", "Não foi possível excluir este administrador!<br />Tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
			case '11':
				dialog("alert", "E-mail existente.<br />Tente outro e-mail para o administrador.");
			break;
		}
	}
?> 
	<section class="corpo col-sm-11 col-md-10">
			<section class="row top-admin">
				<section class="row">
					<div class="col-sm-7" style='margin-bottom: 2rem'>
						<label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar administrador</label>
						<input id='busca' type="search" name="busca" placeholder="Buscar por administrador..." class="form-control">
					</div>
					
					<div class='col-sm-5' style='margin-bottom: 2rem'>
						<label style='display: block'><span class='icon glyphicon glyphicon-cog'></span> Opção</label>

						<input type="radio" id="nome" name="status" value="nome" checked> <label for="nome"> Nome</label>
						
						<input type="radio" id="email" name="status" value="email" style="margin-left: 20px;"> <label for="email"> E-mail</label>
					</div>
				</section>
			</section>
			<section class="row" style='margin-top: 2rem;'>
			
				<div id='tblAdministradores' class='col-xs-12'></div>

				<a class="btn btn-primary btn-novo" href="administradores.php"><span class="icon glyphicon glyphicon-plus" style='left: .5px'></span></a>

				<div class='col-xs-12'>
					<?php require_once("../paginacao.php"); ?>
				</div>
			</section>
		</section>
	</section>
</main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script src='/public/js/tabela.js'></script>
<script>
	var url 	= "../tabela.php";
	var tabela 	= "Administradores";
	var pagina 	= $("#pagina").val();
	var status 	= $("input[type=radio]:checked").val();
	var texto = $("#busca").val();
	
	$(window).load(function(){
		atualizaTabelaStatus(url, tabela, status, texto, pagina);
		
		$("input[type=radio]").click(function(){
			texto = $("#busca").val();
			
			status = $("input[type=radio]:checked").val();

			atualizaTabelaStatus(url, tabela, status, texto, pagina);
			
		});
		
		$("#busca").keyup(function(){
			texto = $("#busca").val();

			atualizaTabelaStatus(url, tabela, status, texto, pagina);
		});
	});
</script>
</body>
</html>