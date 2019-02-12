<?php 

require_once("../utilitarios.php");

$atividade = array(
  "id"              => -1,
  "titulo"          => "",
  "descricao"       => "",
  "evento"          => "",
  "categoria"       => "",
  "vagas_total"     => "",
  "vagas_disp"      => "",
  "ministrante"     => "",
  "data_inicio"     => "",
  "hora_inicio"     => "",
  "hora_fim"        => "",
  "img"             => "",
  "local_atividade" => ""

);

// Evento!
if(isset($_GET['e'])){

  $evento         = base64_decode(filter_input(INPUT_GET, 'e', 
                    FILTER_SANITIZE_SPECIAL_CHARS));
  $base64_evento  = filter_input(INPUT_GET, 'e', 
                    FILTER_SANITIZE_SPECIAL_CHARS);

  if(!validaAdm($_SESSION['user'], $evento)){
    $_SESSION['erro'] = base64_encode(9);
    header("Location: ../eventos/");
    
    die();
  }

  if($result_evento = mysqli_query(banco(), "SELECT titulo FROM eventos WHERE id = $evento")){

    $dados = mysqli_fetch_array($result_evento);
    
    $titulo_evento = $dados['titulo'];

    unset($dados);

  }

}

if(isset($_GET['a'])){
  $id         = base64_decode(filter_input(INPUT_GET, 'a', 
                FILTER_SANITIZE_SPECIAL_CHARS));
  $base64_id  = filter_input(INPUT_GET, 'a', 
                FILTER_SANITIZE_SPECIAL_CHARS);

  $sql = "SELECT * FROM atividades WHERE id = $id ";

  if($resultado_id = mysqli_query(banco(), $sql)){
    $dados = mysqli_fetch_array($resultado_id);
      
    $atividade['id']              = $dados['id'];
    $atividade['titulo']          = $dados['titulo'];
    $atividade['descricao']       = nl2br($dados['descricao']);
    $atividade['id_evento']       = $dados['id_evento'];
    $atividade['id_categoria']    = $dados['id_categoria'];
    $atividade['vagas_total']     = $dados['vagas_total'];
    $atividade['vagas_disp']      = $dados['vagas_disp'];
    $atividade['ministrante']     = $dados['ministrante'];
    $atividade['data_inicio']     = $dados['data_inicio'];
    $atividade['hora_inicio']     = $dados['hora_inicio'];
    $atividade['hora_fim']        = $dados['hora_fim'];
    $atividade['img']             = $dados['img'];
    $atividade['local_atividade'] = $dados['local_atividade'];

    unset($dados);

    $pagina = (isset($_GET['pagina']))?$_GET['pagina']: 1;

    $registros = 11;

    $sql = "SELECT u.id, u.nome, u.email, ep.pagamento FROM usuario_atividade ua INNER JOIN atividades a ON ua.atividade = a.id INNER JOIN eventos e ON a.id_evento = e.id INNER JOIN evento_pago ep ON e.id = ep.evento AND ua.usuario = ep.usuario INNER JOIN usuarios u ON ep.usuario = u.id WHERE ua.atividade = ".$atividade['id'];

    $total = mysqli_num_rows(mysqli_query(banco(), $sql));

    $numPaginas = ceil($total/$registros);

    $inicio = ($registros*$pagina)-$registros;

    if(isset($_POST['busca'])){
      $busca = $_POST['busca']; 
    }
    else{
      $busca = '';
    }
  }
}

