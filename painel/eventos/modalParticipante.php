<?php
    $id_par = base64_decode(filter_input(INPUT_POST, "p", 
                 FILTER_SANITIZE_SPECIAL_CHARS));

    require_once("../utilitarios.php");

    $participante = mysqli_fetch_array(
        mysqli_query(
            banco(), 
            "SELECT u.*, c.titulo curso 
             FROM usuarios u 
             INNER JOIN cursos c ON u.id_curso = c.id 
             WHERE u.id = {$id_par}"
        ),
        MYSQLI_ASSOC
    );

    $participante['telefone'] = empty($participante['telefone']) ? "Não Informado" : $participante['telefone'];
?>
<section id='modalParticipante' class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <header class="modal-header bg-dark-yellow">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-white"><?php echo $participante['nome']; ?></h4>
      </header>
      <section class="modal-body">
        <section class="row">
          <div class="col-md-12">
            <label class='text-red'><span class='icon glyphicon glyphicon-asterisk'></span> CPF</label>
            <p><?php echo $participante['cpf']; ?></p>
          </div>
          <div class="col-md-6">
            <label class='text-red'><span class='icon glyphicon glyphicon-envelope'></span> E-MAIL</label>
            <p><?php echo $participante['email']; ?></p>

            <label class='text-red'><span class='icon glyphicon glyphicon-blackboard'></span> CURSO</label>
            <p><?php echo $participante['curso']; ?></p>
          </div>
          <div class="col-md-6">
            <label class='text-red'><span class='icon glyphicon glyphicon-earphone'></span> TELEFONE</label>
            <p><?php echo $participante['telefone']; ?></p>

            <label class='text-red'><span class='icon glyphicon glyphicon-modal-window'></span> RA</label>
            <p><?php echo $participante['ra']; ?></p>
          </div>
        </section>  
      </section>
    </div>
  </div>
</section>
<script>
  
</script>
