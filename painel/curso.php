<?php 


session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_curso'])){
		$erro_curso = $_GET['erro_curso'];
}else{
	$erro_curso = 0;
}

$titulo = "";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$sql = "SELECT titulo from cursos where id = $id ";
	if($resultado_id = mysqli_query($link, $sql)){
		$dados = mysqli_fetch_array($resultado_id);
		if(isset($dados['titulo'])){
			$titulo = $dados['titulo'];
		}
	}

}else{
	$id = -1;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Novo Curso</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php 
  if($erro_curso == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Cadastrar! </strong> Curso já existente!
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
	          	<li><a href="atividades.php">Atividades</a></li>
	          	<li  class="active"><a href="cursos.php">Cursos</a></li>
	            <li><a href="categorias.php">Categorias</a></li>
	            <li><a href="administradores.php">Administradores</a></li>
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/UemgEventos/sair.php">Sair</a></li>
		</ul>
	</div>
	</div>
</nav>

<div class="container">
	<div class="col-md-12">
		
		<form method="post" <?php if($id == -1){ echo "action='registrar_curso.php'";}else{ echo "action='atualizar_curso.php?id=".$id."'";} ?> >
		<div class="col-md-6">
		<?php if($id == -1){
		 echo "<h2>Novo Curso</h2>";
		}else{
			echo "<h2>Editar Curso</h2>";
		}
		  ?>
		
			<div class="form-group">
				<label for="titulo">Título: </label>
				<input type="text" id="titulo" name="titulo" <?php echo "value='$titulo'" ?> class="form-control" required="true">
			</div>
		<button class="btn btn-success"><?php if($id == -1){ echo "Cadastrar";}else{ echo "Atualizar";} ?></button>
		<a class="btn btn-danger" href="/UemgEventos/painel/cursos.php" role="button">Cancelar</a>
		
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