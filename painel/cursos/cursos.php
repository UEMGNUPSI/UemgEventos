<?php 

require_once("../utilitarios.php");

$titulo = "";

if(isset($_GET['c'])){
	$id 		= base64_decode(filter_input(INPUT_GET, "c", 
		  						FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_id 	= filter_input(INPUT_GET, "c", 
				  FILTER_SANITIZE_SPECIAL_CHARS);
				  
	if($dados = mysqli_fetch_array(mysqli_query(banco(), "SELECT titulo FROM cursos WHERE id = {$id}"))){		
		$titulo = $dados['titulo'];

		unset($dados);
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
			head("Novo Curso");
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
	navbar("cursos");

	if($id === -1){
		navTopEvento("<span class='icon glyphicon glyphicon-blackboard'></span> Novo Curso", "", "../cursos/");
	}
	else{
		navTopEvento("<span class='icon glyphicon glyphicon-blackboard'></span> {$titulo}", "", "../cursos/");
	}
	
	include_once("{$root}dialog.php");
	if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '1':
				dialog("success", "Novo curso salvo com sucesso!");
			break;
			case '2':
				dialog("success", "Curso atualizado com sucesso!");
			break;
			case '3':
				dialog("success", "Curso excluido com sucesso!");
			break;
		}
	}
	
	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '1':
				dialog("erro", "Não foi possível salvar este curso!<br />Tente novamente mais tarde.");
			break;
			case '2':
				dialog("erro", "Não foi possível atualizar este curso!<br />Tente novamente mais tarde.");
			break;
			case '3':
				dialog("erro", "Não foi possível excluir este curso! Pode ser que há usuários vinculados com este curso ou tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
			case '11':
				dialog("alert", "Título existente.<br />Tente outro título para o curso.");
			break;
		}
	}

	
?>
		<section class="corpo col-sm-11 col-md-10" style='min-height: 50vh;'>
			<form method="post" <?php if($id == -1){ echo "action='{$dao}novo/curso.php'";}else{ echo "action='{$dao}atualizar/curso.php?c={$base64_id}'";} ?> style='margin-top: 15px'>
				<div class="col-md-6">
					<div class="form-group">
						<label for="titulo">Título: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual o nome do curso disponível para usuários cadastrarem. Deve conter no máximo 30 (Trinta) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="text" id="titulo" maxlength="30" name="titulo" <?php echo "value='$titulo'" ?> class="form-control" required="true">
					</div>

					<button class="btn btn-success"><span class='icon glyphicon glyphicon-floppy-disk'></span> Salvar</button>				
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