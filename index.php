<?php 

    /* Usuário
    id - 14
    
    email - taniafiamettiongaratto@gmail.com
    senha - 2f908a706e4cd4550314bacda2e66bc5

    id - 290

    email - brunabarcelos@outlook.com
    senha - 69c29a627529c511f992a45cc905263d
  
    */
  
  include('config.php');

  session_start();

  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

  if(isset($_SESSION['user'])){
    $login = 1;
  }else{
    $login = 0;
  }

  if(!isset($_SESSION['id'])){
    $_SESSION['id'] = 0;
  }

  require_once('dao/bd.php');

  $objBd = new bd();
  $link = $objBd->conecta_mysql();
  
  $pagina = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;

  if(isset($_GET['busca']))
    $busca = htmlentities($_GET['busca'], ENT_QUOTES);
  else
    $busca = '';
  
  if(isset($_GET['evt']))
    $id_evento = $_GET['evt'];
  else
    $id_evento = '';

  $sql = "SELECT a.*, c.titulo categoria FROM atividades a INNER JOIN eventos e ON a.id_evento = e.id INNER JOIN categorias c ON a.id_categoria = c.id WHERE a.titulo LIKE '%{$busca}%' AND e.status = 'Ativo' AND a.id_evento LIKE '%{$id_evento}%' ORDER BY a.data_inicio";

  if(mysqli_query($link, $sql))
    $total = mysqli_num_rows(mysqli_query($link, $sql));

  $registros = 6;             # Número de atividades por página.

  $numPaginas = ceil($total/$registros);

  $inicio = ($registros*$pagina)-$registros;

  $sql .= " LIMIT $inicio, $registros";

  if(mysqli_query($link, $sql))
    $pagina_atv = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html>
<head>
  <?php 
    require_once("head.php");
    head("UEMG Eventos");
  ?>
</head>
<body>
<?php
  require_once("dialog.php");
  include('login.php');
  $navHome = "class='active'";
  require_once("nav.php");

  if(isset($_SESSION['success'])){
		switch(base64_decode($_SESSION['success'])){
			case '1':
				dialog("success", "Inscrito na atividade com sucesso!");
			break;
			case '2':
				dialog("success", "Você desinscreveu da atividade com sucesso!");
			break;
			case '3':
				// dialog("success", "Local excluido com sucesso!");
			break;
		}
	}

	if(isset($_SESSION['erro'])){
		switch(base64_decode($_SESSION['erro'])){
			case '1':
				dialog("erro", "Esta atividade pertence à um evento pago. Acesso o evento e clique em participar do evento.");
			break;
			case '2':
				dialog("erro", "Número de vagas esgotadas, tente novamente mais tarde!");
			break;
			case '3':
				dialog("erro", "Não foi possível excluir este local! Pode ser que há eventos vinculados com este local ou tente novamente mais tarde.");
			break;
			case '9':
				dialog("alert", "Você não tem permissão para acessar essa página!");
			break;
		}
	}
?>
<!-- Carrossel Swiper -->
<div class="container" style="margin-bottom: 40px;">
  <div class="swiper-container swiper-background">
    <div id="destaque">Eventos em Destaques</div>
      <div class="swiper-wrapper">
        <?php 

        $sql = "SELECT * FROM eventos WHERE status = 'Ativo'";

        $evt = mysqli_query($link, $sql);

        while($banner_evt = mysqli_fetch_array($evt)){

          echo '<div class="swiper-slide">';
            echo "<img class='banner' src='uploads/img-eventos/{$banner_evt['banner']}'>";
            if(strlen($banner_evt['descricao'])>=110){
              $des = substr($banner_evt['descricao'], 0,110);
              echo '<div class="banner-desc"><p class="big">'.$des.'... </p><a href="perfil_evento.php?q='.base64_encode($banner_evt['id']).'" style="margin: 4px;">Saiba Mais</a></div>';
            }
            else{
              echo '<div class="banner-desc">'.$banner_evt['descricao'].'<br><a href="perfil_evento.php?q='.base64_encode($banner_evt['id']).'" style="margin: 4px;">Saiba Mais</a></div>';
            }
          echo '</div>';
        }
        ?>
                
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>

</div>

