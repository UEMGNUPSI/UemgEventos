<?php 


session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
  header("Location: /UemgEventos/index.php");
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_atividade'])){
    $erro_atividade = $_GET['erro_atividade'];
}else{
  $erro_atividade = 0;
}

$titulo = "";
$descricao = "";
$evento = "";
$categoria = "";
$vagas_total = "";
$vagas_disp = "";
$ministrante = "";
$data_inicio = "";
$hora_inicio = "";
$hora_fim = "";
$local_atividade = "";


if(isset($_GET['id'])){
  $id = $_GET['id'];

  $sql = "SELECT titulo, descricao, vagas_total, vagas_disp, ministrante, data_inicio, hora_inicio, hora_fim, local_atividade, id_categoria, id_evento from atividades where id = $id ";
  if($resultado_id = mysqli_query($link, $sql)){
    $dados = mysqli_fetch_array($resultado_id);
    if(isset($dados['titulo'])){

      $titulo = $dados['titulo'];
      $descricao = $dados['descricao'];
      $evento = $dados['id_evento'];
      $categoria = $dados['id_categoria'];
      $vagas_total = $dados['vagas_total'];
      $vagas_disp = $dados['vagas_disp'];
      $ministrante = $dados['ministrante'];
      $data_inicio = $dados['data_inicio'];
      $hora_inicio = $dados['hora_inicio'];
      $hora_fim = $dados['hora_fim'];
      $local_atividade = $dados['local_atividade'];
    }
  }

}else{
  $id = -1;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Nova Atividade</title>

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

<?php 
  if($erro_atividade == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Cadastrar! </strong> Título já utilizado!
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
	            
	            
	            
	          </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/UemgEventos/sair.php">Sair</a></li>
		</ul>
	</div>
	</div>
</nav>


<div class="container">
	<div class="col-md-12">
		
	<form method="post" <?php if($id == -1){ echo "action='registrar_atividade.php'";}else{ echo "action='atualizar_atividade.php?id=".$id."'";} ?>>
		<div class="col-md-6">
		
				 <?php if($id == -1){
	             echo "<h2>Nova Atividade</h2>";
	            }else{
	              echo "<h2>Editar Atividade</h2>";
	            }
	              ?>

			
		<div class="form-group">
	            <label for="titulo">Título</label>
	            <input type="text" id="titulo" name="titulo" <?php echo "value='$titulo'" ?> class="form-control" required="true">
        </div>

        <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" <?php echo "value='$descricao'" ?> class="form-control" required="true">
        </div>

       <div class="form-group">
          <label>Evento: </label>
          <select class="form-control" name="evento" required>
             <option disabled selected style="display: none;" value="">Selecione</option>
          <?php 
            $sql = "SELECT titulo, id FROM eventos";

            $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){
            while($evento = mysqli_fetch_array($resultado_id)){

              echo "<option value='".$evento['id']."'>".$evento['titulo']."</option>";

            }
          }

           ?>
          </select>
        </div>

        <div class="form-group">
          <label>Categoria: </label>
          <select class="form-control" name="categoria" required>
             <option disabled selected style="display: none;" value="">Selecione</option>
          <?php 
            $sql = "SELECT titulo, id FROM categorias";

            $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){
            while($categoria = mysqli_fetch_array($resultado_id)){

              echo "<option value='".$categoria['id']."'>".$categoria['titulo']."</option>";

            }
          }

           ?>
          </select>
        </div>

		<div class="form-group">
			<label for="vagas_total"> Vagas Total:</label>
			<input type="number" name="vagas_total" id="vagas_total" min="1" max="500" step="1" <?php echo "value='$vagas_total'" ?> class="form-control" required="true" >
		</div>

		<div class="form-group">
			<label for="vagas_disp"> Vagas Disponíveis:</label>
			<input type="number" name="vagas_disp" id="vagas_disp" min="1" max="500" step="1" <?php echo "value='$vagas_disp'" ?> class="form-control" required="true">
		</div>

		<div class="form-group">
                <label for="ministrante">Ministrante</label>
                <input type="text" name ="ministrante" id="ministrante" <?php echo "value='$ministrante'" ?> class="form-control" required="true">
        </div>

        <div class="form-group">

          <label for="data_inicio">Data</label>
          <input type="text" id="data_inicio" name="data_inicio" <?php echo "value='$data_inicio'" ?> class="form-control" required="true">

         </div>

        <div class="form-group">
                <label for="hora_inicio">Horário de início</label>
                <input type="text" name="hora_inicio" id="hora_inicio" <?php echo "value='$hora_inicio'" ?> class="form-control" required="true">


        </div>

        <div class="form-group">
                <label for="hora_fim">Horário de término</label>
                <input type="text" name="hora_fim" id="hora_fim" <?php echo "value='$hora_fim'" ?> class="form-control" required="true">
        </div>

          <div class="form-group">
                <label for="local_atividade">Local</label>
                <input type="text" name="local_atividade" id="local_atividade" <?php echo "value='$local_atividade'" ?> class="form-control" required="true">
        </div>

        	<button class="btn btn-success"><?php if($id == -1){ echo "Cadastrar";}else{ echo "Atualizar";} ?></button>
          	<a class="btn btn-danger" href="/UemgEventos/painel/atividades.php" role="button">Cancelar</a>

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