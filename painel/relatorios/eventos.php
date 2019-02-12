<?php 
  require_once('../utilitarios.php');

  $data = date('d/m/Y');
  $hora = date('H:i'); 

  $id_admin = getId($_SESSION['user']);

  if($id_admin !== 1){
    $result_evento = "SELECT id, titulo, 
                      DATE_FORMAT(STR_TO_DATE(data_inicio, '%Y-%m-%d'), '%d/%m/%Y') data_inicio, 
                      DATE_FORMAT(STR_TO_DATE(data_fim, '%Y-%m-%d'), '%d/%m/%Y') data_fim, 
                      organizador, 
                      valor,
                      pagar_para,
                      edital
                      FROM eventos 
                      WHERE status = 'Ativo' 
                      AND adm = {$id_admin} 
                      ORDER BY titulo";
  } 
  else{
    $result_evento = "SELECT id, titulo, 
                      DATE_FORMAT(STR_TO_DATE(data_inicio, '%Y-%m-%d'), '%d/%m/%Y') data_inicio, 
                      DATE_FORMAT(STR_TO_DATE(data_fim, '%Y-%m-%d'), '%d/%m/%Y') data_fim, 
                      organizador, 
                      valor,
                      pagar_para,
                      edital
                      FROM eventos 
                      WHERE status = 'Ativo' 
                      ORDER BY titulo";
  }
  
  $eventos = mysqli_fetch_all(mysqli_query(banco(), $result_evento), MYSQLI_ASSOC);
  
  $rows = mysqli_num_rows(mysqli_query(banco(), $result_evento));

  $html = "
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-8'>
      <div class='row'>
        <h5 class='text-red'>Relatório Eventos Disponíveis</h5>
      </div>
      <div class='row'>
        <p>Emissão: {$data} às {$hora}.</p>
      </div>
    </div>
    <div class='col-xs-4'>
      <img src='{$root}imagens/MARCA_UEMG.jpg' />
    </div>
  </div>";
  if($rows){
    foreach($eventos as $evento){
      $html .= "<h5>{$evento['titulo']}</h5>";

      $html .= "<table style='margin-bottom: 1rem'>
                  <thead>
                    <tr class='bg-blue text-white'>
                      <th class='text-center'>Início</th>
                      <th class='text-center'>Termino</th>
                      <th>Organizador</th>
                      <th>Valor</th>
                      <th>Pagar Para</th>
                    </tr>
                  </thead>
                  <tbody>";
                    $html .= "<tr>";
                      $html .= "<td class='text-center'><p style='margin: 4px'>{$evento['data_inicio']}</p></td>";
                      $html .= "<td class='text-center'><p style='margin: 4px'>{$evento['data_fim']}</td>";

                      $html .= "<td><p style='margin: 4px'>{$evento['organizador']}</td>";
                      
                      if($evento['edital'])
                        $html .= "<td><p style='margin: 4px'>Mais de um valor</p></td>";
                      else{
                        if(intval($evento['valor']) > 0)
                          $html .= "<td class='text-center'><p style='margin: 4px'>{$evento['valor']}</p></td>";
                        else
                          $html .= "<td class='text-center'><p style='margin: 4px'>Gratuito</p></td>";
                      }
                        

                      $html .= "<td><p style='margin: 4px'>{$evento['pagar_para']}</p></td>";
                    $html .= "</tr>";
                  $html .= '</tbody>';
                $html .= '</table>';

                $sql = "SELECT a.id FROM atividades a 
                        LEFT JOIN eventos e ON a.id_evento = e.id 
                        WHERE e.id = {$evento['id']} ";

                $total_atividades = mysqli_num_rows(mysqli_query(banco(), $sql));

                $sql = "SELECT u.id FROM usuarios u 
                        LEFT JOIN evento_pago ep ON u.id = ep.usuario 
                        LEFT JOIN eventos e ON ep.evento = e.id 
                        WHERE e.id = {$evento['id']} 
                        AND ep.pagamento = 1 ";

                $total_participantes = mysqli_num_rows(mysqli_query(banco(), $sql));

                $html .="<table style='margin-bottom: 2rem; width: 55%' align='center'>";
                  $html .='<thead>';
                    $html .="<tr class='bg-dark-yellow text-white'>";
                      $html .="<th class='text-center'>Total Atividades</th>";
                      $html .="<th class='text-center'>Total Participantes</th>";
                    $html .='</tr>';
                  $html .='</thead>';
                  $html .='<tbody>';
                    $html .="<tr class='text-center'>";
                      $html .="<td><p style='margin: 4px'>{$total_atividades}</p></td>";
                      $html .="<td><p style='margin: 4px'>{$total_participantes}</p></td>";
                    $html .='</tr>';
                  $html .='</tbody>';
                $html .='</table>';
    }
  }
  else{
    $html .= "<p style='margin: 8px;' align='center'>Nenhum evento disponível!</p>";
  }
  
  

  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;
  use Dompdf\Options;

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


  $dompdf->setPaper('A4', 'portrait');

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