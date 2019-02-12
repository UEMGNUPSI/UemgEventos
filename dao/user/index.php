<?php

    session_start();

    if(!isset($_SESSION['user']) || $_SESSION['admin'] == true){
        header("Location: /public/");
        die();
    }
    
    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR');
    
    require_once('../bd.php');
    
    $root       =   $_SERVER['DOCUMENT_ROOT']."/public/";
    $adm_root   =   $_SERVER['DOCUMENT_ROOT']."/public/painel/";
    $end        =   "/public/painel/";
    $dao        =   "/public/dao/adm/";
    
