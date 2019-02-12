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

  $id = isset($_GET['evento'])? $_GET['evento'] : 0;

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
  <table style="font-size: 14px; border: 1px solid; border-radius: 3px; padding: -1px;" class="font-face">
  <thead>
      <tr style="background-color: #dcdcdc; text-align: center;">
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>CPF</th>
      </tr>
  </thead>
<tbody style="border-top: 1px groove; margin-top: -2px;" class="font-face">';
  
  $sql = "SELECT u.* FROM usuarios u INNER JOIN evento_pago ep ON u.id = ep.usuario INNER JOIN eventos e ON ep.evento = e.id WHERE e.id = ".$id." AND e.status = 'Ativo' ORDER BY u.nome";
  $resultado_user = mysqli_query($link, $sql);
  $rows = mysqli_num_rows($resultado_user);
  if($rows > 0){
    while($user = mysqli_fetch_assoc($resultado_user)){
      $cpf1 = substr($user['cpf'], 0, 3);
      $cpf2 = substr($user['cpf'], 3, 3);
      $cpf3 = substr($user['cpf'], 6, 3);
      $cpf4 = substr($user['cpf'], 9, 2);

      $tel = !empty($user['telefone'])? $user['telefone'] : 'Não informado';
      $cnpj = !empty($user['cnpj'])? $user['cnpj'] : 'Não informado';
      $cpf_final = $cpf1 .".".$cpf2.".".$cpf3."-".$cpf4;

      $html .= '<tr  style="text-align: center;">';
      $html .=' <td style="padding: 8px;">'.$user['nome']. "</td>";
      $html .= '<td style="padding: 8px;">'.$user['email']. "</td>";
      $html .= '<td style="padding: 8px;">'.$tel. "</td>";
      $html .= '<td style="padding: 8px;">'.$cpf_final. "</td>";
      $html .= '</tr>';
    }
  }
  else{
    $html .= '<tr style="text-align: center; padding: -1px;">';

    $html .= '<td td style="padding: 8px;" colspan="4">Nenhum usuário inscrito.</td></tr>';
  }

  
  $html .= '</tbody>';
  $html .= '</table>';

  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;
 
  // include autoloader
  require_once("../dompdf/autoload.inc.php");

  //Criando a Instancia
  $dompdf = new DOMPDF();
  $sql = "SELECT titulo FROM eventos WHERE id = ".$id;
  $dompdf->set_paper('A4', 'portrait');
  $res_evento = mysqli_query($link, $sql);

  $evento = mysqli_fetch_array($res_evento, MYSQLI_ASSOC);
  // Carrega seu HTML
  
  $dompdf->load_html('
      <h1 style="font-size: 20px; text-align: center;" class="font-face">Relatório de Presença<br>'.$evento['titulo'].'</h1><br>
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