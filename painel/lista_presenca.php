<?php 

	session_start();

	require_once("../bd.class.php");
	

	if(!isset($_SESSION["usuario"]) || $_SESSION["admin"] == false){
	  header("Location: ../index.php");
	}

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	use Dompdf\Dompdf;

	require_once("../dompdf/autoload.inc.php");


	if(isset($_GET["id"])){
		$id = $_GET["id"];
  		$ide = $_GET["ide"];

		$sql = "SELECT u.id, u.nome, u.email, ua.presenca FROM usuarios u INNER JOIN usuario_atividade ua ON u.id = ua.usuario INNER JOIN evento_pago ep ON u.id = ep.usuario WHERE ep.pagamento = 1 AND ua.atividade = ".$id." ORDER BY u.nome";


		if($result_presenca = mysqli_query($link, $sql)){
			

			$rows = mysqli_num_rows($result_presenca);
		}
		else{
			echo "<center>Erro ao buscar no banco de dados!</center>";
		}
		
	}
	$sql = "SELECT titulo, data_inicio FROM atividades WHERE id = ".$id;

	$at = mysqli_query($link, $sql);
	$atividade = mysqli_fetch_array($at, MYSQLI_ASSOC);

	$data_inicio = new DateTime($atividade['data_inicio']);

	$html = '<html>
					<head>
						<meta charset="utf-8">
						<title>Imprimir<title>
						<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
						<link rel="stylesheet" type="text/css" href="estilo.css">
					</head>
					<body>
						<p class="table" style="font-size: 22px" align="center"> '.$atividade["titulo"].' </p>
						<p class="table" style="font-size: 18px;" align="center"> Lista de Presença<br>'.$data_inicio->format('d/m/y').'</p><br><br>
						<table class="table table-striped table-bordered">
							<tr>
                    			<th class="nome">Nome</th>
                    			<th class="pagar" style="width: 17%">Assinatura</th>
                  			</tr> ';

    $i = 0;
    while($usuarios = mysqli_fetch_array($result_presenca, MYSQLI_ASSOC)){

	        $html .='<tr>
	        <td>
	        	<p style="font-size: 13px; padding: 8px 6px 0 12px">'.$usuarios['nome'].'</p>
	        </td>

	        <td align="center" style = "width: 40%">
	        	<p style="margin-top: 8px;">_______________________</p>
	        </td> </tr>';
	}
			$html .='</table>
		</body>
	</html>';

	$dompdf = new DOMPDF();

	$dompdf->load_html($html);

	$dompdf->render(header('Content-type: text/html; charset=UTF-8'));

	$dompdf->stream(
    "lista_presenca.pdf", 
    array(
      "Attachment" => false //Para realizar o download somente alterar para true
    )
  );

?>