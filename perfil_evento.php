<?php 

	session_start();
	
	require_once('config.php');

	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

	require_once('dao/bd.php');
	

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	if(isset($_GET['q'])){
		$id = htmlentities(base64_decode($_GET['q']));

		$pagina = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;

        $registros = 7;
		 
		unset($_GET['q']);

		# Inicio SQL Evento.
			$sql = "SELECT e.*, l.local local FROM eventos e INNER JOIN locais l ON e.id_local = l.id WHERE e.id = {$id}";

			$eventos = mysqli_query($link, $sql);

			if(mysqli_num_rows($eventos))
				$evento = mysqli_fetch_array($eventos, MYSQLI_ASSOC);
			else
				header("Location: eventos.php?erro=1");
		# Fim SQL Evento. 

		# Inicio SQL Atividades.
			$sql = "SELECT id, titulo, vagas_disp FROM atividades WHERE id_evento = {$id}";
				
			$total = mysqli_num_rows(mysqli_query($link, $sql));

			$numPaginas = ceil($total/$registros);

			$inicio = ($registros*$pagina)-$registros;

			$sql .= " LIMIT $inicio, $registros";

			$rows = mysqli_num_rows(mysqli_query($link, $sql));
		# Fim SQL Atividades.

		unset($sql);
	}

	# Início Tratando datas.
		// $semana_inicio = strftime("%A", strtotime($evento['data_inicio']));
		$dia_inicio = strftime("%A (%d/%b)", strtotime($evento['data_inicio']));
		
		// $semana_fim = strftime("%A", strtotime($evento['data_fim']));
		$dia_fim = strftime("%A (%d/%b)", strtotime($evento['data_fim']));
	# Fim Tratando datas.

	function tabelaAtividades($atv){
			echo "<tr>";
				echo "<td>";
					echo $atv['titulo'];
				echo "</td>";
				echo "<td align='center'>";
					echo $atv['vagas_disp'];
				echo "</td>";
			echo "</tr>";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php 
		require_once("head.php");
		head("UEMG Eventos");
  	?>
	
	<script src="dialogScript.js"></script>
</head>
<body>

<?php

	include('login.php');
	include('dialog.php');

	$navEvento = "class='active'";
	require_once("nav.php");

  ?>

	<main class="container">
		<section class="col-xs-12 evento-perfil">
			<figure class="row">
				<img class="img-evento" <?php echo "src=uploads/img-eventos/{$evento['banner']}"; ?>>
			</figure>
			<header class="row titulo">
				<h3 style='margin: 0;'><?php echo $evento['titulo']; ?></h3>
			</header>
			<section class='row'>
				<div class="col-md-12">
					<p><?php echo $evento['descricao']; ?></p>
				</div>
			</section>
			<section class='row'>
				<div class="col-md-6">
					<div class="item-info">
						<p class="item-label text-red"><span class='glyphicon glyphicon-calendar'	></span> Data</p>
						<p style="text-transform: capitalize"><?php echo "{$dia_inicio} <span style='text-transform: lowercase;'>até</span> {$dia_fim}" ; ?></p>
					</div>
					<div class="item-info">
						<p class="item-label text-red"><span class='glyphicon glyphicon-map-marker'></span> Local</p>
						<p><?php echo $evento['local']; ?></p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="item-info">
						<p class="item-label text-red"><span class='glyphicon glyphicon-user'></span> Responsável</p>
						<p><?php echo $evento['organizador']; ?></p>
					</div>
				</div>
			</section>
			<?php 
				
				if($evento['valor']){

					if(isset($_SESSION['user'])){
						$sql_pago = "SELECT ep.pagamento pag FROM usuarios u 
											   INNER JOIN evento_pago ep ON u.id = ep.usuario 
											   INNER JOIN eventos e ON ep.evento = e.id 
											   WHERE u.email = '{$_SESSION['user']}' 
											   AND e.id = {$id}";
	
						$pago = mysqli_fetch_array(mysqli_query($link, $sql_pago));
					}
					else
						$pago = 0;

					$msg = "Este evento é pago";

					if($evento['edital'])
						$msg .= " e por conter múltiplos valores, é aconcelhado consultar o edital para mais informações sobre demais valores.";
					else
						$msg .= " e a taxa de ingressão é de <b>R$ {$evento['valor']}</b>.";

					if($evento['arquivo_edital'])
						$edital = "ou consulte o edital para mais informações";
					else
						$edital = ""; 
					
					echo "<section class='row'>";
						echo "<div class='col-md-12' style='margin-bottom: 1rem;'>";
							echo "<p>{$msg} Enquanto seu pagamento não for aprovado você não poderá se inscrever nas atividades do evento.</p>";
							echo "<p>Clicando em participar você entrará em uma fila de espera para a aprovação do seu pagamento. Entre em contato com os organizadores para realizar o pagamento {$edital}.</p>";
							if((isset($_SESSION['user']) && isset($_SESSION['admin'])) && !$_SESSION['admin']){
								if(!$pago['pag'])
									echo "<a class='btn-custom middleX participar'><span class='glyphicon glyphicon-ok' style='top: 2px'></span> Aceito participar deste evento</a>";
								else
									echo "<p class='text-success' style='text-align: center; margin: 2rem 0;'><b>O seu pagamento já foi aprovado!</b></p>";
							}
							else
								echo "<p class='text-dark-yellow' style='text-align: center; margin: 2rem 0;'><b>Entre em sua conta para poder participar do evento!</b></p>";
						echo "</div>";
					echo "</section>";
				}

				if($evento['arquivo_edital'] || (isset($_SESSION['user']) && !$_SESSION['admin']) && $evento['submissao_projeto']){
					echo "<section class='row'>";
						if($evento['arquivo_edital']){
							echo "<div class='col-sm-3' style='text-align: center'>";
								echo "<p class='item-label' >edital</p>";
								echo "<a class='edital' href='uploads/editais/{$evento['arquivo_edital']}' target='_blank'><span class='glyphicon glyphicon-file'></span>Vizualizar</a>";
							echo "</div>";
						}

						if((isset($_SESSION['user']) && !$_SESSION['admin']) && $evento['submissao_projeto']){
							echo "<div class='col-sm-9' align='center'>";
								echo "<label class='item-label' for='submete'>submeter projeto</label>";
								echo "<span> Formatos (.pdf, .doc, .docx)</span>";
								echo "<input id='submete' class='form-custom' type='file' accept='.pdf, .doc, .docx' />";
							echo "</div>";
						}
					echo "</section>";
				}					
			?>
			<header class='row' style='background: #eee; margin-top: 2rem;'>
				<h4>Atividades</h4>
			</header>

			<section class='row'>
				<div class="col-md-12">
					<p>Clique sobre a atividade para mais informações.</p>
				</div>
				<div id='tblAtividades' class='col-xs-12 table-responsive' style=""></div>
				
				<section class='row' style="text-align: center">
					<div class='col-xs-5 custom-col'>
						<button id='ant' class='pagina pull-right' style='color: inherit'><span class='icon glyphicon glyphicon-menu-left'></span> Página anterior</button>
					</div>
					<div class="col-xs-2 hidden-xx">
						<div class="dropdown">
							<button id='dropPagina' class='btn btn-default dropdown-toggle btn-drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='background: #eee'>
								<span id='pagAtual' style='padding-right: 5px'>1</span>
								<span class='caret'></span>
							</button>
							<ul class='dropdown-menu' aria-labelledby='dropPagina'>
								<?php
									for($i = 1; $i <= $GLOBALS['numPaginas']; $i++){
										if($i === intval($GLOBALS['numPaginas']))
											echo "<li><button id='pagUlt' class='dropButton'>{$i}</button></li>";
										else
											echo "<li><button class='dropButton'>{$i}</button></li>";
									}
								?>
								<input id='q' type='hidden' <?php echo "value='".base64_encode($GLOBALS['id'])."'"; ?>  />
							</ul>
						</div>
					</div>
					<?php
					if($total > $rows){
						echo "<div class='col-xs-5 custom-col'>";
							echo "<button id='prox' class='pagina pull-left' style='color: inherit'>Próxima página <span class='icon glyphicon glyphicon-menu-right'></span></button>";
						echo "</div>";
					}
					?>
				</section>
			</section>

		</section>
	</main>

<?php require_once("footer.php"); ?>

<script src='js/tabelaAtividade.js'></script>

</body>

</html>