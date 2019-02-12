<?php
require_once("utilitarios.php");

if(isset($_POST['tabela']) && $_POST['tabela'] !== ""){
    $tabela         =   filter_input(INPUT_POST, 'tabela', 
                        FILTER_SANITIZE_SPECIAL_CHARS);

    $base64_evento  =   filter_input(INPUT_POST, 'status', 
                        FILTER_SANITIZE_SPECIAL_CHARS);

    $evento         =   base64_decode(filter_input(INPUT_POST,
                        'status', FILTER_SANITIZE_SPECIAL_CHARS));

    $pagina         =   isset($_POST['pagina']) ? 
                        filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_SPECIAL_CHARS) : 1;
    
    $tabela     = strtolower($tabela);

    $total      = 0;
    $numPaginas = 0;
}    
else
    die("É necessário informar qual tabela pesquisar.");

function getDados($tabela){

    $busca = isset($_POST['busca']) ? filter_input(INPUT_POST, 'busca', FILTER_SANITIZE_SPECIAL_CHARS) : "";

    $status = isset($_POST['status']) ? filter_input(INPUT_POST, 'status', 
    FILTER_SANITIZE_SPECIAL_CHARS) : "Ativo";

    $atividade = isset($_POST['atividade']) ? base64_decode(filter_input(INPUT_POST, 'atividade', 
    FILTER_SANITIZE_SPECIAL_CHARS)) : -1;

    switch($tabela){
        case "eventos":
            return getEventos($busca, $status, $GLOBALS['pagina']);
        break;
        case "atividades":
            return getAtividades($busca, $status, $GLOBALS['pagina']);
        break;
        case "usuarios":
            return getUsuarios($busca, $status, $atividade, $GLOBALS['pagina']);
        break;
        case "locais":
            return getLocais($busca, $GLOBALS['pagina']);
        break;
        case "suporte":
            return getSuporte($busca, $GLOBALS['pagina']);
        break;
        case "administradores":
            return getAdministrador($busca, $status, $GLOBALS['pagina']);
        break;
        case "pagamento":
            return getPagamentos($busca, $status, $GLOBALS['pagina']);
        break;
        case "projetos":
            $evento = filter_input(INPUT_POST, "evento", FILTER_SANITIZE_SPECIAL_CHARS);

            return getProjetos($busca, $evento, $status, $GLOBALS['pagina']);
        break;
        default:
            return getGenerico($busca, $tabela, $GLOBALS['pagina']);
        break;
    }
}

