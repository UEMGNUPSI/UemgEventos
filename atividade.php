<!-- Atividade -->
<?php

while($atividades = mysqli_fetch_array($pagina_atv,MYSQLI_ASSOC)){
    $realizado = 0;
    $login = 0;

    $data_inicio        =           new DateTime($atividades['data_inicio']);
    $hora_inicio        =           new DateTime($atividades['hora_inicio']);
    $hora_fim           =           new DateTime($atividades['hora_fim']);

    $id = base64_encode($atividades['id_evento']);

    if((strftime("%Y-%m-%d", strtotime($atividades['data_inicio'])) <   date("Y-m-d")) || 
        ((strftime("%Y-%m-%d", strtotime($atividades['data_inicio'])) === date("Y-m-d")) &&
        (strftime("%H:%M",    strtotime($atividades['hora_fim']))    <=  date("H:M"))))
            $realizado = 1;

    if(isset($_SESSION['user'])){
        $id_user = mysqli_fetch_array(
            mysqli_query(
                $link,
                "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}'"
            ),
            MYSQLI_ASSOC
        );

        $login = 1;
    }

    // Caso a atividade já tenha acontecido, pela data ela terá uma mensagem de finalizada.

    $sql = "SELECT titulo, valor FROM eventos WHERE id = ".$atividades['id_evento'];

    if($result_evento = mysqli_query($link,$sql)){
        $evento = mysqli_fetch_array($result_evento, MYSQLI_ASSOC);

        echo "<section class='col-lg-12 atividades'>";
            echo "<header class='row titulo'>";
                echo '<div class="col-lg-10">';
                    echo "<h3>{$atividades['titulo']}</h3>";
                echo "</div>";
                
                $classVagaDisplay = "visible-md-inline visible-lg-inline";
                
                if($login && !$realizado && $atividades['vagas_disp'] > 0){     # Usuário logado.

                    $sql = "SELECT * FROM usuario_atividade WHERE usuario = {$id_user['id']} AND atividade = {$atividades['id']}";

                    $rows_insc = mysqli_num_rows(mysqli_query($link, $sql));

                    $classVaga = "disp";
                    if($rows_insc){     # Usuário inscrito.
                        echo "<div class='col-lg-2' style='padding: 0'>";
                            echo "<a tittle='Clique para se desinscrever!' class='btn-custom inscrever' href='dao/user/inscrever.php?id={$atividades["id"]}&ide={$atividades['id_evento']}&l=".base64_encode($_SERVER['REQUEST_URI'])."'>";
                                echo "<span id='icon-plus' class='glyphicon glyphicon-ok'></span> Inscrito";
                            echo "</a>";
                        echo "</div>";
                    }
                    else if($atividades['vagas_disp'] > 0){     # Vaga disponível.
                        echo "<div class='col-lg-2' style='padding: 0'>";
                            echo"<a class='btn-custom inscrever' href='dao/user/inscrever.php?id={$atividades['id']}&ide={$atividades['id_evento']}&l=".base64_encode($_SERVER['REQUEST_URI'])."'>";
                                echo "<span id='icon-plus' class='glyphicon glyphicon-plus'></span> Inscreva-se";
                            echo "</a>";
                        echo "</div>";
                    }
                }
                else if($realizado){    # Atividade encerrada.
                    echo "<div class='col-lg-2 encerrada'>";
                        echo "<p>Atividade encerrada!</p>";
                    echo "</div>";
                }
                else if(!$realizado && !$atividades['vagas_disp']){
                    echo "<div class='col-lg-2 encerrada'>";
                        echo "<p>Vagas Esgotadas!</p>";
                    echo "</div>";
                }

                if(!$realizado && $atividades['vagas_disp'] > 0){       
                    if(!$login){# Não logado.
                        echo "<div class='col-md-2' style='padding: 0'>";
                            echo'<button class="btn-custom inscrever block" onclick="inscrever()"><span id="icon-plus" class="glyphicon glyphicon-lock"></span> Inscreva-se</button>';
                        echo "</div>";
                    }
                    $classVaga = "disp";
                }
                else{
                    $classVaga = "sem-vagas";
                }
                echo "<div class='visible-xs-block visible-sm-block vagas-mobile {$classVaga}'>";
                    echo "<h4>{$atividades['vagas_disp']}</h4>";
                    echo "<p>Vagas Restantes</p>";
                echo "</div>";
            echo "</header>";

            # Corpo da atividade.
            echo "<div class='row corpo'>";
                echo "<figure class='col-md-3' style='margin-top: 3.571%;'>";
                    echo "<img class='img-atividade middleX' src='uploads/img-atividades/{$atividades['img']}'>";
                echo "</figure>";
                echo "<div class='col-md-9'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-9' style='margin-right: 2.8%'>";
                            echo "<div class='item-info'>";
                                echo "<p class='item-label text-red'><span class='glyphicon glyphicon-flag'	></span> Evento</p>";
                                echo "<h4 style='margin: 0;'><a class='link-evento' href='perfil_evento.php?q={$id}'>{$evento['titulo']}</a></h4>";
                            echo "</div>";
                            
                        echo "</div>";
                        echo "<div class='col-md-2 vagas-corpo {$classVaga} {$classVagaDisplay}'>";
                            echo "<h4>{$atividades['vagas_disp']}</h4>";
                            echo "<p>Vagas Restantes</p>";
                        echo "</div>";    
                    echo "</div>";

                    echo "<div class='item-info'>";
                        echo "<p class='item-label text-red'><span class='glyphicon glyphicon-user'	></span> Ministrante</p>";
                        echo "<p style='text-transform: capitalize'>{$atividades['ministrante']}</p>";
                    echo "</div>";
                    
                    echo "<section class='row'>";
                        echo "<div class='col-xs-6'>";
                            echo "<div class='item-info'>";
                                echo "<p class='item-label text-red'><span class='glyphicon glyphicon-calendar'	></span> Data</p>";
                                echo "<p>{$data_inicio->format('d/m/y')}</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='col-xs-6'>";
                            echo "<div class='item-info'>";
                                echo "<p class='item-label text-red'><span class='glyphicon glyphicon-calendar'	></span> Horário</p>";
                                echo "<p>{$hora_inicio->format('H:i')} até {$hora_fim->format('H:i')}</p>";
                            echo "</div>";
                        echo  "</div>";         
                    echo "</section>";
                    echo "<section class='row'>";
                        echo "<div class='col-md-6'>";
                            echo "<div class='item-info'>";
                                echo "<p class='item-label text-red'><span class='glyphicon glyphicon-map-marker'	></span> Local</p>";
                                echo "<p>{$atividades['local_atividade']}</p>";
                            echo "</div>";
                            
                        echo "</div>";
                        echo "<div class='col-md-6'>";
                            echo "<div class='item-info'>";
                                echo "<p class='item-label text-red'><span class='icon glyphicon glyphicon-certificate'	></span> Categoria</p>";
                                echo "<p>{$atividades['categoria']}</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</section>";
                echo "</div>";
                
            echo "</div>";
            echo "<section class='row descricao'>";
                echo "<h4>Descrição</h4>";
                echo "<p align='justify'>{$atividades['descricao']}</p>";
            echo "</section>";
            
            if($evento['valor'] > 0){
                echo "<footer class='row pago'>";
                    echo '<p>Esta atividade perterce à um <b>evento pago</b>!<p>';
                echo "</footer>";
            }
        echo  '</section>';
    }
}

?>