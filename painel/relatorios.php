<?php 


session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}


require_once('../bd.class.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();


if(isset($_GET['sucesso'])){
	$sucesso = $_GET['sucesso'];
}else{
	$sucesso = 0;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Eventos</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php 
  if($sucesso == 1){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Novo Evento cadastrado com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>
 <?php 
  if($sucesso == 2){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Evento atualizado com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>
 <?php 
  if($sucesso == 3){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Evento excluído com sucesso!</strong> 
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
	            <li><a href="administradores.php">Administradores</a></li>
	            <li class="active"><a href="relatorios.php">Relatórios</a></li>
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/UemgEventos/sair.php">Sair</a></li>
		</ul>
	</div>
	</div>
</nav>

<div class="container">
	<div class="col-md-12">
		<div class="col-md-10">
			<h2>Relatórios</h2>
		</div>

	<div class="col-md-12">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<td class="titulo">Eventos Abertos</td>
					<td align="center" style=" width: 200px">
					<a href="pdfrelatorios.php">
					<button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></a></td>
					



				</tr>
				<tr>
					<td class="titulo">Atividades com vagas disponiveis</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
				<tr>
					<td class="titulo">Atividades com vagas esgotadas</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
				<tr>
					<td class="titulo">Atividades abertas</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
				<tr>
					<td class="titulo">Lista de participantes no evento</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
				<tr>
					<td class="titulo">Lista de participantes na atividade</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
				<tr>
					<td class="titulo">Atividades de um evento</td>
					<td align="center" style=" width: 200px"><button class="btn btn-primary btn-md" style=" width: 100px">Gerar</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	function confirmar(id) {
    var apagar = confirm("Confirma a exclusão?");
    if (apagar){
        location.href = 'apagar_evento.php?id='+ id;
    }}
</script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>