require_once("{$root}dao/adm/select/index.php");

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <?php
                switch($tabela){
                    case "suporte":
                        echo "<th style='width: 70%'>Assunto</th>";
                        echo "<th>Nome</th>";
                    break;
                    case "eventos":
                        echo "<th style='width: 60%'>título</th>";
                        echo "<th>Nº Atividades</th>";
                        echo "<th>Nº Participantes</th>";
                    break;
                    case "atividades":
                        echo "<th style='width: 70%'>título</th>";
                        echo "<th>Nº Participantes</th>";
                    break;
                    case "administradores":
                        echo "<th style='width: 70%'>Nome</th>";
                        echo "<th>E-mail</th>";
                    break;
                    case "pagamento":
                        echo "<th style='width: 70%'>Nome</th>";
                        echo "<th>E-mail</th>";
                        echo "<th class='text-center'>Telefone</th>";
                    break;
                    case "projetos":
                        $evento = filter_input(INPUT_POST, "evento", FILTER_SANITIZE_SPECIAL_CHARS);

                        echo "<th>Título</th>";
                        echo "<th>Autor</th>";
                        echo "<th>E-mail</th>";
                    break;
                    default:
                        echo "<th style='width: 70%'>título</th>";
                    break;
                }

                if($tabela !== "usuarios" && $tabela !== "pagamento" && $tabela !== "projetos"){
                    echo "<th>Excluir</th>";
                }

                if($tabela === "usuarios"){
                    echo "<th>Presença</th>";
                }

                if($tabela === "pagamento"){
                    echo "<th style='width:15%'>Status</th>";
                }

                if($tabela === "projetos"){
                    echo "<th style='width: 25%'>Opções</th>";
                }
            ?>
            
        </tr> 
    </thead>
    <tbody>
    <?php 
        $result = getDados($tabela);
        $rows = mysqli_num_rows($result['banco']);
        if($rows){
            $i = 0;

            while($dados = mysqli_fetch_array($result['banco'])){
                if($tabela === "projetos"){
                    if(intval($dados['aprovacao']) === 1)
                        echo '<tr class="bg-aprovado">';
                    else if(intval($dados['aprovacao']) === 2)
                        echo '<tr class="bg-reprovado">';
                }
                else
                    echo '<tr>';
                    if($tabela !== "atividades" && $tabela !== "usuarios" && $tabela !== "pagamento" && $tabela !== "projetos"){
                        $link = substr($tabela, 0, 1);

                        echo "<td class='td-editar' title='Clique para editar!' ><a class='td-link' href='{$tabela}.php?{$link}=".base64_encode($dados['id'])."'>{$dados['titulo']}</a></td>";
                    }

                    switch($tabela){
                        case "suporte":
                            echo "<td>{$dados['nome']}</td>";
                        break;
                        case "eventos":
                            $totalAtividades = mysqli_num_rows(
                                mysqli_query(
                                    banco(), 
                                    "SELECT a.id FROM atividades a 
                                     LEFT JOIN eventos e ON a.id_evento = e.id 
                                     WHERE e.id = {$dados['id']}"
                                )
                            );

                            echo "<td align='center'>{$totalAtividades}</td>";

                            $totalParticipantes = mysqli_num_rows(
                                mysqli_query(
                                    banco(), 
                                    "SELECT u.id FROM usuarios u 
                                     LEFT JOIN evento_pago ep ON u.id = ep.usuario 
                                     LEFT JOIN eventos e ON ep.evento = e.id 
                                     WHERE e.id = {$dados['id']} 
                                     AND ep.pagamento = 1 "
                                )
                            );

                            echo "<td align='center'>{$totalParticipantes}</td>";
                            $i++;
                        break;
                        case "atividades":
                            echo "<td title='Clique para editar!'><a class='td-link' href='atividade.php?e={$base64_evento}&a=".base64_encode($dados['id'])."'>".$dados['titulo'].'</a></td>';

                            $totalParticipantes = mysqli_num_rows(
                                mysqli_query(
                                    banco(),
                                    "SELECT u.id FROM usuarios u 
                                     LEFT JOIN usuario_atividade ua ON u.id = ua.usuario
                                     LEFT JOIN evento_pago ep ON u.id = ep.usuario
                                     LEFT JOIN atividades a ON ua.atividade = a.id
                                     LEFT JOIN eventos e ON ep.evento = e.id
                                     WHERE a.id = {$dados['id']}
                                     AND e.id = {$evento}
                                     AND ep.pagamento = 1"
                                )
                                );

                            echo "<td align='center'>{$totalParticipantes}</td>";
                        break;
                        case "administradores":
                            echo "<td>{$dados['email']}</td>";
                        break;
                        case "usuarios":
                            echo "<td class='td-editar' title='Clique para ver mais informações!' ><p class='td-link' onclick='showModalParticipante(\"".base64_encode($dados['id'])."\")' style='margin: 0;'>{$dados['titulo']}</p></td>";

                            if($dados['presenca']){
                                echo "<td class='bg-success text-center'><span class='icon 
                                glyphicon glyphicon-ok-circle'></span> Presente</td>";
                            }
                            else{
                                echo "<td class='bg-alert text-center'><span class='icon 
                                glyphicon glyphicon-remove-circle'></span> Ausente</td>";
                            }
                        break;
                        case "pagamento":
                            echo "<td><p class='td-pagamento'>{$dados['titulo']}</p></td>";

                            if($dados['telefone'] === "Não Informado" || empty($dados['telefone']))
                                echo "<td colspan='2'><p class='td-pagamento'>{$dados['email']}</p></td>";
                            else{
                                echo "<td><p class='td-pagamento'>{$dados['email']}</p></td>";
                                echo "<td text-center'><p class='td-pagamento'>{$dados['telefone']}</p></td>";
                            }

                            if($dados['pagamento']){
                                echo "<td class='btn-pagamento bg-success' data-user='".base64_encode($dados['id'])."' onselectstart='return false'>"; 
                                    echo "<p>Pago</p>";
                                    echo "<input class='users' type='hidden' />";
                                echo "</td>";
                            }
                            else{
                                echo "<td class='btn-pagamento bg-alert' data-user='".base64_encode($dados['id'])."' onselectstart='return false'>";
                                    echo "<p>Pendente</p>";
                                    echo "<input class='users' type='hidden' />";
                                echo "</td>";
                            }
                        break;
                        case "projetos":
                            echo "<td class='td-editar'><a class='td-link' href='{$end_projetos}{$dados['arquivo']}' download><span class='icon glyphicon glyphicon-download-alt'></span> {$dados['arquivo']}</a></td>";
                            echo "<td class='text-center'>{$dados['nome']}</td>";
                            echo "<td>{$dados['email']}</td>";
                            echo "<td class='text-center'>";
                                echo "<a class='btn btn-projetos bg-success' href='{$dao}atualizar/projetos.php?e={$evento}&p=".base64_encode($dados['id'])."&a=1'><span class='icon glyphicon glyphicon-ok-circle'></span> Aprovar</a>";

                                echo "<a class='btn btn-projetos reprovar bg-erro' href='{$dao}atualizar/projetos.php?e={$evento}&p=".base64_encode($dados['id'])."&a=2'><span class='icon glyphicon glyphicon-ban-circle'></span> Reprovar</a>";
                            echo "</td>";
                            
                        break;
                    }

                    if($tabela !== "usuarios" && $tabela !== "pagamento" && $tabela !== "projetos"){
                        echo "<td class='excluir' align='center'> <button class='btn btn-danger' onclick='confirmar(\"".base64_encode($dados['id'])."\")'><span class='glyphicon glyphicon-trash' style='padding-right: 6px'></span>Excluir</button></td>";
                    }
                    
                echo '</tr>';
            }
            unset($i);
        }
        else{
            echo "<td colspan='4' align='center' style='padding: 10px !important'>Nenhum dado encontrado!</td>";
        }
    ?>
    </tbody>

    <input type="hidden" id="pagina" value="1" />
    <input type="hidden" id="numPaginas" <?php echo "value='{$result['numPaginas']}'"; ?> />

    <script>
        function confirmar(dado){
            var apagar = confirm("Deseja realmente apagar este dado? Esta ação NÃO poderá ser desfeita.");

            if(tabela !== "Suporte" && tabela !== "Locais" && tabela !== "Administradores")
                var local = tabela.substring(0, tabela.length - 1);
            else{
                if(tabela === "Suporte")
                    var local = "suporte";

                if(tabela === "Locais")
                    var local = "local";

                if(tabela === "Administradores")
                    var local = "adm";
            }
            
            url = tabela.substring(0, 1).toLowerCase();
                
            if(apagar)
                if(tabela !== "Atividades")
                    location.href = '/public/dao/adm/deletar/'+local+'.php?'+url+'='+dado;
                else
                    location.href = '/public/dao/adm/deletar/'+local+'.php?e='+status+'&a='+dado;
        }

        $(".btn-pagamento").click(function(){
            var el = $(this);
            var oldClass = $(this).attr("class");

            var u = $(this).attr("data-user");
            var pagamento = $(this).hasClass("bg-success") ? 0 : 1;

            $.ajax({
                method: "POST",
                url: <?php echo "'{$dao}atualizar/pagamento.php'\n" ?>,
                data: {e: $("#evento").val(), u: u, pagamento: pagamento},

                beforeSend: function(){
                    console.log("oalrz");
                    $(this).removeAttr("class");
                    $(this).addClass("btn-pagamento bg-load");
                    $(this).html("<span class='icon glyphicon glyphicon-refresh'></span> Carregando...");
                },

                success: function(data){
                    $(el).removeClass("bg-load");
                    
                    if(oldClass === "btn-pagamento bg-success"){
                        $(el).removeClass("bg-success");
                        $(el).addClass("bg-alert");
                        $(el).html("Pendente");
                    }
                    else{
                        $(el).removeClass("bg-alert");
                        $(el).addClass("bg-success");
                        $(el).html("Pago");
                    }
                }
            });
        });

        $("#btnTodos").click(function(){
            if(document.getElementById("rdoPago").checked)
                atualizaTodos(1);
            
            if(document.getElementById("rdoPendente").checked)
                atualizaTodos(0);
        });

        function atualizaTodos(status){
            $.ajax({
                method: "POST",
                url: <?php echo "'{$dao}atualizar/pagamento.php'\n" ?>,
                data: {e: $("#evento").val(), pagamento: pagamento},

                success: function(data){
                    $(el).removeClass("bg-load");
                    
                    if(status){
                        $(el).removeClass("bg-alert");
                        $(el).addClass("bg-success");
                        $(el).html("Pago");
                    }
                    else{
                        $(el).removeClass("bg-success");
                        $(el).addClass("bg-alert");
                        $(el).html("Pendente");
                    }
                }
            });
        }
    </script>
</table>