<div class="container">
  <section class="row div-atividade">
    <div class="atv-titulo">
      <h3>Atividades</h3>
    </div>
    
    <div class='col-md-12 select-evento'>
      <label for="filtroEvento">Eventos Disponíveis:</label>
      <select id='filtroEvento' class='btn-drop' name="evt" form="filtro" style='color: #313f50; width: 20%'>
        <option value="">Todos</option>
        <?php
          if($result_evt = mysqli_query($link, "SELECT id, titulo FROM eventos WHERE status = 'Ativo'")){
            while($eventos = mysqli_fetch_array($result_evt)){
              if($id_evento === $eventos['id'])
                echo "<option value='{$eventos['id']}' selected>{$eventos['titulo']}</option>";
              else
              echo "<option value='{$eventos['id']}'>{$eventos['titulo']}</option>";
            }
          }
        ?>
      </select>
    </div>
  </section>
<?php 
  if(mysqli_num_rows($pagina_atv)){
    include_once("atividade.php");
  }  
  else if($busca !== ""){
    echo "<section class='col-md-12 ninjas middleX'>";
      echo "<header><h3>Oh não!</h3></header>";
      echo "<p>Os ninjas removedores de atividades foram mais rápidos, por isso <b>não foi possível encontrar esta atividade</b>!</p>";
      echo "<a href='index.php'>Voltar a página inicial?</a>";
    echo "</section>";
  }
?>
</div>

<div class="container">
  <div style="text-align: center">
      <?php
        function dropPagina($style){
          echo "<div class='dropdown {$style}'>";
            echo "<button class='btn btn-default dropdown-toggle btn-drop' type='button' id='dropPagina' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>";
              echo "<span style='padding-right: 5px'>{$GLOBALS['pagina']}</span>";
              echo " <span class='caret'></span>";
            echo "</button>";
            echo "<ul class='dropdown-menu' aria-labelledby='dropPagina'>";
              for($i = 1; $i <= $GLOBALS['numPaginas']; $i++){
                if($i !== $GLOBALS['pagina'])
                  echo "<li><a href='index.php?pagina={$i}'>{$i}</a></li>";
              }
            echo "</ul>";
          echo "</div>";
        }
        echo "<div class='row'>";
          if($numPaginas > 1 ){
            if($pagina === 1){
              $prox = $pagina + 1;
              echo "<div class='col-xs-6'>";
                dropPagina("pull-right");
              echo "</div>";
              echo "<div class='col-xs-6'>";
                echo "<a class='pagina pull-left' href='index.php?pagina={$prox}'>";
                  echo "Próxima página <span class='icon glyphicon glyphicon-menu-right'></span>";
                echo "</a>";
              echo "</div>";
            }
            else{
              $prox = $pagina + 1;
              $ant = $pagina - 1;

              echo "<div class='col-xs-5 custom-col'>";
                echo "<a class='pagina pull-right' href='index.php?pagina={$ant}' >";
                  echo "<span class='icon glyphicon glyphicon-menu-left'></span> Página anterior";
                echo "</a>";
              echo "</div>";
              echo "<div class='col-xs-2 hidden-xx'>";
                dropPagina(NULL);
              echo "</div>";

              if($pagina < $numPaginas){
                echo "<div class='col-xs-5 custom-col'>";
                  echo "<a class='pagina pull-left' href='index.php?pagina={$prox}' style='float: left'>";
                    echo "Próxima página <span class='icon glyphicon glyphicon-menu-right'></span>";
                  echo "</a>";
                echo "</div>";
              }
            }
          }
        echo "</div>";
      ?>
    </div>
  </div>  
</div>




<script src="frameworks/Swiper-3.4.2/dist/js/swiper.min.js"></script>
<!-- CARROSSEL -->
<script>        
  var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 0,
        centeredSlides: true,
        autoplay: 4000,
        grabCursor: true,
        speed: 800,
        autoplayDisableOnInteraction: false
  });
</script>

<?php require_once("footer.php"); ?>

<script type="text/javascript">
  function inscrever(){
    alert('Cadastre-se no site para se inscrever nas atividades! Clique em entrar e depois cadastrar.');
  }

  function cheio(){
    alert('Vagas esgotadas!');
  }
  
  $("#filtroEvento").change(function(){
    $("#filtro").submit();
  });

</script>

</body>

</html>