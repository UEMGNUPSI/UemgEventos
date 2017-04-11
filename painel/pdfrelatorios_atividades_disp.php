<?php 


  $servidor = "localhost";
  $usuario = "root";
  $senha = "";
  $dbname = "uemg_eventos";
  
  //Criar a conexÃ£o
  $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
  $html = '<table style="font-family: arial,helvetica,sans-serif;">';  
  $html .= '<thead>';
  $html .= '<tr>';
  $html .= '<th>ID</th>';
  $html .= '<th>Título</th>';
  $html .= '<th>Descricao</th>';
  $html .= '<th>Vagas totais</th>';
  $html .= '<th>Vagas Disponiveis</th>';
  $html .= '<th>Data início</th>';
  $html .= '<th>Data fim</th>';
  $html .= '</tr>';
  $html .= '</thead>';
  $html .= '<tbody style="text-align: center; background: #E4E4E4; font-size: 17px;">';
  
  $result_atividade = "SELECT * FROM atividades";
  $resultado_atividade = mysqli_query($conn, $result_atividade);
  while($row_atividade = mysqli_fetch_assoc($resultado_atividade)){
    $html .= '<tr><td>'.$row_atividade['id'] . "</td>";
    $html .= '<td>'.$row_atividade['titulo'] . "</td>";
    $html .= '<td>'.$row_atividade['descricao'] . "</td>"; 
    $html .= '<td>'.$row_atividade['vagas_total'] . "</td>";
    $html .= '<td>'.$row_atividade['vagas_disp'] . "</td>";  
    $html .= '<td>'.$row_atividade['data_inicio'] . "</td>";
    $html .= '<td>'.$row_atividade['data_fim'] . "</td>";  
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
      <h1 style="text-align: center; color =red; font-family: arial,helvetica,sans-serif;">Relatório atividades</h1>
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