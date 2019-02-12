<?php 

	session_start();

	if(!isset($_SESSION['user']) || $_SESSION['admin'] == true){
		header("Location: /public/");

		die();
	}

	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

	if(!isset($_SESSION['usuario'])){
		$login = 1;
	}else{
		$login = 0;
	}

	require_once('../dao/bd.php');

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	# Início Usuário.
		$sql_user = "SELECT u.*, c.titulo curso FROM usuarios u INNER JOIN cursos c ON u.id_curso = c.id WHERE email = '{$_SESSION['user']}'";

		$user = mysqli_fetch_array(mysqli_query($link, $sql_user));

		$nasc = new DateTime($user['data_nascimento']);
	# Fim Usuário.

	# Início Eventos.
		$pagina = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;

		$registros = 7;

		$sql_eventos = "SELECT e.id, e.titulo, ep.pagamento FROM usuarios u INNER JOIN evento_pago ep ON u.id = ep.usuario INNER JOIN eventos e ON ep.evento = e.id  WHERE u.id = {$user['id']}";

		$total = mysqli_num_rows(mysqli_query($link, $sql_eventos));

		$numPaginas = ceil($total/$registros);

		$inicio = ($registros*$pagina)-$registros;

		$sql_eventos .= " LIMIT $inicio, $registros";

		$rows = mysqli_num_rows(mysqli_query($link, $sql_eventos));
	# Fim Eventos.


	function tabelaEventos($evt){
		
		if($evt['pagamento'])
			echo "<tr>";
		else
			echo "<tr>";

				echo "<td>";
					echo $evt['titulo'];
				echo "</td>";
			echo "</tr>";
		
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php 
    require_once("../head.php");
    head("UEMG Eventos");
  ?>
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
    
    <script>
      webshims.setOptions('waitReady', false);
      webshims.setOptions('forms-ext', {types: 'date'});
      webshims.polyfill('forms forms-ext');
    </script>
</head>
<body>

	<?php 
	  if(isset($_GET['sucesso'])){
	  ?>
	  <div class="alert alert-success" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>Perfil editado com sucesso!</strong> 
	    </div>
	  <?php  
	  }

	if($erro == 3){
		?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>CPF inválido! </strong> Tente novamente!
		</div>
		<?php  
	}

	if($erro == 4){
	  ?>
	  <div class="alert alert-danger" role="alert">
	    <button type="button" class="close" data-dismiss="alert">&times;</button>
	    <strong>RA inválido! </strong> Tente novamente!
	  </div>
	  <?php  
	}

	include('../dialog.php');
	
  	require_once("../nav.php");

	?>

	<section class="container">
		<section class="col-md-12 div-perfil">
			<header class="row header-perfil">
				<figure class="col-md-3">
					<img class="img-perfil middleX" src="../imagens/perfil.png">
				</figure>
				<div class="col-md-9" style="margin-top: 5%">
					<h1 class="nome"><?php echo $user['nome']; ?></h1>
				</div>
			</header>
			<section class="row">
				<aside class="col-md-3 hidden-sm hidden-xs menu-perfil">
					<ul class="nav">
						<li id='infoPerfil' class='menu-item ativo'><span class='icon glyphicon glyphicon-user' style='font-size: 14px; padding-right: .6rem;  top: 2px;'></span>Minhas Informações</li>
						<li id='eventosPerfil' class='menu-item'><span class='icon 
						glyphicon glyphicon-flag' style='font-size: 14px; padding-right: .6rem;  top: 2px;'></span>Meus Eventos</li>
						<li id='submissaoPerfil' class='menu-item'><span class='icon 
						glyphicon glyphicon-file' style='font-size: 14px; padding-right: .6rem;  top: 2px;'></span>Minhas Submissões</li>

						<li id='sairPerfil' class='menu-item' style="margin-top: 1rem;"><span class='glyphicon glyphicon-log-out' style='font-size: 14px; padding-right: .6rem;  top: 2px;'></span>Sair</li>
					</ul>
				</aside>

				<div id="info" class="col-md-9 col-sm-12">
					<header id="infoTitulo" class="row" style="background: #f8f8f8; padding-bottom: 2px;">
						<h3 align="center">Suas Informações</h3>
					</header>
					<section class="row">
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">E-Mail</p>
								<p><?php echo $user['email']; ?></p>
							</div>
							<div class="item-info">
								<p class="item-label">CPF</p>
								<p><?php echo $user['cpf']; ?></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">Data de Nascimento</p>
								<p><?php echo $nasc->format("d/m/Y"); ?></p>
							</div>
						</div>
					</section>
					<section class="row">
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">RA</p>
								<p><?php echo $user['ra']; ?></p>
							</div>
							<div class="item-info">
								<p class="item-label">Curso</p>
								<p><?php echo $user['curso']; ?></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">Ano de Ingressão</p>
								<p><?php echo $user['ano']; ?></p>
							</div>
						</div>
					</section>
					<section class="row">
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">Instituição</p>
								<p><?php echo $user['instituicao']; ?></p>
							</div>
							<div class="item-info">
								<p class="item-label">Telefone ou Celular</p>
								<p><?php echo $user['telefone']; ?></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="item-info">
								<p class="item-label">CNPJ</p>
								<p><?php echo $user['cnpj']; ?></p>
							</div>
						</div>
					</section>
				</div>

				<div id="eventos" class="col-md-9 col-sm-12">
					<header id="eventosTitulo" class="row" style="padding-bottom: 2px;">
						<h3 align="center">Meus Eventos</h3>
					</header>
					<section class="row" style="margin-top: 1rem">
						<div class="col-md-12">
							<p>Nesta seção você poderá saber quais eventos participa. Saiba que nem todos eventos são gratuitos, aqui é possível se informar quais eventos seu pagamento foi aceito ou não.</p>
							<p>Acessando o evento também será possível esclarecer em quais atividades está inscrito. <b>Para que sua presença nas atividades sejam contabilizadas no sistema, é preciso estar portando da credencial do evento.</b> Você pode imprimi-la nesta sessão.</p>
							<p>Certificados serão disponibilizados assim que os organizadores do evento permitir. <b>Você somente receberá o certificado desde que esteja entre o percentual aceito de presença no evento.</b> Este percentual pode variar de acordo com cada evento.</p>
							<p style='margin-top: 3rem;'>Clique sobre o evento para vizualizar as atividades no qual participa.</p>
						</div>
					</section>
					<section class="row">
						<div id='tblEventos' class="col-md-12 table-responsive"></div>

						<?php 

						# Páginação da tabela de Eventos

						if($rows){
							?>
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
												for($i = 1; $i <= $numPaginas; $i++){
													if($i === intval($numPaginas))
														echo "<li><button id='pagUlt' class='dropButton'>{$i}</button></li>";
													else
														echo "<li><button class='dropButton'>{$i}</button></li>";
												}
											?>
											<input id='q' type='hidden' <?php echo "value='".base64_encode($user['id'])."'"; ?>  />
										</ul>
									</div>
								</div>
								<div class='col-xs-5 custom-col'>
									<button id='prox' class='pagina pull-left' style='color: inherit'>Próxima página <span class='icon glyphicon glyphicon-menu-right'></span></button>
								</div>
							</section>
							<?php
						}
						?>
					</section>
				</div>

				<div id="submissao" class="col-md-9 col-sm-12">
					<header id="submissaoTitulo" class="row" style="padding-bottom: 2px;">
						<h3 align="center">Minhas Submissões</h3>
					</header>
					<section class="row" style="margin-top: 1em;">
						<div class="col-md-12">
							<p>Nesta seção você verá os projetos que você submeteu e ainda saber se foram aprovados ou não.</p>
						</div>
					</section>
				</div>
			</section>
			

			<!-- <div class="col-md-12">
				<h3 align="center">Configurações</h3>
				<hr>
				<div class="col-sm-4" style="text-align: center">
					<button class="btn btn-custom btn-credenciais" data-toggle='modal' data-target='#credenciais' style="color: #ecf8ef"><span class="glyphicon glyphicon-tags" style="margin-right: 4px; position: relative; top: 3px;"></span> Gerar Credenciais</button>
				</div>
				<div class="col-sm-4" style="text-align: center">
					<button class="btn btn-custom btn-certificado" data-toggle='modal' data-target='#certificados' style="color: #ecf8ef"><span class="glyphicon glyphicon-certificate" style="position: relative; top: 3px;"></span> Meus Certificados</button>
				</div>
				<div class="col-sm-4" style="text-align: center">
					<button class="btn btn-custom btn-editar" data-toggle='modal' data-target='#edit' style="color: #ecf8ef"><span class="glyphicon glyphicon-edit" style="position: relative; top: 2px;"></span> Editar Minha Conta</button>
				</div>
			</div> -->
		</section>
		
	</section>

<?php require_once("../footer.php"); ?>

<script src="../js/perfil.js"></script>
</body>
</html>