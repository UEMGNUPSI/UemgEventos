<?php 

	require_once("../utilitarios.php");

	if(isset($_SESSION["e"]) && isset($_SESSION["a"])){
		$evento         = base64_decode($_SESSION["e"]);
		$base64_evento  = $_SESSION["e"];

		$id         		= base64_decode($_SESSION["a"]);
		$base64_id  		= $_SESSION["a"];

		if(!validaAdm($_SESSION['user'], $evento)){
			$_SESSION['erro'] = base64_encode(9);
			header("Location: ../eventos/");
			
			die();
		}

		if($result_evento = mysqli_query(banco(), "SELECT titulo FROM eventos WHERE id = $evento")){
	
			$dados = mysqli_fetch_array($result_evento);
			
			$titulo_evento = $dados['titulo'];
		
			unset($dados);
	
		}

		if($resultado_id = mysqli_query(banco(), "SELECT titulo FROM atividades WHERE id = $id")){
		  $dados = mysqli_fetch_array($resultado_id);
		
		  $atividade['titulo'] = $dados['titulo'];
	  
		  unset($dados);
		}

	}

	// Evento!
	if(isset($_GET['e'])){

		$evento         = base64_decode(filter_input(INPUT_GET, 'e', 
											FILTER_SANITIZE_SPECIAL_CHARS));
		$base64_evento  = filter_input(INPUT_GET, 'e', 
											FILTER_SANITIZE_SPECIAL_CHARS);
	
		if(!validaAdm($_SESSION['user'], $evento)){
			$_SESSION['erro'] = base64_encode(9);
			header("Location: ../eventos/");
			
			die();
		}
	
		if($result_evento = mysqli_query(banco(), "SELECT titulo FROM eventos WHERE id = $evento")){
	
			$dados = mysqli_fetch_array($result_evento);
			
			$titulo_evento = $dados['titulo'];
		
			unset($dados);
	
		}

		$_SESSION['e'] = $base64_evento;
  
	}

	if(isset($_GET['a'])){
		$id         = base64_decode(filter_input(INPUT_GET, 'a', 
					  			FILTER_SANITIZE_SPECIAL_CHARS));
		$base64_id  = filter_input(INPUT_GET, 'a', 
									FILTER_SANITIZE_SPECIAL_CHARS);
	  
		if($resultado_id = mysqli_query(banco(), "SELECT titulo FROM atividades WHERE id = $id")){
		  $dados = mysqli_fetch_array($resultado_id);
		
		  $atividade['titulo'] = $dados['titulo'];
	  
		  unset($dados);
		}

		$_SESSION['a'] = $base64_id;
	}

	mysqli_close(banco());
?>
	

<!DOCTYPE html>
<html>
<head>
	<?php
		require_once("../head.php");
			
		head("Presença - ".$atividade['titulo']);
	?>
<body>
<main class='container-fluid' style="overflow: hidden">
  <section class="row">
<?php
  require_once("../nav.php");
  navbar("eventos");

	navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$titulo_evento}", "atividade", "../eventos/atividade.php?e={$base64_evento}&a={$base64_id}");
	
  include_once("{$root}dialog.php");
  if(isset($_SESSION['success'])){
		$user = base64_decode($_SESSION['u']);
		unset($_SESSION['u']);
	
		dialog("success", "Presença marcada com sucesso para o participante: <b>{$user}</b>!");
  }

  if(isset($_SESSION['erro'])){
    switch(base64_decode($_SESSION['erro'])){
      case "1":
        dialog("erro", "Não foi possível realizar a leitura, tente novamente ou tente preencher manualmente.");
      break;
      case "2":
        dialog("erro", "Usuário não encontrado no sistema, tente novamente ou tente preencher manualmente.");
      break;
	  default:
				$user = base64_decode($_SESSION['erro']);

        dialog("alert", "<b>{$user}</b> não está inscrito na atividade!");
      break;
    }
  }
?>
		<section class="corpo col-sm-11 col-md-10">
			<?php navTopEventoMobile("atividade"); ?>
			<section class="row top-admin">
				<section class="row">
				<div class="col-sm-7" style='margin-bottom: 2rem'>
					<h4><?php echo $atividade['titulo']; ?></h4>
				</div>
				</section>
			</section>
			<section class="row">
				<div class="col-xs-12">
					<?php echo "<a class='btn btn-info leitor' href='http://zxing.appspot.com/scan?ret=http://192.168.100.6/public/dao/adm/atualizar/presenca.php?codigo={CODE}' target='_self'><span style='position: relative; top: 4px' class='glyphicon glyphicon-qrcode'></span> Ler QR Code</a>"; ?>
				</div>
				<div class="col-md-12" style="margin-top: 3rem">
					<div class="row">
						<div class="col-md-10">
							<p>CPF não encontrado? Então digite manualmente abaixo!</p>
						</div>					
					</div>
					<form method="post" action="/public/dao/adm/atualizar/presenca.php">
						<div class="col-lg-5">
							<label for="codigo" style="margin-top: 1rem">Digite o CPF</label>
							<input id="codigo" class="form-control cpf" type="text" name="codigo" placeholder="Digite apenas números"  required />
						</div>
						<div class="col-lg-2" style="margin-top: 35px" align="center">
							<button class="btn btn-success btn-marcar"><span class="glyphicon glyphicon-ok" style="padding-right: 2px"></span> Marcar Presenca</button>
						</div>
					</form>		
				</div>
			</section>	
		</section>
	</section>
</main>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<script src="/public/frameworks/jquery mask/jquery.mask.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

	<script>
		$(document).ready(function(){
			$('#codigo').mask('000.000.000-00', {reverse: true});
		});
	</script>

</body>
</html>

