<?php 

require_once("../utilitarios.php");

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
else{
  $_SESSION['erro'] = base64_encode(9);
  header("Location: ../eventos/");
  
  die();
}
  
?>

<!DOCTYPE html>
<html>
<head>
  <?php
    require_once("../head.php");

    head("Projetos");
  ?>
</head>
<body>
<main class='container-fluid'>
  <section class="row">
    <?php
      require_once("../nav.php");
      navbar("eventos");

      navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$titulo_evento}", "projeto", "../eventos/eventos.php?e={$base64_evento}");

      include_once("{$root}dialog.php");
      if(isset($_SESSION['success'])){
        switch(base64_decode($_SESSION['success'])){
          case '1':
            dialog("success", "Projeto avaliado com sucesso!");
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
            dialog("erro", "Não foi possível avaliar este projeto!<br />Tente novamente mais tarde.");
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
      <?php navTopEventoMobile("projeto"); ?>
      <section class="row top-admin">
        <section class="row">
          <div class="col-sm-7" style='margin-bottom: 2rem'>
            <label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar projeto</label>
            <input id='busca' type="search" name="busca" placeholder="Buscar por projetos..." class="form-control">
          </div>
          <div class="col-sm-5">

              <label style="display: block;"><span class='icon glyphicon glyphicon-cog'></span> Opção</label>

              <input id="rdoTitulo" type="radio" name="status" value="p.nome" checked> <label for="rdoTitulo"> Título</label>

              <input id="rdoAutor" type="radio" name="status" value="u.nome" style="margin-left: 20px;"> <label for="rdoAutor"> Autor</label>
          </div>
        </section>
      </section>
      <section class="row" style='margin-top: 2rem;'>
        <div class="col-md-12">
          <p>Legenda para tabela.</p>
        </div>
        <div class="col-md-6">
          <div class="col-xs-1 bg-aprovado" style='height: 20px'></div>
          <div class="col-xs-10">
            <p>Aprovados</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="col-xs-1 bg-reprovado" style='height: 20px'></div>
          <div class="col-xs-10">
            <p>Reprovados</p>
          </div>
        </div>
        
        <input type="hidden" id="evento" <?php echo "value='{$base64_evento}'"; ?> />

        <div id='tblProjetos' class='col-xs-12'></div>

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
  var tabela 	= "Projetos";
  var pagina 	= $("#pagina").val();
  var status 	= $("input[type=radio]:checked").val();
  var evento 	= $("#evento").val();
  var texto   = $("#busca").val();
    
	$(window).load(function(){
		atualizaTabelaProjetos(url, tabela, evento, status, texto, pagina);

		$("#busca").keyup(function(){
			texto = $("#busca").val();

			atualizaTabelaProjetos(url, tabela, evento, status, texto, pagina);
    });

    $("input[type=radio]").change(function(){
      texto = $("#busca").val();
      status 	= $("input[type=radio]:checked").val();

			atualizaTabelaProjetos(url, tabela, evento, status, texto, pagina);
    });
	});
</script>
</body>
</html>