if($atividade['id'] !== -1){
  $class = "class='col-xs-12 form-group'";
  $classSalvar  = "class='row text-center'";
}
else{
  $class        = "class='col-md-6 form-group'";
  $classSalvar  = "class='row text-center top-admin'";
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php
    require_once("../head.php");
		 
    if($atividade['id'] === -1)
      head("Atividades");
    else
      head($atividade['titulo']);
  ?>
</head>
<body>
<main class='container-fluid' style="overflow: hidden">
  <section class="row">
<?php
  require_once("../nav.php");
  navbar("eventos");

  navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$titulo_evento}", "atividade", "../eventos/atividades.php?e={$base64_evento}");

  include_once("{$root}dialog.php");
  if(isset($_SESSION['success'])){
    switch(base64_decode($_SESSION['success'])){
      case '1':
        dialog("success", "Atividade salva com sucesso!");
      break;
      case '2':
        dialog("success", "Atividade atualizada com sucesso!");
      break;
      case '7':
        dialog("success", "Imagem removida com sucesso!");
      break;
      case '8':
        dialog("success", "Edital removido com sucesso!");
      break;
      
    }
  }

  if(isset($_SESSION['erro'])){
    switch(base64_decode($_SESSION['erro'])){
      case "1":
        dialog("erro", "Não foi possível salvar esta atividade!<br />Tente novamente mais tarde.");
      break;
      case "2":
        dialog("erro", "Não foi possível atualizar esta atividade!<br />Tente novamente mais tarde.");
      break;
      case "3":
        dialog("erro", "O banner não está dentro dos requisitos necessários.");
      break;
      case "4":
        dialog("erro", "O edital não está dentro dos requisitos necessários.");
      break;
      case "5":
        dialog("erro", "Tamanho excedido para o banner.");
      break;
      case "6":
        dialog("erro", "Tamanho excedido para o edital.");
      break;
      case "7":
        dialog("erro", "Não foi possível remover a imagem desta atividade!<br />Tente novamente mais tarde.");
      break;
      case "8":
        dialog("erro", "Não foi possível remover o edital deste atividade!<br />Tente novamente mais tarde.");
      break;
      case "9":
        dialog("alert", "Você não tem permissão para acessar essa página!");
      break;
      case "10":
        dialog("erro", "Não foi possível excluir a atividade deste evento!<br />Tente novamente mais tarde.");
      break;
      case "11":
        dialog("alert", "Nome existente.<br />Tente outro título para seu atividade.");
      break;
    }
  }
