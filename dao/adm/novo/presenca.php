<?php

require_once("index.php");

$objBd = new bd();
$link = $objBd->conecta_mysql();

$titulo = 	filter_input(INPUT_POST, 'titulo', 
			FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($_GET['id']) && isset($_GET['ide'])){
	$id		= 	filter_input(INPUT_GET, 'id', 
		  		FILTER_SANITIZE_SPECIAL_CHARS);
 	$ide 	= 	filter_input(INPUT_GET, 'ide', 
	 			FILTER_SANITIZE_SPECIAL_CHARS);
}

if(isset($_GET['codigo'])){

	$ra = $_GET['codigo'];

	$ra1 = strstr($ra, '-', true);

	$ra2 = substr(strstr($ra, '-'), 1);

	$ra = $ra1.$ra2;
	
	$sql ="SELECT * FROM usuarios WHERE ra = $ra";

	

	if(mysqli_query($link, $sql)){
		$sql = "UPDATE usuario_atividade ua SET ua.presenca = 1 INNER JOIN usuario u ON u.id = ua.usuario WHERE u.ra = $ra";
	}
	else{
		echo "Usuário não encontrado!";
	}	

	echo $sql;
}
else{
	if(isset($_POST['combo'])){
		$userPresence = $_POST['combo'];

		$sql = "UPDATE usuario_atividade SET presenca = 1 WHERE";
		$i = 0;
	    var_dump($userPresence);
		foreach($userPresence as $user){
			$i++;
			echo $i;
		}
		$x = 0;
		foreach($userPresence as $user){
			if($x == $i-1){
				$sql.= " usuario = ".$user." AND";
			}
			else{
				$sql.= " usuario = ".$user." OR";
			}
			$x++;
		}

		$sql .= " atividade = ".$id;

		echo $sql . '<br>';

		if(mysqli_query($link, $sql)){
			if($c == $i){

	// 			header("Location: presenca.php?id=".$id."&ide=".$ide."&u=1");
				die();
			}

			$sql = "UPDATE usuario_atividade SET presenca = 0 WHERE";

			$x = 0;
			foreach($userPresence as $user){
				if($x == $i-1){
					$sql.= " usuario <> ".$user." AND";
				}
				else{
					$sql.= " usuario <> ".$user." OR";
				}
				$x++;
			}

			$sql .= " atividade = ".$id;
			echo $sql . '<br>';
			if(mysqli_query($link, $sql)){
	// 			header("Location: presenca.php?id=".$id."&ide=".$ide."&u=1");
				die();
			}
			else{
				echo "Erro 02 - Não foi possível salvar no banco de dados!";
				die();
			}
		}
		else{
			echo "Erro 01 - Não foi possível salvar no banco de dados!";
			die();
		}	
		
	}
	else{
		$sql = "UPDATE usuario_atividade SET presenca = 0";

		if(mysqli_query($link, $sql)){
		    echo "certo";
		}
		else{
		    echo "Erro no sql";
		}

	 	header("Location: presenca.php?id=".$id."&ide=".$ide."&u=1");
	}
}
?>