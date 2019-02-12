<?php 
  
  include('config.php');

  session_start();

  require_once('dao/bd.php');

  $objBd = new bd();
  $link = $objBd->conecta_mysql();

  $pagina = (isset($_GET['pagina'])) ? $_GET['pagina']: 1;

  $registros = 6;

  $sql = "SELECT e.*, l.local FROM eventos e INNER JOIN locais l ON e.id_local = l.id WHERE status = 'Ativo'";

  $total = mysqli_num_rows(mysqli_query($link, $sql));

  $numPaginas = ceil($total/$registros);

  $inicio = ($registros*$pagina)-$registros;

  $sql .= " LIMIT $inicio, $registros";

  $result_eventos = mysqli_query($link, $sql);

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
    include('login.php');
    include('dialog.php');
    
    $navEvento = "class='active'";
    require_once("nav.php");

    if(isset($_SESSION['success'])){
      switch(base64_decode($_SESSION['success'])){
        case '1':
          dialog("success", "Projeto submetido com sucesso!");
        break;
      }
    }
    
    if(isset($_SESSION['erro'])){
      switch(base64_decode($_SESSION['erro'])){
        case '1':
          dialog("erro", "Não foi possível submeter o seu projeto!<br />Tente novamente mais tarde.");
        break;
        case '2':
          dialog("erro", "Extensão não aceita pelo sistema.<br />Certifique-se que o arquivo seja .doc, .docx ou .pdf.");
        break;
        case '3':
          dialog("erro", "O tamanho do arquivo excede os 2MB permetidos pelo sistema.");
        break;
      }
    }

    switch(isset($_GET['erro'])){
      case '1':
        dialog("erro", "Não foi possível encontrar este evento!");
      break;
    }
  ?>

  <div class="container" style="margin-top: 86px;">
    
    
  <?php
    while($eventos = mysqli_fetch_array($result_eventos)){
      // $data_inicio = new DateTime($eventos['data_inicio']);
      // $data_fim = new DateTime($eventos['data_fim']);
      // $i = $data_inicio->diff($data_fim);
      
      $semana = strftime("%A", strtotime($eventos['data_inicio']));
      if($semana === "sábado" || $semana === "domingo")
        $texto = "No";
      else
        $texto = "Na";
      
      $inicio = strftime("%d/%b", strtotime($eventos['data_inicio']));

      $id = base64_encode($eventos['id']);

      echo "<section class='row'>";
        echo "<div class='col-xs-12 div-eventos'>";
          echo "<header class='row' style='background: #d5c09a; margin-bottom: 1rem;'>";
            echo "<div class='col-md-10'>";
              echo "<h3 style='margin: 15px 0'>{$eventos['titulo']}</h3>";
            echo "</div>";
            echo "<div class='col-md-2' style='padding: 0;' align='center'>";
              echo "<button class='btn-custom evento' onclick=\"perfilEvento('{$id}')\"><span class='glyphicon glyphicon-plus' style='top: 2px'></span> Ver Evento</button>";
            echo "</div>";
          echo "</header>";
          echo "<section class='row'>";
            echo "<div class='col-md-12' style='margin-bottom: 1.2rem'>";
              echo "<p>{$eventos['organizador']}</p>";
              echo "<p>{$texto} {$semana}, <span style='text-transform: capitalize;'>{$inicio}</span>, se dará início ao {$eventos['titulo']}. Clique em ver evento para mais informações!</p>";
            echo "</div>";
            if($eventos['arquivo_edital']){
              echo "<div class='col-sm-3' style='text-align: center'>";
                echo "<p class='item-label' >edital</p>";
                echo "<a class='edital' href='uploads/editais/{$eventos['arquivo_edital']}' target='_blank'><span class='glyphicon glyphicon-file'></span>Vizualizar</a>";
              echo "</div>";
            }

            if((isset($_SESSION['user']) && !$_SESSION['admin']) && $eventos['submissao_projeto']){
              echo "<div class='col-sm-9' align='center'>";
                echo "<label class='item-label' for='submete'>submeter projeto</label>";
                echo "<span> Formatos (.pdf, .doc, .docx)</span>";
                echo "<form class='row' method='post' action='dao/user/projeto.php' enctype='multipart/form-data'>";
                  echo "<div class='col-sm-8'>";
                    echo "<input id='l' name='l' type='hidden' value='".base64_encode($_SERVER['REQUEST_URI'])."' />";
                    echo "<input id='e' name='e' type='hidden' value='".base64_encode($eventos['id'])."' />";
                    echo "<input id='arquivo' name='arquivo' type='file' accept='.pdf, .doc, .docx' required />";
                  echo "</div>";
                  echo "<div class='col-sm-4 form-upload'>";
                    echo "<button class='btn upload bg-success'><span class='icon glyphicon glyphicon-cloud-upload'></span> Enviar</button>";
                  echo "</div>";
                echo "</form>";
              echo "</div>";
            }

          echo "</section>";
        echo "</div>";
      echo "</section>";
    }
  ?>
</div>

  <div class="container">
    <div style="text-align: center">
      <div style="display: inline-block;">
        <?php
        if($numPaginas > 1 ){
          for($i = 1; $i < $numPaginas + 1; $i++){
            if($i == $pagina){
              echo "<a class='pagina-active' href='index.php?pagina=$i'>".$i."</a>";
            }
            else{
              echo "<a class='pagina' href='index.php?pagina=$i'>".$i."</a>";
            }
          }
        }
          
        ?>
      </div>
    </div>  
  </div>
  <?php require_once("footer.php"); ?>
        
  <script>
    function perfilEvento(link){
      window.location = "perfil_evento.php?q="+link;
    }
  </script>
</body>
</html>