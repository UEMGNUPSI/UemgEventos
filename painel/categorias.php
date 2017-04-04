<?php 


session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == 0){
	header("Location: /UemgEventos/index.php");
}


require_once('../bd.class.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['busca'])){
	$busca = $_GET['busca'];
}else{
	$busca = '';
}


if(isset($_GET['sucesso'])){
	$sucesso = $_GET['sucesso'];
}else{
	$sucesso = 0;
}


$sql = "SELECT titulo, id FROM categorias WHERE titulo LIKE '%".$busca."%'";

$resultado_id = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Categorias</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php 
 if($sucesso == 1){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Nova Categoria cadastrada com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>
 <?php 
  if($sucesso == 2){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Categoria atualizada com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>
 <?php 
  if($sucesso == 3){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Categoria excluida com sucesso!</strong> 
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
	            <li class="active"><a href="categorias.php">Categorias</a></li>
	            <li><a href="administradores.php">Administradores</a></li>
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
		<h2>Buscar Categoria</h2>
		<div class="col-md-5">
			<form method="get" action="categorias.php">
				<input type="text" name="busca" placeholder="Busca" class="form-control" required="true">
				</div>
				<div class="col-md-3">
				<button class="btn btn-success">Buscar</button>
			</form>
			<a href="categorias.php" class="btn btn-warning">Limpar Busca</a>
		</div>
	</div>

	<div class="col-md-12">
	<hr>
		<div class="col-md-10">
			<h2>Categoria</h2>
		</div>
		<div class="col-md-2">
			<a href="categoria.php" class="btn btn-primary" style="margin-top: 20px;">Nova Categoria</a>
		</div>

		<div class="col-md-12">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th class="nome">Título</th>
					<th class="editar">Editar</th>
					<th class="excluir">Excluir</th>
				</tr> 


				<?php 
				if($resultado_id){
					while($categoria = mysqli_fetch_array($resultado_id)){
						echo '<tr>';

						echo "<td class='nome'>". $categoria['titulo'] . '</td>';

						echo "<td class='editar' align='center'> <a class='btn btn-warning' href='categoria.php?id=".$categoria['id']."'>Editar</a></td>";

						echo "<td class='excluir' align='center'> <button class='btn btn-danger' onclick='confirmar(".$categoria['id'].")'>Excluir</button></td>";

						echo '</tr>';
					}
				} ?>

			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	function confirmar(id) {
    var apagar = confirm("Confirma a exclusão?");
    if (apagar){
        location.href = 'apagar_categoria.php?id='+ id;
    }   
}
</script>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>