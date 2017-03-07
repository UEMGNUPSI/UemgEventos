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
	          	<li class="active"><a href="eventos.php">Eventos</a></li>
	          	<li><a href="atividades.php" class="active">Atividades</a></li>
	          	<li><a href="cursos.php">Cursos</a></li>
	            <li><a href="categorias.php">Categorias</a></li>
	            <li><a href="novo_adm.php">Novo Administrador</a></li>
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<?php if($login != 0){?><li><a href="/UemgEventos/sair.php">Sair</a></li> <?php } ?>
		</ul>
	</div>
	</div>
</nav>
</body>
</html>