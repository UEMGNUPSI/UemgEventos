<?php 

require_once("../utilitarios.php");

?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once("../head.php");
		
		head("Categorias");
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("categorias");

	navTop("<span class='icon glyphicon glyphicon-certificate'></span> Categorias");
	
	include_once("{$root}dialog.php");

	if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '1':
				dialog("success", "Nova categoria salva com sucesso!");
			break;
			case '2':
				dialog("success", "Categoria atualizada com sucesso!");
			break;
			case '3':
				dialog("success", "Categoria excluida com sucesso!");
			break;
		}
	}

	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '1':
				dialog("erro", "Não foi possível salvar esta categoria!<br />Tente novamente mais tarde.");
			break;
			case '2':
				dialog("erro", "Não foi possível atualizar esta categoria!<br />Tente novamente mais tarde.");
			break;
			case '3':
				dialog("erro", "Não foi possível excluir esta categoria! Pode ser que ainda esteja vinculada com alguma atividade ou tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
			case '11':
				dialog("alert", "Título existente.<br />Tente outro título para a categoria.");
			break;
		}
	}
?>
		<section class="corpo col-sm-11 col-md-10">
			<section class="row top-admin">
				<section class='row'>
					<div class="col-sm-7" style='margin-bottom: 2rem'>
						<label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar categorias</label>
						<input id='busca' class="form-control" type="search" name="busca" placeholder="Buscar por categorias..." />
					</div>
				</section>
			</section>
			<section class="row" style='margin-top: 2rem;'>
				<div id='tblCategorias' class='col-xs-12'></div>

				<a class="btn btn-primary btn-novo" href="categorias.php"><span class="icon glyphicon glyphicon-plus" style='left: .5px'></span></a>

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
	var tabela 	= "Categorias";
	var pagina 	= $("#pagina").val();
	var texto = $("#busca").val();

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