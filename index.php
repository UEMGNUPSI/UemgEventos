<?php 


session_start();

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

if(!isset($_SESSION['usuario'])){
	$login = 1;
}else{
	$login = 0;
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
<form class="modal fade" id="janela" method="post" action="validar_acesso.php">
      <div class="modal-dialog" id='teste'>
        <div class="modal-content">
          <!-- cabecalho -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
            <h4 class="modal-title">Efetuar Login</h4>

          </div>
          <!-- corpo -->
          <div class="modal-body">
            <div class="form-group">
              <label for="email">E-mail</label>
              <input id='email' type="text" class="form-control" id="campo_usuario" name="usuario"/>
            </div>

            <div class="form-group">
              <label for="senha">Senha</label>
              <input id='senha' type="password" class="form-control red" id="campo_senha" name="senha" maxlength="20"/>
            </div>
            <?php if($erro == 2){ echo '<font color=#FF0000>Usuario ou senha inválidos</font>'; } ?>
          </div>

          <!-- rodape -->
          <div class="modal-footer">
            <a href="cadastro.php" class="btn btn-primary" style="float: left;">Cadastrar</a>
            <button class="btn btn-success" type="submit">Logar</button>
            <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>

        </div>
      </div>
    </form>


<nav class="navbar navbar-inverse navbar-custom  navbar-fixed-top">
  <div class="container">

  <!-- header -->
        <div class="navbar-header">

        <!-- botao toggle-->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
          <span class="sr-only">alternar navegação</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        </div>
    
    <div class="collapse navbar-collapse" id="barra-navegacao">
    <ul class="nav navbar-nav ">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="atividades.php">Atividades</a></li>
      <li><a href="eventos.php">Eventos</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if($login == 0){ echo "<li><a href='sair.php'>Sair</a></li>";}else{ echo "<li><a href='#' data-toggle='modal' data-target='#janela'>Entrar</a></li>"; } ?>

    </ul>
  </div>
  </div>
</nav>








<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>