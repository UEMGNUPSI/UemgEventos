<?php 

require_once("../utilitarios.php");

$titulo = "";

if(isset($_GET['c'])){

	$id 		= base64_decode(filter_input(INPUT_GET, "c", 
								FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_id 	= filter_input(INPUT_GET, "c", 
				  FILTER_SANITIZE_SPECIAL_CHARS);
	
	if($resultado_id = mysqli_query(banco(), "SELECT titulo FROM categorias WHERE id = {$id} ")){
		$dados = mysqli_fetch_array($resultado_id);

		if(isset($dados['titulo'])){
			$titulo = $dados['titulo'];
		}

		unset($dados);

		mysqli_close(banco());
	}

}else{
	$id = -1;
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once("../head.php");
		
		if($id === -1){
			head("Nova Categoria");
		}
		else{
			head("{$titulo}");
		}
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("categorias");

  	if($id === -1){
		navTopEvento("<span class='icon glyphicon glyphicon-certificate'></span> Nova Categoria", "", "../categorias/");
	}
	else{
		navTopEvento("<span class='icon glyphicon glyphicon-certificate'></span> {$titulo}", "", "../categorias/");
	}

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
		<section class="corpo col-sm-11 col-md-10" style='min-height: 50vh'>
			
			<form method="post" <?php if($id == -1){ echo "action='{$dao}novo/categoria.php'";}else{ echo "action='{$dao}atualizar/categoria.php?c={$base64_id}'";} ?> style='margin-top: 15px'>
				<div class="col-md-6">				
					<div class="form-group">
						<label for="titulo">Título: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual o nome da categoria que se encaixa para uma determinada atividade. Deve conter no máximo 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="text" id="titulo" name="titulo" maxlength="36" <?php echo "value='$titulo'" ?> class="form-control" required="true">
					</div>

					<button class="btn btn-success"><span class='glyphicon glyphicon-floppy-disk' style='padding-right: 2px'></span> Salvar</button>
					
				</div>
			</form>
		</section>
	</section>
</main>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script>
	window.addEventListener("load",function(){
		$(function () {
			$('[data-toggle="popover"]').popover()
		});
	});
</script>
</body>
</html>