<?php

session_start();

if(!isset($_SESSION['user']) || $_SESSION['admin'] == false){
	header("Location: /public/");
	die();
}

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

require_once('../../bd.php');

$root       =   $_SERVER['DOCUMENT_ROOT']."/public/";
$adm_root   =   $_SERVER['DOCUMENT_ROOT']."/public/painel/";
$end        =   "/public/painel/";
$dao        =   "/public/dao/adm/";

function validaAdm($email, $evento){
	$objBd = new bd();
	$link = $objBd->conecta_mysql();

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