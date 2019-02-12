<?php 
  require_once('../utilitarios.php');

  $data = date('d/m/Y');
  $hora = date('H:i');

  $evento = base64_decode(filter_input(INPUT_GET, "e", 
            FILTER_SANITIZE_SPECIAL_CHARS));

  $evento_titulo = mysqli_fetch_array(mysqli_query(banco(), "SELECT titulo FROM eventos WHERE id = {$evento}"), MYSQLI_ASSOC);
  
  $html = "
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-xs-8'>
        <div class='row'>
          <h5 class='text-red'>Relatório Atividades Disponíveis</h5>
        </div>
        <div class='row'>
          <p>Emissão: {$data} às {$hora}.</p>
        </div>
      </div>
      <div class='col-xs-4'>
        <img src='{$root}imagens/MARCA_UEMG.jpg' />
      </div>
    </div>
    <h5 style='margin-top: 2rem;'>{$evento_titulo['titulo']}</h5>
    <table>
    <thead>
      <tr class='bg-blue text-white'>
        <th style='width:60%'>Título</th>
        <th class='text-center'>Início</th>
        <th class='text-center' style='width:20%'>Participantes</th>
        <th class='text-center'>Vagas</th>
      </tr>
    </thead>
  <tbody>";

  $result_atividade = "SELECT a.id, a.titulo, DATE_FORMAT(a.data_inicio, 
                       '%d/%m/%Y') data_inicio, vagas_disp FROM atividades a 
                       INNER JOIN eventos e ON a.id_evento = e.id 
                       WHERE e.id = {$evento} 
                       AND vagas_disp > 0 
                       ORDER BY a.titulo";

  $resultado_atividade = mysqli_query(banco(), $result_atividade);

  while($row_atividade = mysqli_fetch_assoc($resultado_atividade)){
    $html .= '<tr>';
      $html .= "<td><p style='margin: 4px'>{$row_atividade['titulo']}</p></td>";
      $html .= "<td class='text-center'><p style='margin: 4px'>{$row_atividade['data_inicio']}</p></td>"; 

      $sql = "SELECT u.id FROM usuarios u 
              LEFT JOIN evento_pago ep ON u.id = ep.usuario 
              LEFT JOIN eventos e ON ep.evento = e.id 
              LEFT JOIN usuario_atividade ua ON u.id = ua.usuario 
              LEFT JOIN atividades a ON ua.atividade = a.id 
              WHERE e.id = {$evento} 
              AND ep.pagamento = 1 
              AND a.id = {$row_atividade['id']} ";

      $total_participantes = mysqli_num_rows(mysqli_query(banco(), $sql));

      $html .= "<td class='text-center'><p style='margin: 4px'>{$total_participantes}</p></td>"; 
      $html .= "<td class='text-center'><p style='margin: 4px'>{$row_atividade['vagas_disp']}</p></td>";
    $html .= '</tr>';
 
  }
  
  
  $html .= '</tbody>';
  $html .= '</table>';

  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  // include autoloader
  require_once("{$root}frameworks/dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  
  // Carrega seu HTML
  $dompdf->load_html("
    <meta charset='utf-8'>
    <link rel='stylesheet' type='text/css' href='../estilo.css'>
    <link rel='stylesheet' type='text/css' href='{$root}frameworks/bootstrap/css/bootstrap.min.css'>
    <style>
    
      table {
        border-collapse: collapse;
        width: 100%;
      }

      th{
        border: 1px solid #00000029;
        padding: 6px;
      }

      td{
        border: 1px solid #00000029;
      }

      tr:nth-child(even){background-color:  #f9f9f9}
      
      h5{
        text-transform: uppercase;
        font-weight: bold;
      }

      img{
        width: 70%;
        height: auto;
      }

    </style>      
    {$html}
  ");

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
