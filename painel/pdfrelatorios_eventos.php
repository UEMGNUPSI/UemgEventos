<?php 

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y-m-d H:i');
  

  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $dbname = "uemg_eventos";
  

  //Criar a conexão
  $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
  $html = '<style>

    table {
    border-collapse: collapse;
    width: 100%;

    }
    th{
        padding-top: 6px;
        padding-bottom: 6px;
    }

    tr:nth-child(even){background-color:  #dcdcdc}
    </style>

  <table style="font-family: arial,helvetica,sans-serif; border: 1px solid; border-radius: 3px; padding: -1px;">
  <thead>
      <tr style="background-color: #dcdcdc;">
      <th>ID</th>
      <th>Título</th>
      <th>Data Início</th>
      <th>Data Fim</th>
      <th>Organizador</th>
      <th>Valor</th>
      <th>Pagar Para</th>
      </tr>
  </thead>
<tbody style="border-top: 1px groove; margin-top: -2px;">';
  
  $result_evento = "SELECT * FROM eventos WHERE data_fim < '{$date}'"; /*Where data_fim < $date*/
  $resultado_evento = mysqli_query($conn, $result_evento);
  while($row_evento = mysqli_fetch_assoc($resultado_evento)){
    $html .= '<tr  style="text-align: center; font-size: 15px; padding: -1px;">';
    $html .=' <td style="padding: 8px;">'.$row_evento['id'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['titulo'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['data_inicio'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['data_fim'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['organizador'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['valor'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['pagar_para'] . "</td>";  
  }
  $html .= '</tr>';
  $html .= '</tbody>';
  $html .= '</table>';

  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  // include autoloader
  require_once("../dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  
  // Carrega seu HTML
  $dompdf->load_html('
      <h1 style="text-align: center; color =red; font-family: "Courier New", Courier, monospace;">Relatório Eventos</h1>
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