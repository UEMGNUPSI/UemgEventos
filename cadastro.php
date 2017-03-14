<?php 


session_start();

require_once('bd.class.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_usuario'])){
	$erro_usuario = $_GET['erro_usuario'];
}else{
	$erro_usuario = 0;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Categorias</title>

	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

</head>
<body>

<?php 
  if($erro == 2){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Logar! </strong> Usuario e(ou) Senha invalido(s)!
    </div>
  <?php  
  }

 ?>

 <?php 
  if(isset($_GET['sucesso'])){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Usuario registrado com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>


 <?php 
  if($erro_usuario == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro!</strong> Usuário já existente!
    </div>
  <?php  
  }

 ?>

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
      <li><a href="index.php">Home</a></li>
      <li><a href="atividades.php">Atividades</a></li>
      <li><a href="eventos.php">Eventos</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <li><a href='#' data-toggle='modal' data-target='#janela'>Entrar</a></li>

    </ul>
  </div>
  </div>
</nav>

<div class="container">
	<div class="col-md-12">
		
		  <?php  ?>
  		<div class="col-md-6">
  		<h2>Novo Usuario</h2>

      <label style="padding-right: 25px;"><input type="radio" name="tipo" value="aluno" >Aluno</label>
      <label><input type="radio" name="tipo" value="nao-aluno"> Não-Aluno</label>

  		<div id="form-nao-aluno">
      <form method="post" action="registrar_usuario.php">
        <div class="form-group">
          <label for="nome">Nome: </label>
          <input type="text" id="nome" name="nome" class="form-control" required="true" required>
        </div>
        <div class="form-group">
          <label for="email">E-Mail: </label>
          <input type="email" id="email" name="email" placeholder="" class="form-control" required="true" required>
        </div>
        <div class="form-group">
          <label for="senha">Senha: </label>
          <input type="password" id="senha" name="senha" placeholder="De 5 a 20 caracteres" class="form-control" pattern=".{5,20}" required>
        </div>

         <button class="btn btn-success">Cadastrar</button> 
        </form>  
      </div>


  		<div id="form-aluno">
      <form method="post" action="registrar_usuario.php">
  			<div class="form-group">
  				<label for="nome">Nome: </label>
  				<input type="text" id="nome" name="nome" class="form-control" required="true" required>
  			</div>
  			<div class="form-group">
  				<label for="email">E-Mail: </label>
  				<input type="email" id="email" name="email" placeholder="" class="form-control" required="true" required>
  			</div>
  			<div class="form-group">
  				<label for="senha">Senha: </label>
  				<input type="password" id="senha" name="senha" placeholder="De 5 a 20 caracteres" class="form-control" pattern=".{5,20}" required>
  			</div>
  			<div class="form-group">
  				<label for="ra">R.A.: </label>
  				<input type="text" id="ra" name="ra" class="form-control" pattern=".{5,20}" required>
  			</div>
        <div class="form-group">
          <label>Curso: </label>
          <select class="form-control" name="curso" required>
             <option disabled selected style="display: none;" value="">Selecione</option>
          <?php 
            $sql = "SELECT titulo, id FROM cursos";

            $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){
            while($curso = mysqli_fetch_array($resultado_id)){

              echo "<option value='".$curso['id']."'>".$curso['titulo']."</option>";

            }
          }

           ?>
          </select>
        </div>

        <div class="form-group">
          <label for="ano">Ano de ingressão na faculdade: </label>
          <input type="number" id="ano" name="ano" placeholder="Ex: 2017" class="form-control" min="2000" max="2017"  required>
        </div>

         <button class="btn btn-success" style="margin-bottom: 10px;">Cadastrar</button>  
      </form>
      </div>

  		
  		</div>
	</div>
</div>

<script type="text/javascript">
  $("#form-aluno").hide();
  $("#form-nao-aluno").hide();
    var aux;
    $("input[name='tipo']").change(function() {
      aux = this.value;
      if(aux == "nao-aluno"){
        $("#form-aluno").hide();
        $("#form-nao-aluno").show();
      }else{
        $("#form-aluno").show();
        $("#form-nao-aluno").hide();
      }
     
    });
  </script>




<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>