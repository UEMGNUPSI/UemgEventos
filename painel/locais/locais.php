<?php 

require_once("../utilitarios.php");

$local = "";

if(isset($_GET['l'])){
	$id 		= base64_decode(filter_input(INPUT_GET, "l", 
								FILTER_SANITIZE_SPECIAL_CHARS));

	$base64_id 	= filter_input(INPUT_GET, "l", 
							   FILTER_SANITIZE_SPECIAL_CHARS);

	if($dados = mysqli_fetch_array(mysqli_query(banco(), "SELECT local FROM locais WHERE id = {$id} "))){
		
		$local = $dados['local'];
		
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
			head("Novo Local");
		}
		else{
			head("{$local}");
		}
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
	require_once("../nav.php");
	navbar("locais");

	if($id === -1){
		navTopEvento("<span class='icon glyphicon glyphicon-home'></span> Novo Local", "", "../locais/");
	}
	else{
		navTopEvento("<span class='icon glyphicon glyphicon-home'></span> {$local}", "", "../locais/");
	}
	
	include_once("{$root}dialog.php");

	switch(isset($_SESSION['success']) && base64_decode($_SESSION['success'])){
		case '2':
		dialog("success", "Local atualizado com sucesso!");
		break;
	}

	switch(isset($_SESSION['erro']) && base64_decode($_SESSION['erro'])){
		case '2':
		dialog("erro", "Não foi possível atualizar este local!<br />Tente novamente mais tarde.");
		break;
		case '9':
		dialog("alert", "Você não tem permissão para acessar essa página!");
		break;
		case '11':
		dialog("alert", "Local existente.<br />Tente outro título para o local.");
		break;
	}
?>
		<section class="corpo col-sm-11 col-md-10" style='min-height: 50vh;'>
		
			<form method="post" <?php if($id == -1){ echo "action='{$dao}novo/local.php'";}else{ echo "action='{$dao}atualizar/local.php?l={$base64_id}'";} ?> style='margin-top: 15px'>
				<div class="col-md-6">					
					<div class="form-group">
						<label for="titulo"><span class='icon glyphicon glyphicon-home'></span> Local: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual o nome do local onde será realizado um evento. Deve conter no máximo 45 (Quarenta e Cinco) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="text" id="titulo" maxlength="45" name="titulo" <?php echo "value='$local'" ?> class="form-control" required="true">
					</div>
					<div class="col-md-12 text-center">
						<button class="btn btn-success text-center" style='width: 50%'><span class='icon glyphicon glyphicon-floppy-disk'></span> Salvar</button>
					</div>								
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