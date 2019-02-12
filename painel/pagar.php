<?php 
	session_start();

	if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
		header("Location: ../index.php");
	}


	require_once('../bd.class.php');

	$objBd = new bd();
	$link = $objBd->conecta_mysql();



	if(isset($_GET['idu'])){
  		$idu = $_GET['idu'];
  		$ide = $_GET['ide'];

  		$sql = "SELECT admin FROM eventos WHERE id = $ide";

		$teste = mysqli_fetch_array(mysqli_query($link, $sql), MYSQLI_ASSOC);

		if($teste['admin'] != 0){
			if($teste['admin'] != $_SESSION['id']){
			  header("Location: eventos.php");

			  die();
			}
		}

		$sql = "UPDATE evento_pago SET pagamento = 1 WHERE usuario = ".$idu." AND evento = ".$ide;

		if(mysqli_query($link, $sql)){
			header("Location: pagamento.php?ide=".$ide);
		}

	}
?>