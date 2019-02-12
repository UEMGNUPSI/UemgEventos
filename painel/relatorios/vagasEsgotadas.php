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
          <h5 class='text-red'>Relatório Atividades Esgotadas</h5>
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
      <th class='text-center'>Data início</th>
      <th class='text-center' style='width:20%'>Participantes</th>
    </tr>
  </thead>
<tbody>";

  $result_atividade = "SELECT a.id, a.titulo atividade, 
                       DATE_FORMAT(a.data_inicio, '%d/%m/%Y') data_inicio,
                       e.titulo evento
                       FROM atividades a 
                       INNER JOIN eventos e ON a.id_evento = e.id 
                       WHERE e.id = {$evento} 
                       AND e.status = 'Ativo' 
                       AND vagas_disp <= 0 
                       ORDER BY a.titulo";

  $resultado_atividade = mysqli_query(banco(), $result_atividade);
  $rows = mysqli_num_rows(mysqli_query(banco(), $result_atividade));
  if($rows){
    while($row_atividade = mysqli_fetch_array($resultado_atividade, MYSQLI_ASSOC)){
      $html .= "<tr>";
        $html .= "<td><p style='margin: 4px;'>{$row_atividade['atividade']}</p></td>";
        $html .= "<td class='text-center'>{$row_atividade['data_inicio']}</td>";

        $id_admin = getId($_SESSION['user']);

        if($id_admin !== 1){
          $participantes = mysqli_num_rows(mysqli_query(
            banco(), 
            "SELECT u.id FROM usuarios u 
             LEFT JOIN usuario_atividade ua ON u.id = ua.usuario 
             LEFT JOIN atividades a ON ua.atividade = a.id 
             LEFT JOIN evento_pago ep ON u.id = ep.usuario 
             LEFT JOIN eventos e ON ep.evento = e.id 
             WHERE a.id = {$row_atividade['id']} 
             AND e.adm = {$id_admin} 
             AND ep.pagamento = 1 
             GROUP BY u.id "
            )
          );
        }
        else{
          $participantes = mysqli_num_rows(mysqli_query(
            banco(), 
            "SELECT u.id FROM usuarios u 
             LEFT JOIN usuario_atividade ua ON u.id = ua.usuario 
             LEFT JOIN atividades a ON ua.atividade = a.id 
             LEFT JOIN evento_pago ep ON u.id = ep.usuario 
             LEFT JOIN eventos e ON ep.evento = e.id 
             WHERE a.id = {$row_atividade['id']} 
             AND ep.pagamento = 1 
             GROUP BY u.id "
            )
          );
        }
        
        
        $html .= "<td class='text-center'><strong>{$participantes}</strong></td>";
      $html .= '</tr>';
    }
  }
  else{
    $html .= "<tr>";
      $html .= "<td colspan='3' align='center'><p style='margin: 8px;'>Nenhuma atividade esgotada!</p></td>";
    $html .= "</tr>";
  }
  
  $html .= '</tbody>';
  $html .= '</table>';
  $html .= '</div>';

  
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