<?php
    session_start();
    
    require_once('dao/bd.php');

    require_once('config.php');

    $objBd = new bd();
    $link = $objBd->conecta_mysql();

    if(isset($_GET['q'])){
        $id = htmlentities(base64_decode($_GET['q']));

        $pagina = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;

        $registros = 7;

        # Inicio SQL Atividades.
            $sql = "SELECT id, titulo, vagas_disp, id_evento, data_inicio, hora_fim FROM atividades WHERE id_evento = {$id} ORDER BY data_inicio";
            
            $total = mysqli_num_rows(mysqli_query($link, $sql));

            $numPaginas = ceil($total/$registros);

            $inicio = ($registros*$pagina)-$registros;

            $sql .= " LIMIT $inicio, $registros";

            $atividades = mysqli_query($link, $sql);

			$rows = mysqli_num_rows($atividades);
		# Fim SQL Atividades.
    }

    function tabelaAtividades($atv){
        echo "<tr>";
            echo "<td class='td-atividade'>";
                echo "<input name='info' type='hidden' value=".base64_encode($atv['id'])." />";
                echo $atv['titulo'];
            echo "</td>";
            echo "<td align='center'>";
                echo $atv['vagas_disp'];
            echo "</td>";

            if(isset($_SESSION['user']) && !$_SESSION['admin']){    # Esta logado.
                $objBd = new bd();
                $link = $objBd->conecta_mysql();
        
                $data_fim = strtotime($atv['data_inicio']);
                
                $hora_fim = strtotime($atv['hora_fim']);

                if((strftime("%Y-%m-%d", $data_fim) < date("Y-m-d")) || ((strftime("%Y-%m-%d", $data_fim) === date("Y-m-d")) && (strftime("%H:%M", $hora_fim) <= date("H:M")))){ # Atividade encerrada.
                    echo "<td class='encerrada' align='center'>";
                        echo "<span style='white-space: nowrap; color: #000000a6;'>Atividade Encerrada</span>";
                    echo "</td>";
                }
                else{
                    $sql = "SELECT ep.pagamento pag FROM usuarios u 
                                 INNER JOIN evento_pago ep ON u.id = ep.usuario 
                                 WHERE u.email = '{$_SESSION['user']}' 
                                 AND ep.evento = {$atv['id_evento']}";

                    $result = mysqli_fetch_array(mysqli_query($link, $sql));

                    mysqli_close($link);

                    if($atv['vagas_disp'] < 1){         # Vagas esgotadas.
                        echo "<td style='background: #e31837;' align='center'>";
                            echo "<span style='white-space: nowrap; color: #ffdee3'>Vagas esgotadas</span>";
                        echo "</td>";
                    }
                    else if(!$result){          # Não participante do evento.
                        echo "<td style='background: #a39900;' align='center'>";
                            echo "<span style='white-space: nowrap; color: #403d16'>Participe do evento para inscrever-se</span>";
                        echo "</td>";
                    }
                    else if($result['pag']){            # Pagamento aceito.
                        echo "<td>";
                            echo "<button class='btn-custom inscrever'><span class='glyphicon glyphicon-plus' style='top: 2px'></span> Inscrever-se</button>";
                        echo "</td>";
                    }
                    else{
                        echo "<td>";
                            echo "<span style='white-space: nowrap; color: #403d16'>Pagamento ainda não aceito.</span>";
                        echo "</td>";
                    }
                }                
            }
            
        echo "</tr>";
    }
?>
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th style='width: 90%'>Atividade</th>
            <th>Vagas</th>
            <?php
                if(isset($_SESSION['user']) && !$_SESSION['admin'])
                    echo "<th>Opção</th>";
            ?>                    
        </tr>
    </thead>
    <tbody>
        <?php 
            if($rows)
                while($atividade = mysqli_fetch_array($atividades)){
                    tabelaAtividades($atividade);
                }
            else{
                echo "<tr>";
                    echo "<td align='center' colspan='3'>";
                        echo "Não há nenhuma atividade neste evento!";
                    echo "</td>";
                echo "</tr>";
            }

            mysqli_close($link);
        ?>
    </tbody>
</table>

<section id='modalAtividade' class='modal fade' tabindex='-1' role='dialog'></section>

<script>
    $(".td-atividade").click(function(){
        var info = $(this).parent().find('[name="info"]').val();

        $.ajax({
            url: "modalAtividade.php?a="+info,

            success: function(data){
                $("#modalAtividade").html(data);
                $("#modalAtividade").modal("show");
            }
        });
    });

    $("#modalAtividade").on('show.bs.modal', function(e){
      $("nav").css("padding-right", "16px");
    });
    
    $("#modalAtividade").on('hidden.bs.modal', function(e){
        $("nav").removeAttr('style');
    });
</script>