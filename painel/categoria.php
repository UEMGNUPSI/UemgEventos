<?php 


session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_categoria'])){
		$erro_categoria = $_GET['erro_categoria'];
}else{
	$erro_categoria = 0;
}

$titulo = "";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$sql = "SELECT titulo from categorias where id = $id ";
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
	<title>Nova Categoria</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php 
  if($erro_categoria == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Cadastrar! </strong> Categoria já existente!
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
	          	<li><a href="cursos.php">Cursos</a></li>
	            <li class="active"><a href="categorias.php">Categorias</a></li>
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
		
		<form method="post" <?php if($id == -1){ echo "action='registrar_categoria.php'";}else{ echo "action='atualizar_categoria.php?id=".$id."'";} ?> >
		<div class="col-md-6">
		<?php if($id == -1){
		 echo "<h2>Nova Categoria</h2>";
		}else{
			echo "<h2>Editar Categoria</h2>";
		}
		  ?>
		
			<div class="form-group">
				<label for="titulo">Título: </label>
				<input type="text" id="titulo" name="titulo" <?php echo "value='$titulo'" ?> class="form-control" required="true">
			</div>
		<button class="btn btn-success"><?php if($id == -1){ echo "Cadastrar";}else{ echo "Atualizar";} ?></button>
		<a class="btn btn-danger" href="/UemgEventos/painel/categorias.php" role="button">Cancelar</a>
		
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