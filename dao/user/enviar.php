<?php  

	session_start();

  	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

  	require_once('bd.class.php');

	$objBd = new bd();
	$link = $objBd->conecta_mysql();


	if($_POST['email']){
		
		$email = $_POST['email'];
		$assunto = $_POST['assunto'];
		$mensagem = $_POST['mensagem'];

		if(isset($_POST['nome'])){
			$nome = $_POST['nome'];

			$sql = "INSERT INTO suporte (nome, email, assunto, mensagem) VALUES ('$nome', '$email', '$assunto', '$mensagem')";
		}
		else{
			$sql = "INSERT INTO suporte (nome, email, assunto, mensagem) VALUES ('Anonimo','$email', '$assunto', '$mensagem')";
		}

		echo $sql;

		if(mysqli_query($link, $sql)){
			header("Location: suporte.php?sucesso=1");
		}
		else{
			header("Location: suporte.php?erro=1");
		}
	}

?>