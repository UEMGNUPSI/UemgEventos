<?php 


session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_usuario'])){
		$erro_usuario = $_GET['erro_usuario'];
}else{
	$erro_usuario = 0;
}

$email = "";
$senha = "";
$nome = "";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$sql = "SELECT nome, email, senha from usuarios where id = $id ";
	if($resultado_id = mysqli_query($link, $sql)){
		$dados = mysqli_fetch_array($resultado_id);
		if(isset($dados['email'])){
			$email = $dados['email'];
			$senha = 0;
			$nome = $dados['nome'];
		}
	}

}else{
	$id = -1;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Novo Administrador</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php 
  if($erro_usuario == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Cadastrar! </strong> E-mail já está sendo utilizado!
    </div>
  <?php  
  }

 ?>
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
	          	<li><a href="eventos.php">Eventos</a></li>
	          	<li><a href="atividades.php" class="active">Atividades</a></li>
	          	<li><a href="cursos.php">Cursos</a></li>
	            <li><a href="categorias.php">Categorias</a></li>
	            <li class="active"><a href="administradores.php">Administradores</a></li>
	            <li><a href="relatorios.php">Relatórios</a></li>
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/UemgEventos/sair.php">Sair</a></li>
		</ul>
	</div>
	</div>
</nav>

<div class="container">
	<div class="col-md-12">
		
		<form method="post" <?php if($id == -1){ echo "action='registrar_adm.php'";}else{ echo "action='atualizar_adm.php?id=".$id."'";} ?> >
		<div class="col-md-6">
		<?php if($id == -1){
		 echo "<h2>Novo Administrador</h2>";
		}else{
			echo "<h2>Editar Administrador</h2>";
		}
		  ?>
		
			<div class="form-group">
				<label for="nome">Nome: </label>
				<input type="text" id="nome" name="nome" <?php echo "value='$nome'" ?> class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="email">E-Mail: </label>
				<input type="email" id="email" name="email" <?php echo "value='$email'" ?> placeholder="" class="form-control" required="true">
			</div>
			<div class="form-group">
				<label for="senha">Senha: </label>
				<input type="password" id="senha" name="senha" placeholder="De 5 a 20 caracteres" class="form-control" <?php if($senha != 0){ echo "required='true'";} ?> pattern=".{5,20}" >
			</div>
		<button class="btn btn-success"><?php if($id == -1){ echo "Cadastrar";}else{ echo "Atualizar";} ?></button>
		<a class="btn btn-danger" href="/UemgEventos/painel/administradores.php" role="button">Cancelar</a>
		
		</div>
		</form>
	</div>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>