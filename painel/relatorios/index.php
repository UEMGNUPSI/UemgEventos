<?php 

require_once("../utilitarios.php");

$status = isset($_POST['status']) ? filter_input(INPUT_POST, 'status', 
FILTER_SANITIZE_SPECIAL_CHARS) : "Ativo";

function getEvento($id_admin){
  if($id_admin !== 1)
    $eventos = mysqli_query(banco(), "SELECT id, titulo FROM eventos WHERE status = 'Ativo' AND adm = {$id_admin} ORDER BY titulo");
  else
    $eventos = mysqli_query(banco(), "SELECT id, titulo FROM eventos WHERE status = 'Ativo' ORDER BY titulo");

  return mysqli_fetch_all($eventos, MYSQLI_ASSOC);
}

function getEventoPago($id_admin){
  if($id_admin !== 1)
    $eventos = mysqli_query(banco(), "SELECT id, titulo FROM eventos WHERE status = 'Ativo' AND valor > 0 AND adm = {$id_admin} ORDER BY titulo");
  else
    $eventos = mysqli_query(banco(), "SELECT id, titulo FROM eventos WHERE status = 'Ativo' AND valor > 0 ORDER BY titulo");

  return mysqli_fetch_all($eventos, MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php 
		require_once("../head.php");
		head("Relatórios");
	?>	
</head>
<body>
	<main class="container-fluid">
		<section class='row'>
			<?php 

				require_once("../nav.php");
				navbar("relatorios");

				navTop("<span class='icon glyphicon glyphicon-file'></span> Relatórios Disponíveis");

				include_once("{$root}dialog.php");
				if(isset($_SESSION['success'])){
					switch(base64_decode($_SESSION['success'])){
						case '1':
							dialog("success", "Evento salvo com sucesso!");
						break;
						case '3':
							dialog("success", "Evento excluido com sucesso!");
						break;
					}
				}

				if(isset($_SESSION['erro'])){
					switch(base64_decode($_SESSION['erro'])){
						case '3':
							dialog("erro", "Não foi possível excluir este evento! Pode ser que ainda há atividades cadastradas ou tente novamente mais tarde.");
						break;
						case '9':
							dialog("alert", "Você não tem permissão para acessar essa página!");
						break;
					}
        }

        $id_admin = getId($_SESSION['user']);

        if($id_admin != 1){
          $eventos_ativos = mysqli_num_rows(mysqli_query(banco(), "SELECT id FROM eventos WHERE status = 'ativo' AND adm = {$id_admin}"));

          $atividades_criadas = mysqli_num_rows(
            mysqli_query(
              banco(), 
              "SELECT a.id FROM atividades a 
               LEFT JOIN eventos e ON a.id_evento = e.id
               WHERE e.status = 'ativo' 
               AND e.adm = {$id_admin}"
            )
          );

          $participantes = mysqli_num_rows(
            mysqli_query(
              banco(), 
              "SELECT u.id FROM usuarios u 
               LEFT JOIN evento_pago ep ON u.id = ep.usuario 
               LEFT JOIN eventos e ON ep.evento = e.id 
               WHERE e.status = 'Ativo' 
               AND ep.pagamento = 1 
               AND e.adm = {$id_admin}"
            )
          );
        }
        else{
          $eventos_ativos = mysqli_num_rows(mysqli_query(banco(), "SELECT id FROM eventos WHERE status = 'ativo'"));
          
          $atividades_criadas = mysqli_num_rows(
            mysqli_query(
              banco(), 
              "SELECT a.id FROM atividades a 
               LEFT JOIN eventos e ON a.id_evento = e.id
               WHERE e.status = 'ativo' "
            )
          );

          $participantes = mysqli_num_rows(
            mysqli_query(
              banco(), 
              "SELECT u.id FROM usuarios u 
               LEFT JOIN evento_pago ep ON u.id = ep.usuario 
               LEFT JOIN eventos e ON ep.evento = e.id 
               WHERE e.status = 'Ativo' 
               AND ep.pagamento = 1 "
            )
          );
        }

      ?>
	    <section class="corpo col-sm-11 col-md-10">
        <section class="row top-admin hidden-xs hidden-sm">
          <div class="col-md-3 card bg-dark-blue text-white" style="margin-left: 4.15151515%">
            <h3><?php echo $eventos_ativos; ?></h3>
            <p>Eventos Ativos</p>
          </div>
          <div class="col-md-3 col-md-offset-1 card bg-dark-yellow text-white">
            <h3><?php echo $atividades_criadas; ?></h3>
            <p>Total de Atividades</p>
          </div>
          <div class="col-md-3 col-md-offset-1 card bg-dark-red text-white">
            <h3><?php echo $participantes; ?></h3>
            <p>Total de Participantes</p>
          </div>
        </section>

        <section class="row">
          <header class='text-center text-red' style='margin-top: 15px'>
            <label style='margin-bottom: 15px;'>Tipos de Relatórios</label>
          </header>
        </section>
        <section class='row'>
          <div class='col-sm-7'>
            <p class='p-relatorio'>Todos os eventos</p>
          </div>
          <div class='col-sm-2 text-center'>
            <a class='btn btn-primary' href='eventos.php' target='_blank'><span class='icon glyphicon glyphicon-print'></span> Gerar</a>
          </div>
        </section>
        <section class='row'>
          <div class='col-sm-12'>
            <p class='p-relatorio'>Vagas Esgotadas</p>
          </div>
          <?php
            echo "<div class='col-sm-7'>";
              echo "<select id='evtVagas' class='form-control' style='margin-bottom: 6px'>";
                foreach($eventos = getEvento($id_admin) as $evento){
                  echo "<option value='".base64_encode($evento['id'])."'>{$evento['titulo']}</option>";
                }
              echo "</select>";

            unset($eventos);
            echo "</div>";
          ?>
          <div class='col-sm-2 text-center'>
            <a id='btnVagas' class='btn btn-primary' target='_blank'><span class='icon glyphicon glyphicon-print'></span> Gerar</a>
          </div>
        </section>
        <section class="row">
          <div class='col-xs-12'>
            <p class='p-relatorio'>Atividades Disponíveis</p>
          </div>
            <?php
              echo "<div class='col-sm-7'>";
                echo "<select id='evtAtvDisp' class='form-control' style='margin-bottom: 6px'>";
                  foreach($eventos = getEvento($id_admin) as $evento){
                    echo "<option value='".base64_encode($evento['id'])."'>{$evento['titulo']}</option>";
                  }
                echo "</select>";

                unset($eventos);
              echo "</div>";
            ?>
          <div class='col-sm-2 text-center'>
            <a id='btnAtvDisp' class='btn btn-primary' target='_blank'><span class='icon glyphicon glyphicon-print'></span> Gerar</a>
          </div>
        </section>
          
        <section class='row'>
          <div class='col-xs-12'>
            <p class='p-relatorio'>Pagamento</p>
          </div>
          <?php
            echo "<div class='col-sm-7'>";
              echo "<select id='evtPagamento' class='form-control' style='margin-bottom: 6px'>";
                foreach($eventos = getEventoPago($id_admin) as $evento){
                  echo "<option value='".base64_encode($evento['id'])."'>{$evento['titulo']}</option>";
                }
              echo "</select>";

              unset($eventos);
            echo "</div>";
          ?>
          <div class='col-sm-2 text-center'>
            <a id='btnPagamento' class='btn btn-primary' target='_blank'><span class='icon glyphicon glyphicon-print'></span> Gerar</a>
          </div>
        </section>
        <section class='row'>
          <div class='col-xs-12'>
            <p class='p-relatorio'>Presença</p>
          </div>
            <?php
              echo "<div class='col-sm-7'>";
                echo "<label for='evtPresenca' class='lbl-relatorio'>Evento</label>";
                echo "<select id='evtPresenca' class='form-control' style='margin-bottom: 6px'>";
                  foreach($eventos = getEvento($id_admin) as $evento){
                    echo "<option value='".base64_encode($evento['id'])."'>{$evento['titulo']}</option>";
                  }
                echo "</select>";

                echo "<label for='atvPresenca' class='lbl-relatorio'>Atividades</label>";

                echo "<select id='atvPresenca' class='form-control' style='margin-bottom: 6px'></select>";
                echo "<div ></div>";

                unset($eventos);
              echo "</div>";
            ?>
          </div>
          <div class="col-sm-2 text-center" style='margin-bottom: 6px'>
            <a id='btnPresenca' class='btn btn-primary' target='_blank'><span class='icon glyphicon glyphicon-print'></span> Gerar</a>
          </div>
        </section>
      </section>
    </section>
  </main>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
	function confirmar(id) {
    var apagar = confirm("Confirma a exclusão?");
    if (apagar){
        location.href = 'apagar_evento.php?id='+ id;
    }
  }

  $("#btnVagas").attr("href", "vagasEsgotadas.php?e="+$("#evtVagas").val());

  $("#btnAtvDisp").attr("href", "atividadeDisponivel.php?e="+$("#evtAtvDisp").val());

  $("#btnPagamento").attr("href", "pagamento.php?e="+$("#evtPagamento").val());
  
  $.ajax({
    method: "POST",
    url: "selectAtividades.php",
    data: {evento: $("#evtPresenca").val()},

    success: function(data){
      $("#atvPresenca").html(data);

      $("#btnPresenca").attr("href", "presenca.php?e="+$("#evtPresenca").val()+"&a="+$("#atvPresenca").val());
    }
  });

  $("#evtPresenca").change(function(){
    $.ajax({
      method: "POST",
      url: "selectAtividades.php",
      data: {evento: $("#evtPresenca").val()},

      success: function(data){
        $("#atvPresenca").html(data);

        $("#btnPresenca").attr("href", "presenca.php?e="+$("#evtPresenca").val()+"&a="+$("#atvPresenca").val());
      }
    });
  });

  $("#evtVagas").change(function(){
    $("#btnVagas").attr("href", "vagasEsgotadas.php?e="+$("#evtVagas").val());
  });

  $("#evtAtvDisp").change(function(){
    $("#btnAtvDisp").attr("href", "atividadeDisponivel.php?e="+$("#evtAtvDisp").val());
  });

  $("#evtPagamento").change(function(){
    $("#btnPagamento").attr("href", "pagamento.php?e="+$("#evtPagamento").val());
  });
  
  $("#atvPresenca").change(function(){
    $("#btnPresenca").attr("href", "presenca.php?e="+$("#evtPresenca").val()+"&a="+$("#atvPresenca").val());
  });

</script>
</body>
</html>