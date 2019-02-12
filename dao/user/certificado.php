<?php 
	require_once("index.php");

	$objBd = new bd();
	$link = $objBd->conecta_mysql();
	
	if(isset($_GET['ide'])){
		$ide = base64_decode($_GET['ide']);
		
		$sql = "SELECT * FROM eventos e INNER JOIN locais l ON e.id_local = l.id WHERE e.id = {$ide}";

		$evento = mysqli_fetch_array(mysqli_query($link, $sql));

		$data_inicio = new DateTime($evento['data_inicio']);
		$data_fim = new DateTime($evento['data_fim']);

		switch ($data_fim->format('m')) {
			case '01':
				$mes = 'Janeiro';
				break;
			case '02':
				$mes = 'Fevereiro';
				break;
			case '03':
				$mes = 'Março';
				break;
			case '04':
				$mes = 'Abril';
				break;
			case '05':
				$mes = 'Maio';
				break;
			case '06':
				$mes = 'Junho';
				break;
			case '07':
				$mes = 'Julho';
				break;
			case '08':
				$mes = 'Agosto';
				break;
			case '09':
				$mes = 'Setembro';
				break;
			case '10':
				$mes = 'Outubro';
				break;
			case '11':
				$mes = 'Novembro';
				break;
			case '12':
				$mes = 'Dezembro';
				break;
		}
		if($_SESSION['admin']){ // pre visualização do certificado (admin)
			$html = "<head>";
				require_once("../../head.php");
				$html .= '
					<style>
						html{margin: 6rem; margin-bottom: 4.4rem;}
					    body{
					    	margin: 0; 						padding 0 !important;
					    	background-image: url("../../imagens/bg-certificado2.png");
					    	background-repeat: no-repeat;	background-position: center;
					    	background-size: 500px 344px !important;

					    	border: 8px solid rgb(59,110,143); 

					    }
					    .corpo{margin: 5rem; margin-top: 10rem;}
					    .corpo>h1{color: rgb(130, 0, 36)}
					    .corpo>h3{color: rgb(0, 43, 92)}
					    .img-uemg{width: 450px; text-align: right}

				    </style>
				</head>
				<body>
					<div class="container">
						<div class="col-6"></div>
						<div class="col-6 pull-right"><img class="img-uemg" src="../../imagens/MARCA_UEMG.jpg"></div>
						<div class="corpo font-corpo">
							<h1 align="center">Certificado</h1>
							<h3 align="center">Certificamos que <span id="nome">Nome do Aluno</span> participou do evento <span id="nome">'.$evento["titulo"].'</span> que ocorreu  entre os dias '.$data_inicio->format('d').' à '.$data_fim->format('d').' de '.$mes.' de '.$data_fim->format('Y').'.</h3>
							<h3 align="center" style="margin-top:5rem; margin-bottom: 0">'.$evento['local'].'</h3>
							<hr style="margin: 1rem 4rem;">
							<h3 align="center" style="margin-top: 0">Local</h3>
						</div>

						<div class="container">
							<div class="ass">
								<span class="org">
									<h4>'.$evento['organizador'].'</h4>
									<span>Organizador</span>
								</span>
								<span class="dir">
									<h4>Allyson Takehiro Fujita</h4>
									<span>Diretor</span>
								</span>
							</div>
						</div>
					</div>	
					
				</body>
			    ';
		}
		else{ // Usuário comum
			  // a margem abaixo deve ser -1.6rem a menos

			$sql = "SELECT u.nome, a.titulo, a.data_inicio, a.hora_inicio, a.hora_fim 
					FROM atividades a 
					INNER JOIN usuario_atividade ua ON a.id = ua.atividade 
					INNER JOIN usuarios u ON ua.usuario = u.id 
					WHERE u.email = '{$_SESSION['user']}' 
					AND ua.presenca = 1 
					ORDER BY a.titulo";

			$res_atividades = mysqli_query($link, $sql);

			$user = mysqli_fetch_array($res_atividades, MYSQLI_ASSOC);


			$html = '
			<head>
				<title>Certificado</title>
				<link href="/public/frameworks/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all">
				<link rel="stylesheet" type="text/css" href="/public/estilo.css">
				<style>
					@import url("https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:700|Boogaloo|Hind+Vadodara:300,400,700");

					html{margin: 6rem; margin-bottom: 4.4rem;}
					body{
						margin: 0; 						padding 0 !important;
						background-image: url("../../imagens/bg-certificado.png");
						background-repeat: no-repeat;	background-position: center;
						background-size: 500px 344px !important;
						
						font-family: sans-serif !important;

						border: 8px solid rgb(59,110,143); 

					}
					
					h1{color: rgb(130, 0, 36)}
					h3{color: rgb(0, 43, 92)}

					table{
						width: 100%; 					font-size: 12px;
						margin-left: -25rem; 			margin-right: 18rem;
						margin-bottom: -15rem;			margin-top: -6rem;
						font-family: "Hind Vadodara", sans-serif !important;
					}

					tr{}
					
					.corpo{margin: 5rem; margin-top: 10rem;}
					
					.td-titulo{padding-right: 6px;}
					.td-data{padding-right: 6px !important;}
					.td-inicio{padding-right: 6px;}
					.td-fim{padding-right: 6px;}

					.tbl-atv{margin-left: -25rem;}

					.img-uemg{width: 450px; }
					.certificado-atv{margin-top: 10rem;}
					.titulo-atv{display: inline;}

					.img-ass{
						position: fixed;				width: 160px !important;
						bottom: 284px;					right: 60px;
						
					}

				</style>
			</head>
			<body>
				<div class="container">
					<div class="col-6 pull-right"><img class="img-uemg"  src="../../imagens/MARCA_UEMG.jpg"></div>
					<div class="corpo">
						<h1 align="center">Certificado</h1>
						<h3 align="center">Certificamos que <span id="nome">'.$user['nome'].'</span> participou do evento <span id="nome">'.$evento["titulo"].'</span> que ocorreu  entre os dias '.$data_inicio->format('d').' à '.$data_fim->format('d').' de '.$mes.' de '.$data_fim->format('Y').'.</h3>
						<h3 align="center" style="margin-top:5rem; margin-bottom: 0">'.$evento['local'].'</h3>
						<hr style="margin: 1rem 4rem;">
						<h3 align="center" style="margin-top: 0">Local</h3>
					</div>

					<div class="container">
						<div class="ass">
							<span class="org">
								<h4>'.$evento['organizador'].'</h4>
								<span>Organizador</span>
							</span>';

							// EDITAR O DIRETOR DA UNIVERSIDADE 
							// Nota: Certifique-se que a assinatura encaixa perfeitamente, caso seja necessário alterações procure pela classe .img-ass no próprio documento.
					$html .='<!--<span class="dir">
								<img class="img-ass" src="../../imagens/Assinaturas/Allysson.png">
								<h4>Allyson Takehiro Fujita</h4>
								<span>Diretor</span>
							</span>-->';
							// FIM DA EDIÇÃO DO DIRETOR

				$html.=	'</div>
					</div>
					<br>
					<div class="certificado-atv">
						<!--<div class="titulo-atv">
							<img class="img-uemg" style="position: fixed; top: 4rem; left: 4rem;" src="../../imagens/MARCA_UEMG.jpg">
						</div>-->
						<div class="pull-left corpo" style="width: 100%;">
							<h1 style="position: fixed; top: 3.5rem; left: 3rem;">Atividades presente:</h1>
						</div>
						<div class="corpo" style="margin-top: 5.5rem;">
							<table class="tbl-atv">
								<thead>
									<tr>
										<th class="primeira-coluna">Atividade</th>
										<th>Data</th>
										<th>Início</th>
										<th>Fim</th>

										<th>Atividade</th>
										<th>Data</th>
										<th>Início</th>
										<th>Fim</th>';

						$html .='	</tr>
								</thead>
								<tbody>';

								$sql = "SELECT u.nome, a.titulo, a.data_inicio, 
												a.hora_inicio, a.hora_fim 
										FROM atividades a 
										INNER JOIN usuario_atividade ua ON a.id = ua.atividade 
										INNER JOIN usuarios u ON ua.usuario = u.id 
										WHERE u.email = '{$_SESSION['user']}' 
										AND ua.presenca = 1 
										ORDER BY a.titulo";
					
								$res_atividades = mysqli_query($link, $sql);

									$i = 1;

									while($atividades = mysqli_fetch_array($res_atividades, MYSQLI_ASSOC)){
										
										$data = new DateTime($atividades['data_inicio']);

										$hora_inicio = new DateTime($atividades['hora_inicio']);
										$hora_fim = new DateTime($atividades['hora_fim']);


										if($i == 1){
											$html .= '	<tr>
															<td class="td-titulo primeira-coluna">'.$atividades['titulo'].'</td>
															<td class="td-data">'.$data->format('d/m').'</td>
															<td class="td-inicio">'.$hora_inicio->format('H:i').'</td>
															<td class="td-fim">'.$hora_fim->format('H:i').'</td>';
											$i++;
										}
										else{
											$html .= '	<td class=" segunda-coluna">'.$atividades['titulo'].'</td>
														<td>'.$data->format('d/m').'</td>
														<td>'.$hora_inicio->format('H:i').'</td>
														<td>'.$hora_fim->format('H:i').'</td>
													</tr>';
											$i--;
										}
									}
			$html .='	</tbody></table></div>';
		}
	}

  require_once '../../frameworks/dompdf/autoload.inc.php';

  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  //Criando a Instancia
  $dompdf = new Dompdf();
  
  // Carrega seu HTML
  $dompdf->load_html("&nbsp;".$html);

  //Setando a posição do papel
  $dompdf->set_paper('A4', 'landscape');

  //Renderizar o html
  $dompdf->render(header('Content-type: text/html; charset=UTF-8'));

  //Exibibir a página
  $dompdf->stream(
    "Certificado - ".$evento['titulo'].".pdf", 
    array(
      "Attachment" => false //Para realizar o download somente alterar para true
    )
  );

?>