?>
    <section class="corpo col-sm-11 col-md-10">
      <?php navTopEventoMobile("atividade"); ?>
      <section class="row top-admin">
        <section class="row">
          <div class="col-sm-7" style='margin-bottom: 2rem'>
          <?php
            if($atividade['id'] === -1)
              echo "<h4><strong>+</strong> Nova Atividade</h4>";
            else
              echo "<h4> {$atividade['titulo']}</h4>";
          ?>
          </div>
        </section>
      </section>
	<section class="row">
    <?php if($atividade['id'] !== -1 && $atividade['img'] !== "padrao.png"){ ?>
      <form id="form-removerImg" method="post" <?php echo "action='{$dao}atualizar/atividade.php?e={$base64_evento}&a={$base64_id}'";?>>
        <input id="removerImg" name="removerImg" type="hidden" <?php echo "value='{$atividade['img']}'"; ?> />
      </form>
    <?php } ?>
		
	  <form enctype="multipart/form-data" method="post" <?php if($atividade['id'] === -1){ echo "action='{$dao}novo/atividade.php?e={$base64_evento}' class='col-xs-12'";}else{ echo "action='{$dao}atualizar/atividade.php?e={$base64_evento}&a={$base64_id}' class='col-md-6'";} ?>>
      <section class='row'>
        <div class='col-xs-12 form-group'>
          <label><span class='icon glyphicon glyphicon-picture'></span> Imagem da Atividade</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual imagem em miniatura utilizada para ilustrar sua atividade, deixando ele em branco será colocada uma imagem padrão. Caso queira colocar uma imagem clique em escolher arquivo, saiba que a imagem deve estar dentro das seguintes especificações: dimensão de 180px (Cento e Oitenta Pixels) por 180px (Cento e Oitenta Pixels), tamanho máximo de 2MB (Dois Megabyte) e nos formatos .png e .jpg."><span class='glyphicon glyphicon-question-sign'></span></a>

          <?php if($atividade['img'] !== ""){
            
              echo "<img class='block-middle' src='/public/uploads/img-atividades/{$atividade['img']}' style='margin-bottom: 15px'/>";
          }

          echo "<label for='arquivo' class='text-center' style='display: block; margin-bottom: 15px'>Dimensões: 180px por 180px - Tamanho máx: 2MB - Formato: .png ou .jpg)</label>";

          echo "<section class='row'>";
            echo "<div class='col-lg-8' style='margin-bottom: 15px'>";
              echo "<input type='file' id='arquivo' name='arquivo'>";
            echo "</div>";
            if($atividade['img'] !== "padrao.png"){
              echo "<div class='col-lg-2 text-center' style='margin-bottom: 15px'>";
                echo "<button form='form-removerImg' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Remover Imagem</button>";
              echo "</div>";
            }
          echo "</section>";
          ?>
        </div>
        <div <?php echo $class; ?>>
          <label for="titulo"><span class='glyphicon glyphicon-tags' style='top: 4px;'></span> Título (máx: 36 caracters)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo nomeará a atividade, deve no máximo conter 36 (Trinta e Seis) caracteres. Não é possível existir duas atividades com nomes iguais."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="titulo" class="form-control" type="text" name="titulo" <?php echo "value='{$atividade['titulo']}'" ?> maxlength="36" autofocus required />

        </div>
        <div <?php echo $class; ?>>
          <label for="ministrante"><span class='icon glyphicon glyphicon-user'></span> Ministrante (máx: 36 caracteres)</label>
          
          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar quem será responsável por ministrar tal atividade. Deve conter no máximo 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="ministrante" class="form-control" type="text" name ="ministrante" maxlength="36" <?php echo "value='{$atividade['ministrante']}'" ?> required />
        </div>
      </section>
      <section class="row">
        <div <?php echo $class; ?>>
          <?php
            if($result_cat = mysqli_query(banco(), "SELECT * FROM categorias")){
              if(mysqli_num_rows($result_cat)){
                echo "<label for='categoria'><span class='glyphicon glyphicon-certificate'></span> Categoria</label> ";

                echo "<a tabindex='90' class='duvida' role='button' data-toggle='popover' data-trigger='focus' data-content='Este campo você selecionará qual tipo de atividade ela se encaixa, podendo ser uma palestra, mini curso, visita técnica, etc. Caso não encontre a categoria desejada crie-a no menu cetegorias.'><span class='glyphicon glyphicon-question-sign'></span></a>";

                echo "<select id='categoria' class='form-control' name='categoria' required='true' >";
                while($cat = mysqli_fetch_array($result_cat)){  
                    if($atividade['id_categoria'] === $cat['id']){
                      echo "<option value='{$cat['id']}' selected>{$cat['titulo']}</option>";
                    }
                    else{
                      echo "<option value='{$cat['id']}'>{$cat['titulo']}</option>";
                    }
                  
                }
              }
              else{
                echo "<label for='Categoria'><span class='glyphicon glyphicon-certificate'></span> Categoria <span class='text-danger'>*Nenhuma categoria cadastrada</span></label>";
                echo "<select id='Categoria' class='form-control' name='local' required />";
              }
              echo "</select>";
            }
          ?>
        </div>
      </section>
      <section class="row">
        <div class='col-xs-12 form-group'>
          <label for="descricao"><span class="icon glyphicon glyphicon-pencil"></span> Descrição (máx: 500 caracteres)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Escreva um breve resumo sobre a atividade. Deve no máximo conter 500 caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <textarea id="descricao" class="form-control" type="text" maxlength="500" rows="5" name="descricao" required ><?php echo $atividade['descricao'] ?></textarea>
        </div>
      </section>
      <section class="row">
        <div class="col-md-6 form-group">
          <label for="hora_inicio"><span class="glyphicon glyphicon-time"></span> Horário de Início</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar o horário de início da atividade."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="hora_inicio" class="form-control" type="time" name="hora_inicio" <?php echo "value='{$atividade['hora_inicio']}'" ?> required />
        </div>
        <div class="col-md-6 form-group">
          <label for="hora_fim"><span class="glyphicon glyphicon-time"></span> Horário de Término</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar o horário de término da atividade."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="hora_fim" class="form-control" type="time" name="hora_fim" <?php echo "value='{$atividade['hora_fim']}'" ?>  required />
        </div>
      </section>
      <section class="row">
        <div class="col-md-6 form-group">
          <label for="data_inicio"><span class='glyphicon glyphicon-calendar'></span> Data</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar a data de quando dará início a atividade."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input class="form-control" id="data_inicio" type="date" name="data_inicio" <?php echo "value='{$atividade['data_inicio']}'" ?> required />
        </div>
        <div class="col-md-6 form-group">
          <label for="vagas_disp"><span class='glyphicon glyphicon-stats'></span> Vagas (mín: 0 máx: 900)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar a quantidade máxima de vagas disponibilizadas para esta atividade. O valor deve estar entre 0 (Zero) à 900 (Novecentos)."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="vagas_disp" class="form-control" type="number" name="vagas_disp" min="0" max="900" step="1" <?php echo "value='{$atividade['vagas_disp']}'" ?> required />
        </div>
      </section>
      <section class="row">
        <div <?php echo $class; ?>>
          <label for="local_atividade"><span class='glyphicon glyphicon-home'></span> Local (máx: 36 caracteres)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar o local onde será realizado a atividade, podendo em um laboratório, anfiteatro, um local totalmente diferento do informado no evento, etc. Deve conter no máximo 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="local_atividade" class="form-control" type="text" name="local_atividade" maxlength="36" <?php echo "value='{$atividade['local_atividade']}'" ?> required />
        </div>
      </section>
      <section <?php echo $classSalvar; ?> style='margin-bottom: 2rem;'>
        <button class='btn btn-success' style="width: 50%; margin-bottom: 15px;" ><span class='glyphicon glyphicon-floppy-disk' style='padding-right: 2px'></span> Salvar</button>
      </section>
		</form>
    <?php if($atividade['id'] !== -1){ ?>
      <div class="col-md-6">
        <section class="row">
          <div class="col-xs-7" style='margin-bottom: 15px'>
            <label style='padding-top: 6px;'><span class='icon glyphicon glyphicon-user'></span> Participantes</label>
          </div>
          <div class="col-xs-5 text-center" style='margin-bottom: 2rem'>
            <a class='btn btn-info' <?php echo "href='presenca.php?e={$base64_evento}&a={$base64_id}'" ?> style='width: 100%'><span class='icon glyphicon glyphicon-qrcode'></span> Presença</a>
          </div>
          <div class="col-xs-12" style='margin-bottom: 2rem'>
            <label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar participante</label>
            <input id='busca' type="search" name="busca" placeholder="Buscar por participante..." class="form-control">
          </div>
        </section>

        <input type="hidden" id="evento" <?php echo "value='{$base64_evento}'"; ?> />
        <input type="hidden" id="atividade" <?php echo "value='{$base64_id}'"; ?> />

        <div id='tblUsuarios' class='col-xs-12' style='overflow: hidden'></div>

        <?php require_once("../paginacao.php"); ?>

        <div id='div-modalParticipante'></span>
      </div>
    <?php } ?>
    </div>
	</section>
  </section>
</main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script src='/public/js/tabela.js'></script>
<script>
  var url 	      = "../tabela.php";
  var tabela 	    = "Usuarios";
  var pagina 	    = $("#pagina").val();
  var evento 	    = $("#evento").val();
  var atividade 	= $("#atividade").val();
  var busca 	    = $("#busca").val();

	$(window).load(function(){
    
		atualizaTabelaUsuario(url, tabela, evento, atividade, busca, pagina);

		$("#busca").keyup(function(){
			texto = $("#busca").val();

			atualizaTabelaUsuario(url, tabela, evento, atividade, texto, pagina);
    });    
    
    $(function () {
      $('[data-toggle="popover"]').popover()
    });
  });

  function showModalParticipante(participante){
    console.log(participante);
    $.ajax({
      method: "POST",
      url: "modalParticipante.php",
      data: {p: participante},

      success: function(data){
        $("#div-modalParticipante").html(data);
        $("#modalParticipante").modal("show");
        console.log("Deu certo");
      }
    });
  }
</script>
</body>
</html>