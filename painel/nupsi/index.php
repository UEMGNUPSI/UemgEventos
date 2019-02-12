<?php 

require_once("../utilitarios.php");

if(intval(getId($_SESSION['user'])) !== 1){
	$_SESSION['erro'] = base64_encode(9);
	header("Location: ../");

	die();
}

if(isset($_GET['apagar'])){
    $men = $_GET['apagar'];
    
    $sql = "DELETE FROM suporte WHERE id = $men";
    
    if(mysqli_query($link, $sql)){
    	header("Location: nupsi.php?sucesso=3");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once("../head.php");

		head("NUPSI");
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("nupsi");

	navTop("<span class='icon glyphicon glyphicon-comment'></span> NUPSI");
	
	include_once("{$root}dialog.php");

	if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '3':
				dialog("success", "Mensagem excluida com sucesso!");
			break;
		}	
	}
	
	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '3':
				dialog("erro", "Não foi possível excluir esta mensagem!<br />Tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
		}
	}	
?>
		<section class="corpo col-sm-11 col-md-10">
			<section class="row top-admin">
				<section class='row'>
					<div class="col-sm-7" style='margin-bottom: 2rem'>
						<label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar mensagens</label>
						<input id='busca' class="form-control" type="search" name="busca" placeholder="Buscar por assuntos..." />
					</div>
				</section>
			</section>
			<section class="row" style='margin-top: 2rem;'>
			
				<div id='tblSuporte' class='col-xs-12'></div>
				
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
	var tabela 	= "Suporte";
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