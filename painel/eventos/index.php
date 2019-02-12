<?php 

require_once("../utilitarios.php");

$status = isset($_POST['status']) ? filter_input(INPUT_POST, 'status', 
FILTER_SANITIZE_SPECIAL_CHARS) : "Ativo";

?>

<!DOCTYPE html>
<html>
<head>
	<?php 
		require_once("../head.php");
		head("Eventos");
	?>	
</head>
<body>
	<main class="container-fluid">
		<section class='row'>
		
			<?php 

				require_once("../nav.php");
				navbar("eventos");

				navTop("<span class='icon glyphicon glyphicon-flag'></span> Eventos");

				include_once("{$root}dialog.php");
				if(isset($_SESSION['success'])){
					switch(base64_decode($_SESSION['success'])){
						case '1':
							dialog("success", "Evento salvo com sucesso!");
						break;
						case '3':
							dialog("success", "Evento excluido com sucesso!");
						break;
					}
				}

				if(isset($_SESSION['erro'])){
					switch(base64_decode($_SESSION['erro'])){
						case '3':
							dialog("erro", "Não foi possível excluir este evento! Pode ser que ainda há atividades cadastradas ou tente novamente mais tarde.");
						break;
						case '9':
							dialog("alert", "Você não tem permissão para acessar essa página!");
						break;
					}
				}
  			?>
	
			<section class="corpo col-sm-11 col-md-10">
				<section class="row top-admin">
					<section class="row">
						<div class="col-sm-7" style='margin-bottom: 2rem'>
							<label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar evento</label>
							<input id='busca' type="search" name="busca" placeholder="Buscar por eventos..." class="form-control">
						</div>
						
						<div class='col-sm-5' style='margin-bottom: 2rem'>
							<label style='display: block'><span class='icon glyphicon glyphicon-cog'></span> Opção</label>

							<input type="radio" id="ativo" name="status" value="Ativo" checked> <label for="ativo">Ativo</label>
							
							<input type="radio" id="desativado" name="status" value="Desativado" style="margin-left: 20px;"> <label for="desativado"> Desativado</label>
						</div>
					</section>
				</section>
				<section class="row" style='margin-top: 2rem;'>
					<a class="btn btn-primary btn-novo" href="eventos.php"><span class="icon glyphicon glyphicon-plus" style='left: .5px'></span></a>

					<div id='tblEventos' class='col-xs-12'></div>
					
					<div class='col-xs-12'>
						<?php require_once("../paginacao.php"); ?>
					</div>				
				</section>
			</section>
		</section>
	</main>

<?php require_once("../scripts.php"); ?>

<script src='/public/js/tabela.js'></script>
<script>
	var url 	= "../tabela.php";
	var tabela 	= "Eventos";
	var pagina 	= $("#pagina").val();
	var status 	= $("input[type=radio]:checked").val();
	var texto 	= $("#busca").val();

	$(window).load(function(){
		atualizaTabelaStatus(url, tabela, status, texto, pagina);

		$("#busca").keyup(function(){
			var texto = $("#busca").val();

			atualizaTabelaStatus(url, tabela, status, texto, pagina);
		});

		$("input[type=radio]").click(function(){
			
			status = $("input[type=radio]:checked").val();

			texto = $("#busca").val();

			atualizaTabelaStatus(url, tabela, status, texto, pagina);
			
		});
	});
</script>
</body>
</html>