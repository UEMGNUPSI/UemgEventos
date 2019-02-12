<?php
    session_start();

    if(!isset($_SESSION['user']) || $_SESSION['admin'] == true){
		header("Location: /public/");

		die();
	}
    
    require_once('../dao/bd.php');

    require_once('../config.php');

    $objBd = new bd();
    $link = $objBd->conecta_mysql();

    $user =   mysqli_fetch_array(
                mysqli_query(
                    $link,
                    "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}'"
                ),
                MYSQLI_ASSOC
            );

    $pagina = (isset($_GET['pagina'])) ? intval($_GET['pagina']) : 1;

    $registros = 7;

    # Início SQL Eventos.
        $sql = "SELECT e.id, e.titulo, e.regra, ep.pagamento FROM usuarios u INNER JOIN evento_pago ep ON u.id = ep.usuario INNER JOIN eventos e ON ep.evento = e.id  WHERE u.id = {$user['id']} ORDER BY data_inicio";

        $total = mysqli_num_rows(mysqli_query($link, $sql));

        $numPaginas = ceil($total/$registros);

        $inicio = ($registros*$pagina)-$registros;

        $sql .= " LIMIT $inicio, $registros";

        $result_eventos = mysqli_query($link, $sql);
        
        $rows = mysqli_num_rows($result_eventos);

        

    # Fim SQL Eventos.

    mysqli_close($link);

    function tabelaEventos($evt){

        $objBd = new bd();
        $link = $objBd->conecta_mysql();

        echo "<tr>";
            echo "<td class='td-atividade'>";
                echo "<input name='info' type='hidden' value=".base64_encode($evt['id'])." />";
                echo $evt['titulo'];
            echo "</td>";
            echo "<td align='center'>";
                echo "<a href='../dao/user/gerar_credencial.php?ide=".base64_encode($evt['id'])."' target='_blank'>Gerar</a>";
            echo "</td>";
            echo "<td align='center'>";
                $sql = "SELECT titulo 
                        FROM certificados c 
                        INNER JOIN eventos e ON c.evento = e.id 
                        WHERE e.id = {$evt['id']}";
                
                if(mysqli_num_rows(mysqli_query($link, $sql))){
                    $sql = "SELECT nome 
                            FROM certificados c 
                            INNER JOIN usuarios u ON c.usuario = u.id 
                            INNER JOIN eventos e ON c.evento = e.id 
                            WHERE u.email = '{$_SESSION['user']}' 
                            AND e.id = {$evt['id']}";

                    if(mysqli_num_rows(mysqli_query($link, $sql))){
                        echo "<a href='../dao/user/certificado.php?ide=".base64_encode($evt['id'])."' target='_blank'>Gerar</a>";
                    }
                    else{
                        echo "Você não obteve mais que {$evt['regra']}% de presença.";
                    }
                }
                else{
                    echo "Não disponível!";
                }
            echo "</td>";
        echo "</tr>";

        mysqli_close($link);
    }
?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>evento</th>
            <th>crendencial</th>
            <th>certificado</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($rows){
                while($eventos = mysqli_fetch_array($result_eventos, MYSQLI_ASSOC)){
                    tabelaEventos($eventos);
                }
            }
                
            else{
                echo "<tr>";
                    echo "<td align='center' colspan='3'>";
                        echo "Você ainda não está inscrito em nenhum evento!";
                    echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
