<?php 

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y-m-d H:i');
  $date_emissao = date('d-m-Y H:i');


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

    tr:nth-child(even){background-color:  #f9f9f9}
    </style>

    <head>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    '.$date_emissao.'
    </head>

  <table style="font-size: 14px; border: 1px solid; border-radius: 3px; padding: -1px;" class="font-face">
  <thead>
      <tr style="background-color: #dcdcdc; text-align: center;">
        <th>ID</th>
        <th>Título</th>
        <th>Descricao</th>
        <th>Vagas totais</th>
        <th>Vagas Disponiveis</th>
        <th>Data início</th>
        <th>Data fim</th>
      </tr>
  </thead>
<tbody style="border-top: 1px groove; margin-top: -2px;" class="font-face">';

  
  $result_atividade = "SELECT * FROM atividades WHERE vagas_disp > 0";
  $resultado_atividade = mysqli_query($conn, $result_atividade);
  while($row_atividade = mysqli_fetch_assoc($resultado_atividade)){
    $html .= '<tr  style="text-align: center; padding: -1px;">';
    $html .= '<td style="padding: 8px;">'.$row_atividade['id'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['titulo'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['descricao'] . "</td>"; 
    $html .= '<td style="padding: 8px;">'.$row_atividade['vagas_total'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['vagas_disp'] . "</td>";  
    $html .= '<td style="padding: 8px;">'.$row_atividade['data_inicio'] . "</td>";
    $html .= '<td style="padding: 8px;">'.$row_atividade['data_fim'] . "</td>";  
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
      <h1 style="font-size: 20px; text-align: center;" class="font-face">Relatório Eventos</h1>
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