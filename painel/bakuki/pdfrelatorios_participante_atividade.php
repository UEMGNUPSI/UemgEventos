<?php 
  session_start();
  if(!isset($_SESSION['usuario']) || $_SESSION['admin'] == false){
    header("Location: ../index.php");
  }

  $date = date('Y-m-d H:i');
  $date_emissao = date('d-m-Y');
  $hore_emissao = date('H:i');

  require_once('../bd.class.php');

  $objBd = new bd();
  $link = $objBd->conecta_mysql(); 

  $html = '<style>
    *{margin-top: 0}
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
  <div style="margin: 2px 0">
  <table style="font-size: 14px; border: 1px solid; border-radius: 3px; padding: -1px;" class="font-face">
  <thead>
      <tr style="background-color: #dcdcdc; text-align: center;">
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>CPF</th>
      </tr>
  </thead>
<tbody style="border-top: 1px solid; margin-top: -2px;" class="font-face">';

  $id = isset($_GET['evento'])? $_GET['evento'] : '' ;

  $sql = 'SELECT u.* FROM usuarios u INNER JOIN evento_pago ep ON u.id = ep.usuario INNER JOIN usuario_atividade ua ON u.id = ua.usuario INNER JOIN atividades a ON ua.atividade = a.id WHERE a.id = '.$id.' ORDER BY u.nome';

  $resultado_atividade = mysqli_query($link, $sql);

  $row = mysqli_num_rows($resultado_atividade);



  if($row > 0){
    while($atividade = mysqli_fetch_assoc($resultado_atividade)){
      //  Formatando CPF
      $cpf1 = substr($atividade['cpf'], 0, 3);
      $cpf2 = substr($atividade['cpf'], 3, 3);
      $cpf3 = substr($atividade['cpf'], 6, 3);
      $cpf4 = substr($atividade['cpf'], 9, 2);

      $tel = !empty($atividade['telefone'])? $atividade['telefone'] : 'Não informado';
      $cnpj = !empty($atividade['cnpj'])? $atividade['cnpj'] : 'Não informado';
      $cpf_final = $cpf1 .".".$cpf2.".".$cpf3."-".$cpf4;

      $html .= '<tr  style="text-align: center;">';
      $html .=' <td style="padding: 8px;">'.$atividade['nome']. "</td>";
      $html .= '<td style="padding: 8px;">'.$atividade['email']. "</td>";
      $html .= '<td style="padding: 8px;">'.$tel. "</td>";
      $html .= '<td style="padding: 8px;">'.$cpf_final. "</td>";
      $html .= '</tr>';
    }
  }
  else{
    $html .= '<tr  style="text-align: center; padding: -1px;">';
    $html .= '<td td style="padding: 8px;" colspan="4">Nenhum usuário inscrito.</td></tr>';
  }

  $html .= '</tbody>';
  $html .= '</table';
  $html .= '</div>';
  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  // include autoloader
  require_once("../dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  $dompdf->set_paper('A4', 'portrait');
  $sql = "SELECT titulo FROM atividades WHERE id = ".$id;

  $res_atividade = mysqli_query($link, $sql);

  $atividade = mysqli_fetch_array($res_atividade, MYSQLI_ASSOC);

  // Carrega seu HTML
  $dompdf->load_html('
      <h1 style="font-size: 20px; text-align: center;" class="font-face">Relatório de Presença<br>'.$atividade['titulo'].'</h1><br>
      <h2 class="font-face" align="center">Participantes Presentes</h2>
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