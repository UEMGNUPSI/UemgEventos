<?php
    if(isset($_GET['a'])){
        $id = htmlentities(base64_decode($_GET['a']));

        session_start();
    
        require_once('dao/bd.php');

        require_once('config.php');

        $objBd = new bd();
        $link = $objBd->conecta_mysql();

        if($result = mysqli_query($link, "SELECT a.*, c.titulo categoria FROM atividades a INNER JOIN categorias c ON a.id_categoria = c.id WHERE a.id = {$id}")){
            $atv = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $dia_inicio = strftime("%A, %d/%b", strtotime($atv['data_inicio']));

            $hora_inicio = strftime("%H:%M", strtotime($atv['hora_inicio']));
            $hora_fim = strftime("%H:%M", strtotime($atv['hora_fim']));

            echo "<div class='modal-dialog' role='document'>";
                echo "<div class='modal-content'>";
                    echo "<header class='modal-header' style='background: #3c6e8f; color: #e4eaf4;'>";
                        echo "<button type='button' class='close' data-dismiss='modal' aria-label=Close'><span aria-hidden='true'>&times;</span></button>";
                        echo "<h4 class='modal-title'>{$atv['titulo']}</h4>";
                    echo "</header>";
                    echo "<div class='moda-body' style='padding: 0 1rem;'>";
                        echo "<section class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='item-info'>";
                                    echo "<p class='item-label text-red'><span class='glyphicon glyphicon-user'	></span> Ministrante</p>";
                                    echo "<p style='text-transform: capitalize'>{$atv['ministrante']}</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</section>";
                        echo "<section class='row'>";
                            echo "<div class='col-sm-6'>";
                                echo "<div class='item-info'>";
                                    echo "<p class='item-label text-red'><span class='glyphicon glyphicon-calendar'	></span> Data</p>";
                                    echo "<p style='text-transform: capitalize'>{$dia_inicio}</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='col-sm-6'>";
                                echo "<div class='item-info'>";
                                    echo "<p class='item-label text-red'><span class='glyphicon glyphicon-time'	></span> Horário</p>";
                                    echo "<p style='text-transform: capitalize'>{$hora_inicio} até {$hora_fim}</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='col-md-6'>";
                                echo "<div class='item-info'>";
                                    echo "<p class='item-label text-red'><span class='glyphicon glyphicon-map-marker'	></span> Local</p>";
                                    echo "<p style='text-transform: capitalize'>{$atv['local_atividade']}</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='col-md-6'>";
                                echo "<div class='item-info'>";
                                    echo "<p class='item-label text-red'><span class='glyphicon glyphicon-certificate'	></span> Categoria</p>";
                                    echo "<p style='text-transform: capitalize'>{$atv['categoria']}</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</section>";
                        echo "<section class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<section class='row descricao' style='margin-bottom: 10px'>";
                                    echo "<h4>Descrição</h4>";
                                    echo "<p align='justify'>{$atv['descricao']}</p>";
                                echo "</section>";
                            echo "</div>";
                        echo "</section>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
    }
?>