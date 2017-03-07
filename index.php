<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<form class="modal fade" id="janela" method="post" action="validar_acesso.php">
      <div class="modal-dialog">
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
          </div>
          <!-- rodape -->
          <div class="modal-footer">
            <!--a href="cadastro.html" class="btn btn-cadastrar" style="float: left;">Cadastrar</a-->
            <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Logar</button>
          </div>

        </div>
      </div>
    </form>

<a href="#" data-toggle="modal" data-target="#janela">Entrar</a>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>