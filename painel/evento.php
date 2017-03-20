<?php 


session_start();

require_once('../bd.class.php');

if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
  header("Location: /UemgEventos/index.php");
}

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_evento'])){
    $erro_evento = $_GET['erro_evento'];
}else{
  $erro_evento = 0;
}

$titulo = "";
$descricao = "";
$data_inicio = "";
$data_fim = "";
$organizador = "";
$valor = "";
$pagar_para = "";


if(isset($_GET['id'])){
  $id = $_GET['id'];

  $sql = "SELECT titulo, descricao, data_inicio, data_fim, organizador, valor, pagar_para from eventos where id = $id ";
  if($resultado_id = mysqli_query($link, $sql)){
    $dados = mysqli_fetch_array($resultado_id);
    if(isset($dados['titulo'])){

      $titulo = $dados['titulo'];
      $descricao = $dados['descricao'];
      $data_inicio = $dados['data_inicio'];
      $data_fim = $dados['data_fim'];
      $organizador = $dados['organizador'];
      $valor = $dados['valor'];
      $pagar_para = $dados['pagar_para'];
    }
  }

}else{
  $id = -1;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Novo Evento</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="estilo.css">

</head>
<body>
<?php 
  if($erro_evento == 1){
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
              <li class="active"><a href="eventos.php">Eventos</a></li>
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
      
      <div class="col-sm-12">

        <form method="post" <?php if($id == -1){ echo "action='registrar_evento.php'";}else{ echo "action='atualizar_evento.php?id=".$id."'";} ?>>
        <div class="col-md-6">

          <?php if($id == -1){
             echo "<h2>Novo Evento</h2>";
            }else{
              echo "<h2>Editar Evento</h2>";
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

          <label for="data_inicio">Data de Ínicio</label>
          <input type="text" id="data_inicio" name="data_inicio" <?php echo "value='$data_inicio'" ?> class="form-control" required="true">

          </div>

          <div class="form-group">

          <label for="data_fim">Data de Término</label>
          <input type="text" id="data_fim" name="data_fim" <?php echo "value='$data_fim'" ?> class="form-control" required="true">

          </div>
          
          <div class="form-group">

          <label for="organizador">Organizador</label>
          <input type="text" id="organizador" name="organizador" <?php echo "value='$organizador'" ?> class="form-control" required="true">

          </div>

           <div class="form-group">

          <label for="valor">Valor</label>
          <input type="text" id="valor" name="valor" <?php echo "value='$valor'" ?> class="form-control" required="true">

          </div>

           <div class="form-group">

          <label for="pagar_para">Pagar para</label>
          <input type="text" id="pagar_para" name="pagar_para" <?php echo "value='$pagar_para'" ?> class="form-control" required="true">

          </div>
           

           <!--<div class="form-group">
            <label for="foto">Selecionar Foto</label>
              <input type="file" id="foto">
               <p class="help-block">Selecionar foto do Evento.</p>
            </div>-->


          <button class="btn btn-success"><?php if($id == -1){ echo "Cadastrar";}else{ echo "Atualizar";} ?></button>
          <a class="btn btn-danger" href="/UemgEventos/painel/eventos.php" role="button">Cancelar</a>
          
         </div> 
        </form>

          

        </div>
  </div>






<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>