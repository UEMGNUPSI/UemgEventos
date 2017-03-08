<?php 


session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}


require_once('../bd.class.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(!isset($_SESSION['usuario'])){
	$login = 0;
}else{
	$login = 1;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Categorias</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-custom navbar-fixed-top">
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
	          	<li class="active"><a href="atividades.php" class="active">Atividades</a></li>
	          	<li><a href="cursos.php">Cursos</a></li>
	            <li><a href="categorias.php">Categorias</a></li>
	            <li><a href="administradores.php">Novo Administrador</a></li>
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<?php if($login != 0){?><li><a href="/UemgEventos/sair.php">Sair</a></li> <?php } ?>
		</ul>

	</div>
	</div>
</nav>





<div class="container">
	<div class="col-md-12">
		<h2> Buscar </h2>
		<div class="col-md-5">
			<form method="get">
				<input type="text" name="busca" placeholder="Busca" class="form-control">
				</div>
				<div class="col-md-1">
				<button class="btn btn-success">Buscar</button>

			</form> 
		</div>
	</div>


       
<div class="col-md-12">
	<hr>
		<div class="col-md-10">
			<h2>Atividades</h2>
		</div>
		<div class="col-md-2">
			<a href="nova_atividade.php" a class="btn btn-primary" style="margin-top: 20px;">Nova atividade</a>
		</div>

<div class="col-md-12">
			<table border="1">
				<tr>
					<th>Nome</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr> 

</div>
    


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>