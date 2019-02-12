<?php 

require_once("../utilitarios.php");

?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once("../head.php");
		
		head("Locais");
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("locais");

	navTop("<span class='icon glyphicon glyphicon-home'></span> Locais");
	
	include_once("{$root}dialog.php");

	if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '1':
				dialog("success", "Novo local salvo com sucesso!");
			break;
			case '2':
				dialog("success", "Local atualizado com sucesso!");
			break;
			case '3':
				dialog("success", "Local excluido com sucesso!");
			break;
		}
	}

	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '1':
				dialog("success", "Não foi possível salvar um novo local!<br /> Tente novamente mais tarde.");
			break;
			case '2':
				dialog("erro", "Não foi possível atualizar este local!<br />Tente novamente mais tarde.");
			break;
			case '3':
				dialog("erro", "Não foi possível excluir este local! Pode ser que há eventos vinculados com este local ou tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
		}
	}
?>
		<section class="corpo col-sm-11 col-md-10">
			<section class="row top-admin">
				<form method="post" action="../">
					<section class='row'>
						<div class="col-sm-7" style='margin-bottom: 2rem'>
							<label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar local</label>
							<input id='busca' class="form-control" type="search" name="busca" placeholder="Buscar por locais..." />
						</div>
					</section>
				</form>
			</section>
			<section class="row" style='margin-top: 2rem;'>
				<a class="btn btn-primary btn-novo" href="locais.php"><span class="icon glyphicon glyphicon-plus" style='left: .5px'></span></a>

				<div id='tblLocais' class='col-xs-12'></div>

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
	var tabela 	= "Locais";
	var pagina 	= $("#pagina").val();
	var texto 	= $("#busca").val();

	$(window).load(function(){

		atualizaTabela(url, tabela, texto, pagina);

		$("#busca").keyup(function(){
			texto = $("#busca").val();

			atualizaTabela(url, tabela, texto, pagina);
		});
	});
</script>
</body>
</html>