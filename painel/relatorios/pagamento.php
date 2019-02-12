<?php
  require_once('../utilitarios.php');

  $data = date('d/m/Y');
  $hora = date('H:i'); 

  $id_admin = getId($_SESSION['user']);

  $evento = base64_decode(filter_input(INPUT_GET, "e", 
            FILTER_SANITIZE_SPECIAL_CHARS));

  $result = "SELECT e.titulo, u.nome, u.email, u.telefone, ep.pagamento 
             FROM usuarios u 
             INNER JOIN evento_pago ep ON u.id = ep.usuario 
             INNER JOIN eventos e ON ep.evento = e.id 
             WHERE e.id = {$evento} 
             ORDER BY u.nome";

  $usuarios = mysqli_fetch_all(mysqli_query(banco(), $result), MYSQLI_ASSOC);

  $rows = mysqli_num_rows(mysqli_query(banco(), $result));

  $html = "
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-xs-8'>
        <div class='row'>
          <h5 class='text-red'>Relatório de Pagamentos</h5>
        </div>
        <div class='row'>
          <p>Emissão: {$data} às {$hora}.</p>
        </div>
      </div>
      <div class='col-xs-4'>
        <img src='{$root}imagens/MARCA_UEMG.jpg' />
      </div>
    </div>
    <h5>{$usuarios[0]['titulo']} {$rows}</h5>
    <table style='margin-bottom: 1rem'>
      <thead>
        <tr class='bg-blue text-white'>
          <th>Nome</th>
          <th class='text-center'>Contato</th>
          <th class='text-center'>Telefone</th>
          <th class='text-center'>Status</th>
        </tr>
      </thead>
      <tbody>
  ";
        foreach($usuarios as $usuario){
          $html .= "<tr>";
            $html .= "<td><p style='margin: 4px'>{$usuario['nome']}</p></td>";
            // $html .= "<td class='text-center'><p style='margin: 4px'>{$usuario['nome']}</p></td>";

            // if($usuario['telefone'] === "Não Informado" || empty($usuario['telefone']))
            //   $html .= "<td colspan='2'><p style='margin: 4px'>{$usuario['email']}</p></td>";
            // else{
            //   $html .= "<td><p style='margin: 4px'>{$usuario['email']}</p></td>";

            //   $html .= "<td class='text-center'><p style='margin: 4px'>{$usuario['telefone']}</p></td>";
            // }

            // if($usuario['pagamento']){
            //   $html .= "<td class='text-center bg-success'><p style='margin: 4px'>Pago</p></td>";
            // }
            // else{
            //   $html .= "<td class='text-center bg-erro'><p style='margin: 4px'>Pendente</p></td>";
            // }
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