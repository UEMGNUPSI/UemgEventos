<?php 


session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
	header("Location: /UemgEventos/index.php");
}


require_once('../bd.class.php');

$objBd = new bd();
$link = $objBd->conecta_mysql();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Categorias</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
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
	          	<li><a href="eventos.php">Eventos</a></li>
	          	<li><a href="atividades.php" class="active">Atividades</a></li>
	          	<li><a href="cursos.php">Cursos</a></li>
	            <li><a href="categorias.php">Categorias</a></li>
	            
	            
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/UemgEventos/sair.php">Sair</a></li>
		</ul>
	</div>
	</div>
</nav>


<div class="container">
	<div class="col-md-12">
		
		
		<div class="col-md-6">
		<h2>Nova Atividade</h2>
			
		<div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo">
        </div>

        <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao">
        </div>

        <div class="form-group">
        <label for="Evento">Evento</label><br>
        <select name="example">
   		<option value="A">SELECIONE O EVENTO AQUI</option>
 	   	<option value="B">B</option>
    	<option value="-">Other</option>
		</select>
		</div>

        <div class="form-group">
        <label for="Categoria">Categoria</label><br>
        <select name="example">
   		<option value="A">SELECIONE O EVENTO AQUI</option>
 	   	<option value="B">B</option>
    	<option value="-">Other</option>
		</select>
		</div>

		<div class="form-group">
		<label for="numero"> Total de vagas</label>
		<input type="number" id="numero" min="1" max="500" step="1">
		</div>

		<div class="form-group">
		<label for="numero"> Vagas Disponíveis</label>
		<input type="number" id="numero" min="1" max="500" step="1">
		</div>

		<div class="form-group">
                <label for="ministrante">Ministrante</label>
                <input type="text" class="form-control" id="ministrante">
        </div>

        <div class="form-group">
                <label for="data">Data</label>
                <input type="text" class="form-control" id="data">
        </div>

        <div class="form-group">
                <label for="hora_inicio">Horário de início</label>
                <input type="text" class="form-control" id="hora_inicio">
        </div>

        <div class="form-group">
                <label for="hora_fim">Horário do fim</label>
                <input type="text" class="form-control" id="hora_fim">
        </div>





		<button class="btn btn-success">Cadastrar</button>
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