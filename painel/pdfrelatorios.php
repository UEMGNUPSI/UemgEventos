<?php 


  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $dbname = "uemg_eventos";
  
  //Criar a conexÃ£o
  $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
  $html = '<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">';
  $html = '<table style="font-family: arial,helvetica,sans-serif;">';  
  $html .= '<thead>';
  $html .= '<tr>';
  $html .= '<th>ID</th>';
  $html .= '<th>Titulo</th>';
  $html .= '<th>Data inicio</th>';
  $html .= '<th>Data fim</th>';
  $html .= '<th>Organizador</th>';
  $html .= '<th>valor</th>';
  $html .= '<th>Pagar Para</th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody style="text-align: center; background: solid red; font-size: 30px;">';
  
  $result_evento = "SELECT * FROM eventos";
  $resultado_evento = mysqli_query($conn, $result_evento);
  while($row_evento = mysqli_fetch_assoc($resultado_evento)){
    $html .= '<tr><td>'.$row_evento['id'] . "</td>";
    $html .= '<td>'.$row_evento['titulo'] . "</td>";
    $html .= '<td>'.$row_evento['data_inicio'] . "</td>";
    $html .= '<td>'.$row_evento['data_fim'] . "</td>";
    $html .= '<td>'.$row_evento['organizador'] . "</td></tr>";
    $html .= '<td>'.$row_evento['valor'] . "</td></tr>";
    $html .= '<td>'.$row_evento['pagar_para'] . "</td></tr>";  
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
      <h1 style="text-align: center; color =red;">Relatório Eventos</h1>
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