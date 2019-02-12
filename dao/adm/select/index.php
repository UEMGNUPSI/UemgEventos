<?php

function getGenerico($busca, $tabela, $pagina){

    $sql = "SELECT id, titulo FROM {$tabela} WHERE titulo LIKE '%{$busca}%' ";

    $paginacao = paginacao($sql, $pagina, 9);

    unset($sql);

    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getLocais($busca, $pagina){

    $sql = "SELECT id, local titulo FROM locais WHERE local LIKE '%{$busca}%' ";

    $paginacao = paginacao($sql, $pagina, 9);
    
    unset($sql);

    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getSuporte($busca, $pagina){

    $sql = "SELECT id, assunto titulo, nome FROM suporte WHERE assunto LIKE '%{$busca}%' ";
    
    $paginacao = paginacao($sql, $pagina, 9);

    unset($sql);

    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getAdministrador($busca, $item, $pagina){

    $sql = "SELECT id, nome titulo, email FROM usuarios WHERE $item LIKE '%{$busca}%' AND adm = 1 ";

    $paginacao = paginacao($sql, $pagina, 9);

    unset($sql);

    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getEventos($busca, $status, $pagina){
    $id_admin = getId($_SESSION['user']);
    
    $sql = "SELECT e.id, e.titulo, e.adm 
            FROM eventos e 
            WHERE e.titulo LIKE '%{$busca}%' 
            AND status = '{$status}' ";

    if($id_admin !== 1)
        $sql .= "AND adm = {$id_admin} ";

    $sql .= "ORDER BY e.id DESC ";

    $paginacao = paginacao($sql, $pagina, 9);

    unset($sql);
        
    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getAtividades($busca, $evento, $pagina){
    $id_admin = getId($_SESSION['user']);

    $evento = base64_decode($evento);

    $sql = "SELECT a.id, a.titulo FROM atividades a 
            INNER JOIN eventos e ON a.id_evento = e.id
            WHERE e.id = {$evento} 
            AND a.titulo LIKE '%{$busca}%' ";

    if($id_admin !== 1)
        $sql .= "AND adm = {$id_admin} ";

    $sql .= "GROUP BY a.id 
             ORDER BY a.id DESC ";

    $paginacao = paginacao($sql, $pagina, 9);

    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getUsuarios($busca, $evento, $atividade, $pagina){
    $id_admin = getId($_SESSION['user']);

    $evento = base64_decode($evento);

    $sql = "SELECT u.id, u.nome titulo, ua.presenca 
            FROM usuarios u 
            INNER JOIN evento_pago ep ON u.id = ep.usuario 
            INNER JOIN eventos e ON ep.evento = e.id
            INNER JOIN usuario_atividade ua ON u.id = ua.usuario
            INNER JOIN atividades a ON ua.atividade = a.id
            WHERE u.nome LIKE '%{$busca}%' 
            AND e.id = {$evento} 
            AND a.id = {$atividade} 
            AND ep.pagamento = 1 ";

    if($id_admin !== 1)
        $sql .= "AND e.adm = {$id_admin} ";

    $paginacao = paginacao($sql, $pagina, 10);

    unset($sql);
    
    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getPagamentos($busca, $evento, $pagina){
    $id_admin = getId($_SESSION['user']);

    $evento = base64_decode($evento);

    $sql = "SELECT u.id, u.nome titulo, u.email, u.telefone, 
                   ep.pagamento 
            FROM usuarios u 
            INNER JOIN evento_pago ep ON u.id = ep.usuario 
            INNER JOIN eventos e ON ep.evento = e.id
            WHERE u.nome LIKE '%{$busca}%' 
            AND e.id = {$evento} ";

    if($id_admin !== 1)
        $sql .= "AND e.adm = {$id_admin} ";

    $sql .= "ORDER BY u.nome ";

    $paginacao = paginacao($sql, $pagina, 10);

    unset($sql);
    
    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function getProjetos($busca, $evento, $status, $pagina){
    $id_admin = getId($_SESSION['user']);

    $evento = base64_decode($evento);

    $sql = "SELECT p.id, p.nome arquivo, u.nome nome, 
                   u.email, p.aprovacao 
            FROM projetos p 
            LEFT JOIN usuarios u ON p.usuario = u.id 
            LEFT JOIN eventos e ON p.evento = e.id 
            WHERE {$status} LIKE '%{$busca}%' 
            AND e.id = {$evento} ";

    if($id_admin !== 1)
        $sql .= "AND e.adm = {$id_admin} ";

    $sql .= "ORDER BY {$status} ";

    $paginacao = paginacao($sql, $pagina, 6);

    unset($sql);
    
    return array(
        "banco" => mysqli_query(banco(), $paginacao['sql']),
        "numPaginas" => $paginacao['numPaginas']
    );
}

function paginacao($sql, $pagina, $registros){
    
    $GLOBALS['total'] = mysqli_num_rows(mysqli_query(banco(), $sql));
    
    $numPaginas = ceil($GLOBALS['total']/$registros);
    
    $inicio = ($registros*$pagina)-$registros;

    $sql .= "LIMIT $inicio, $registros ";

    return array(
        "sql"           => $sql,
        "numPaginas"    => $numPaginas
    );
}

function getDistribuirCertificados($evento){
    return mysqli_num_rows(
            mysqli_query(
                banco(), 
                "SELECT c.id FROM certificados c 
                LEFT JOIN eventos e ON c.evento = e.id
                WHERE e.id = {$evento}"
            )
        ) > 0;
}

?>