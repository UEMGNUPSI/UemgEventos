<?php 

  /*date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y-m-d H:i');
  echo $date*/

  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $dbname = "uemg_eventos";
  
  //Criar a conexão
  $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
  $html = '<table style="font-family: arial,helvetica,sans-serif;">';  
  $html .= '<thead>';
  $html .= '<tr>';
  $html .= '<th>ID</th>';
  $html .= '<th>Título</th>';
  $html .= '<th>Data início</th>';
  $html .= '<th>Data fim</th>';
  $html .= '<th>Organizador</th>';
  $html .= '<th>Valor</th>';
  $html .= '<th>Pagar Para</th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody style="text-align: center; background: #E4E4E4; font-size: 17px;">';
  
  $result_evento = "SELECT * FROM eventos"; /*Where data_fim < $date*/
  $resultado_evento = mysqli_query($conn, $result_evento);
  while($row_evento = mysqli_fetch_assoc($resultado_evento)){
    $html .= '<tr style="padding: 8px;"><td>'.$row_evento['id'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['titulo'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['data_inicio'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['data_fim'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['organizador'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['valor'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_evento['pagar_para'] . "</td>";  
  }
  
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
      <h1 style="text-align: center; color =red; font-family: arial,helvetica,sans-serif;">Relatório Eventos</h1>
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