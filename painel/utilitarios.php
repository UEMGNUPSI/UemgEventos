<?php
    session_start();

    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR');

    $root           =   $_SERVER['DOCUMENT_ROOT']."/public/";
    $adm_root       =   $_SERVER['DOCUMENT_ROOT'].
                        "/public/painel/";
    $end            =   "/public/painel/";
    $dao            =   "/public/dao/adm/";
    $end_projetos   =   "/public/uploads/projetos/";
    
    if(!isset($_SESSION['user']) || $_SESSION['admin'] == false){
        header("Location: /public/");

        die();
    }

    require_once($root."dao/bd.php");

    function banco(){
        $objBd = new bd();
        return $objBd->conecta_mysql();
    }

    function getNome($user){
        $link = banco();
        
        $id = mysqli_fetch_array(mysqli_query($link, "SELECT nome FROM usuarios WHERE email = '{$user}'"));

        mysqli_close($link);

        return $id['nome'];
    }

    function getId($user){
        $link = banco();
        
        $id = mysqli_fetch_array(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$user}'"));

        mysqli_close($link);

        return intval($id['id']);
    }

    function validaAdm($email, $evento){
        $link = banco();

        $id_admin = mysqli_fetch_array(mysqli_query($link, "SELECT id FROM usuarios WHERE email = '{$email}' AND adm = 1"));
        
        if(intval($id_admin['id']) === 1){
            mysqli_close($link);
            return true;
        }
        
        if(mysqli_num_rows(mysqli_query($link, "SELECT id FROM eventos WHERE adm = {$id_admin['id']} AND id = $evento"))){
            mysqli_close($link);
            return true;
        }
        else{
            mysqli_close($link);
            return false;
        }
    
        mysqli_close($link);
    }
    
?>