<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		$login = 1;
	}else{
		$login = 0;
	}

	if(isset($_GET['sucesso'])){
		$sucesso = $_GET['sucesso'];
	}
	else{
		$sucesso = 0;
	}

	if(isset($_GET['erro'])){
		$erro = $_GET['erro'];
	}
	else{
		$erro = 0;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="imagens/icone.ico" type="image/x-icon"/>
	<title>Submissão de Projetos</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="Swiper-3.4.2/dist/css/swiper.css">

	<!-- Fonte da Barra de Navegação -->
	<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:700" rel="stylesheet"> 

	<!-- Fonte da Barra de Geral -->
	<link href="https://fonts.googleapis.com/css?family=Signika+Negative:300" rel="stylesheet">

	<style type="text/css">
		.btn-enviar{
			/*background: blue;*/
		}
	</style>
</head>
<body>
<?php 

	if($sucesso == 1){?>
		<div class="alert alert-success" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>Arquivo eviado com sucesso!</strong> 
	    </div> <?php
	}

	if($erro == 1){?>
		<div class="alert alert-danger" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>Ocorreu algum erro ao tentar enviar o arquivo!</strong> 
	    </div> <?php
	}

	if($erro == 2){?>
		<div class="alert alert-danger" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>Não foi possível enviar o arquivo, tente enviar apenas arquivo .doc e .docx! E tente novamente.</strong> 
	    </div> <?php
	}

	if($erro == 3){?>
		<div class="alert alert-danger" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>O arquivo é grande de mais para ser enviado, o tamanho máximo é de 2MB!</strong> 
	    </div> <?php
	}

	if($erro == 4){?>
		<div class="alert alert-danger" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
	      <strong>Você não selecionou nenhum arquivo para upload!</strong> 
	    </div> <?php
	}

	include('login.php');
	
?>
	<nav class="navbar navbar-inverse navbar-custom  navbar-fixed-top nav-color">
		<div class="container">

		<!-- header -->

		    <div class="navbar-header">

			    <!-- botao toggle  <a href='#' data-toggle='modal' data-target='#janela'>entrar</a> -->
			    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
			      <span class="sr-only">alternar navegação</span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			    </button>
			    <a href="index.php" class="navbar-brand">
			        <span class="img-logo">UEMG Eventos</span>
			    </a>

		    </div>

			<div class="collapse navbar-collapse" id="barra-navegacao">
			  <ul class="nav navbar-nav">
			    <li><a href="index.php">home</a></li>
			    <li><a href="eventos.php">eventos</a></li>
			    <li class="active"><a href="submissao_projeto.php">submissão</a></li>
			    <li><a href="suporte.php">suporte</a></li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
			  <?php if($login == 0){ if($_SESSION['admin']){ 
        echo "<li class='dropdown'>
                <a  href='#' class='dropdown-toggle' data-toggle='dropdown'>minha conta<span class='glyphicon glyphicon-menu-down minha-conta' aria-hidden='true'></span></a>
                <ul class='dropdown-menu' aria-labelledby='dropdownMenuDivider' >
                  <li> <a href='painel/eventos.php'>painel administrativo</a> </li>
                  <li role='separator' class='divider'></li>
                  <li> <a href='sair.php'>sair</a> </li>
                </ul>
              </li>";
      }
      else{echo "<li class='dropdown'>
      <a  href='#' class='dropdown-toggle' data-toggle='dropdown'>minha conta<span class='glyphicon glyphicon-menu-down minha-conta' aria-hidden='true'></span></a>
      <ul class='dropdown-menu' aria-labelledby='dropdownMenuDivider' >
        <li> <a href='perfil.php'>meu perfil</a> </li>
        
        <li> <a href='submissao_projeto.php' style='color:#49af29;'>enviar projeto</a> </li>
        <li role='separator' class='divider'></li>
        <li> <a href='sair.php'>sair</a> </li>
      </ul>
      </li>";}}else{ echo "<li><a href='#' data-toggle='modal' data-target='#janela'>entrar</a></li>"; } ?>


			  </ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="col-md-12 body-sub" style="padding: 30px 30px; margin-top: 40px;">
			<h2 style="margin-top: 0">Envie seu projeto para análise</h2>
			<hr>
			<div class="col-md-8">
        
		        <h4>Para se informar sobre as regras de submissão de projeto, baixe o edital abaixo.</h4>
		        <div class="col-md-4" align="center" style="margin-top: 26px;">
		          <h4>Direito</h4>
		          <div class="div-edital" title="Clique para baixar!">
		            <a href="uploads/Edital.pdf" download><img class="img-arquivo" src="imagens/edital.png"></a>
		          </div>
		        </div>
		        <?php if($login == 0){ ?>
		        <div class="col-md-12" style"margin-top:32px;">
		        	<h3 align="center">Enviar projeto</h3>
		        </div>
				
				<div class="div-upload col-md-12" align="center">
					<p>Deve ser enviado apenas arquivos <b>.doc</b> ou <b>.docx</b>. Tamanho máximo: <b>2MB</b></p>
					<form action="projeto_upload.php" method="POST" enctype="multipart/form-data">

						<input type="file" name="arquivo" id="arquivo" style="background: #d3ecfb; padding-right: 6px; border-radius: 4px" />
						<button class="btn-submit" id="enviar">Enviar</button>
						
						<!-- <input class="btn btn-submit" style="margin-top: 12px" type="submit" name="enviar" id="enviar" value="Enviar" /> -->

					</form>
				</div>
				<?php } ?>
		</div>
			

		</div>
		
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="Swiper-3.4.2/dist/js/swiper.min.js"></script>

<footer style="position: relative; bottom: -61px;">
  <div class="col-xs-12 rodape">
    <div id="nupsi-footer" class="col-xs-6">
      <h3>NUPSI Contato</h3>
      <p>Av. Professor Mário Palmerio, 1001 - Bairro Universitário - Frutal/MG
         CEP: 38200-000 - Telefone (34) 3423-2700 - Ramal 2772</p>
      <p>E-mail: nupsi.frutal@uemg.br</p>
      <div class="col-xs-12" style="padding: 0; margin-top: 8px;">
        <img id="img-nupsi" src="imagens/NUPSI.png">
      </div>
    </div>
    <div class="col-xs-6" id="uemg-footer">
      <h3>UEMG Contato</h3>

      <p>Av. Professor Mário Palmerio, 1001 - Bairro Universitário - Frutal/MG
         CEP: 38200-000 - Telefone (34) 3423-2700 - FAX (34) 3423-2727 </p>

      <p>Site: <a href="http://frutal.uemg.br" target="_blank">UEMG Unidade Frutal</a></p>
      <p>E-mail: diretoria.frutal@uemg.br</p>
      <div class="col-xs-12" style="padding-right: 0">
        <a href="http://frutal.uemg.br" target="_blank"><img id="img-uemg" src="imagens/frutal.png"></a>
      </div>
    </div>

  <!--<div class="col-lg-4" style="padding-right: 0">
    <img id="img-nupsi" src="imagens/NUPSI.png">
    <a href="http://frutal.uemg.br" target="_blank"><img id="img-uemg" src="imagens/frutal.png"></a>
    
  </div>-->
    
    
  </div>
    
</footer>
</body>

</html>