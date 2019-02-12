<?php 

require_once("../utilitarios.php");

$atividade = array(
  "id"            => -1,
  "titulo"        => "",
  "descricao"     => "",
  "evento"        => "",
  "categoria"     => "",
  "vagas_total"   => "",
  "vagas_disp"    => "",
  "ministrante"   => "",
  "data"          => "",
  "hora_inicio"   => "",
  "hora_fim"      => "",
  "local"         => ""

);

// Evento!
if(isset($_GET['e'])){

  $evento = base64_decode(filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS));

  $base64_evento = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);

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

?>

<!DOCTYPE html>
<html>
<head>
  <?php
    require_once("../head.php");

    head("Atividades");
  ?>
</head>
<body>
<main class='container-fluid'>
  <section class="row">
<?php
    require_once("../nav.php");
    navbar("eventos");

    navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$titulo_evento}", "atividade", "../eventos/eventos.php?e={$base64_evento}");

  include_once("{$root}dialog.php");
  if(isset($_SESSION['success'])){
    switch(base64_decode($_SESSION['success'])){
      case '1':
        dialog("success", "Atividade salva com sucesso!");
      break;
      case '2':
        dialog("success", "Atividade atualizada com sucesso!");
      break;
      case '3':
        dialog("success", "Atividade excluida com sucesso!");
      break;
      case '7':
        dialog("success", "Banner removido com sucesso!");
      break;
      case '8':
        dialog("success", "Edital removido com sucesso!");
      break;
      
    }
  }  

  if(isset($_SESSION['erro'])){
    switch(base64_decode($_SESSION['erro'])){
      case '1':
        dialog("erro", "Não foi possível salvar este evento!<br />Tente novamente mais tarde.");
      break;
      case '2':
        dialog("erro", "Não foi possível atualizar este evento!<br />Tente novamente mais tarde.");
      break;
      case '3':
        dialog("erro", "O banner não está dentro dos requisitos necessários.");
      break;
      case '4':
        dialog("erro", "O edital não está dentro dos requisitos necessários.");
      break;
      case '5':
        dialog("erro", "Tamanho excedido para o banner.");
      break;
      case '6':
        dialog("erro", "Tamanho excedido para o edital.");
      break;
      case '7':
        dialog("erro", "Não foi possível remover o banner deste evento!<br />Tente novamente mais tarde.");
      break;
      case '8':
        dialog("erro", "Não foi possível remover o edital deste evento!<br />Tente novamente mais tarde.");
      break;
      case '9':
        dialog("alert", "Você não tem permissão para acessar essa página!");
      break;
      case '10':
        dialog("erro", "Não foi possível excluir a atividade deste evento!<br />Tente novamente mais tarde.");
      break;
      case '11':
        dialog("alert", "Nome existente.<br />Tente outro título para seu evento.");
      break;
      case '12':
        dialog("erro", "Não foi possível excluir esta atividade! Pode ser que ainda há participantes inscritos na atividade ou tente novamente mais tarde.");
      break;
    }
  }
?>
        <section class="corpo col-sm-11 col-md-10">
          <?php navTopEventoMobile("atividade"); ?>
          <section class="row top-admin">
            <section class="row">
              <div class="col-sm-7" style='margin-bottom: 2rem'>
                <label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar atividade</label>
                <input id='busca' type="search" name="busca" placeholder="Buscar por atividades..." class="form-control">
              </div>
            </section>
          </section>
          <section class="row" style='margin-top: 2rem;'>
            <a class="btn btn-primary btn-novo" <?php echo "href='atividade.php?e={$base64_evento}'" ?>><span class="icon glyphicon glyphicon-plus" style='left: .5px'></span></a>

            <input type="hidden" id="evento" <?php echo "value='{$base64_evento}'"; ?> />

            <div id='tblAtividades' class='col-xs-12'></div>

            <?php require_once("../paginacao.php"); ?>
          </section>
        </section>
    </section>
</main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script src='/public/js/tabela.js'></script>
<script>
  var url 	  = "../tabela.php";
  var tabela 	= "Atividades";
  var pagina 	= $("#pagina").val();
  var status 	= $("#evento").val();
  var texto   = $("#busca").val();
    
	$(window).load(function(){
		atualizaTabelaStatus(url, tabela, status, texto, pagina);

		$("#busca").keyup(function(){
			texto = $("#busca").val();

			atualizaTabelaStatus(url, tabela, status, texto, pagina);
		});
	});
</script>

</body>
</html>