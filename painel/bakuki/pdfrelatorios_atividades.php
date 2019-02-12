<?php
    session_start();
  if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
    header("Location: ../index.php");
  }
  
  $date = date('Y-m-d');
  $date_emissao = date('d-m-Y');
  $hore_emissao = date('H:i');

  require_once('../bd.class.php');

  $objBd = new bd();
  $link = $objBd->conecta_mysql(); 

  $html = '<style>

    table {
    border-collapse: collapse;
    width: 100%;

    }
    th{
        padding-top: 6px;
        padding-bottom: 6px;
    }

    tr:nth-child(even){background-color:  #f9f9f9}
    </style>

    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <span class="font-face">Dia: '.$date_emissao.'</span><span style="float:right" class="font-face"> Hora: '.$hore_emissao.'</span>
    </head>

  <table style="font-size: 14px; border: 1px solid; border-radius: 3px; padding: -1px;" class="font-face">
  <thead>
      <tr style="background-color: #dcdcdc; text-align: center;">
        <th>Título</th>
        <th>Ministrante</th>
        <th>Vagas Disponiveis</th>
        <th>Vagas totais</th>
        <th>Data inicio</th>
      </tr>
  </thead>
<tbody style="border-top: 1px groove; margin-top: -2px;" class="font-face">';

  $result_atividade = "SELECT a.* FROM atividades a INNER JOIN eventos e ON a.id_evento = e.id WHERE e.status = 'Ativo' ORDER BY a.titulo";
  $resultado_atividade = mysqli_query($link, $result_atividade);
  while($row_atividade = mysqli_fetch_assoc($resultado_atividade)){
    $html .= '<tr  style="text-align: center; padding: -1px;">';
    $html .= '<td style="padding: 8px;">'.$row_atividade['titulo']. "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['ministrante'] . "</td>"; 
    $html .= '<td style="padding: 8px;">'.$row_atividade['vagas_disp'] . "</td>"; 
    $html .= '<td style="padding: 8px;">'.$row_atividade['vagas_total'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['data_inicio'] . "</td>";
 
  }
  
  $html .= '</tr>';
  $html .= '</tbody>';
  $html .= '</table';
  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;
  // include autoloader
  require_once("../dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  
  // Carrega seu HTML
  $dompdf->load_html('
      <h1 style="margin-top:50px;font-size: 20px; text-align: center;" class="font-face">Relatório Atividades </h1>
      '. $html .'
    ');

  //Renderizar o html
  $dompdf->render(header('Content-type: text/html; charset=UTF-8'));

  //Exibibir a pÃ¡gina
  $dompdf->stream(
    "relatorio.pdf", 
    array(
      "Attachment" => false //Para realizar o download somente alterar para true
    )
  );

?>