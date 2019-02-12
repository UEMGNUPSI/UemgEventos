<?php 
  session_start();
  if(!isset($_SESSION['usuario'])|| $_SESSION['admin'] == false){
    header("Location: ../index.php");
  }

  $date = date('Y-m-d H:i');
  $date_emissao = date('d-m-Y');
  $hore_emissao = date('H:i');

  require_once('../bd.class.php');

  $objBd = new bd();
  $link = $objBd->conecta_mysql();  

  $id = isset($_GET['evento'])? $_GET['evento'] : 0;

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
      <th>Data inicio</th>
      </tr>
  </thead>
<tbody style="border-top: 1px groove; margin-top: -2px;" class="font-face">';
  
  $sql = "SELECT a.* FROM atividades a INNER JOIN eventos e ON a.id_evento = e.id WHERE e.id = ".$id." AND e.status = 'Ativo' ORDER BY a.titulo";

  $resultado_atividades = mysqli_query($link, $sql);

  $rows = mysqli_num_rows($resultado_atividades);

  if($rows > 0){
    while($atividade = mysqli_fetch_assoc($resultado_atividades)){

      $html .= '<tr  style="text-align: center;">';
      $html .= '<td style="padding: 8px;">'.$atividade['titulo']. "</td>";
      $html .= '<td style="padding: 8px;">'.$atividade['ministrante'] . "</td>"; 
      $html .= '<td style="padding: 8px;">'.$atividade['vagas_disp'] . "</td>"; 
      $html .= '<td style="padding: 8px;">'.$atividade['data_inicio'] . "</td>";
      $html .= '</tr>';
    }
  }
  else{
    $html .= '<tr style="text-align: center; padding: -1px;">';

    $html .= '<td td style="padding: 8px;" colspan="3">Nenhuma atividade criada para este evento.</td></tr>';
  }

  
  $html .= '</tbody>';
  $html .= '</table>';

  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  // include autoloader
  require_once("../dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  $sql = "SELECT titulo FROM eventos WHERE id = ".$id;

  $res_evento = mysqli_query($link, $sql);

  $evento = mysqli_fetch_array($res_evento, MYSQLI_ASSOC);
  // Carrega seu HTML
  $dompdf->load_html('
      <h1 style="margin-top:50px;font-size: 20px; text-align: center;" class="font-face">Relatório<br>'.$evento['titulo'].' </h1>
      '. $html .'
    ');

  //Renderizar o html
  $dompdf->render();

  //Exibibir a pÃ¡gina
  $dompdf->stream(
    "relatorio.pdf", 
    array(
      "Attachment" => false //Para realizar o download somente alterar para true
    )
  );
?>