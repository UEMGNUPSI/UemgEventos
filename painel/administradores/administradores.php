<?php 

require_once("../utilitarios.php");

if(intval(getId($_SESSION['user'])) !== 1){
	$_SESSION['erro'] = base64_encode(9);

	header("Location: ../");
	die();
}

$email = "";
$senha = "";
$nome = "";

if(isset($_GET['a'])){
	$id = base64_decode(filter_input(INPUT_GET, "a", 
											FILTER_SANITIZE_SPECIAL_CHARS));

	$sql = "SELECT nome, email, senha FROM usuarios WHERE id = {$id} ";
	
	if($resultado_id = mysqli_query(banco(), $sql)){
		mysqli_close(banco());

		$dados = mysqli_fetch_array($resultado_id);
		if(isset($dados['email'])){
			$email = $dados['email'];
			$senha = 0;
			$nome = $dados['nome'];
		}
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
			
		if($id === -1)
			head("Novo Administrador");
		else
			head("Administrador");
  	?>
</head>
<body>
<main class='container-fluid'>
    <section class="row">
<?php
  require_once("../nav.php");
  navbar("administradores");

  if($id === -1){
		navTopEvento("<span class='icon glyphicon glyphicon-user'></span> Novo Administrador", "", "../administradores/");
	}
	else{
		navTopEvento("<span class='icon glyphicon glyphicon-user'></span> {$nome}", "", "../administradores/");
	}

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
		<section class="corpo col-sm-11 col-md-10" style="min-height: 70vh">
			<form method="post" <?php if($id == -1){ echo "action='{$dao}novo/adm.php'";}else{ echo "action='{$dao}atualizar/adm.php?a=".base64_encode($id)."'";} ?> style="margin-top: 15px">
				<div class="col-md-6">				
					<div class="form-group">
						<label for="nome">Nome: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual o nome do administrador. Deve conter no máximo 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="text" id="nome" name="nome" maxlength="36" <?php echo "value='$nome'" ?> class="form-control" required="true">
					</div>
					<div class="form-group">
						<label for="email">E-Mail: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual o email do administrador, este será utilizado para entrar no sistema."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="email" id="email" name="email" <?php echo "value='$email'" ?> placeholder="" class="form-control" required="true">
					</div>
					<div class="form-group">
						<label for="senha">Senha: </label>

						<a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual a senha do administrador, este será utilizado para entrar no sistema. Deve conter no mínimo 5 (Cinco) caracteres e no máximo 20 (Vinte) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

						<input type="password" id="senha" name="senha" minlength="5" maxlength="20" placeholder="De 5 a 20 caracteres" class="form-control" <?php if($senha != 0){ echo "required='true'";} ?> pattern=".{5,20}" >
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