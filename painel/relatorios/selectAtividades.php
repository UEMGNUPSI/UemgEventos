<?php
    require_once("../utilitarios.php");

    $id_admin   =   getId($_SESSION['user']);

    $evento     =   base64_decode(filter_input(INPUT_POST,
                    'evento', FILTER_SANITIZE_SPECIAL_CHARS));

    $sql = "SELECT a.id, a.titulo FROM atividades a 
            INNER JOIN eventos e ON a.id_evento = e.id
            WHERE e.id = {$evento} ";

    if($id_admin !== 1)
        $sql .= "AND adm = {$id_admin} ";

    $sql .= "GROUP BY a.id 
             ORDER BY a.id DESC ";

    $atividades = mysqli_fetch_all(mysqli_query(banco(), $sql), MYSQLI_ASSOC);

    foreach($atividades as $atividade){
        echo "<option value='".base64_encode($atividade['id'])."'>{$atividade['titulo']}</option>";
    }

?>