<?php 
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location: /public/");
  }

  include('/public/frameworks/phpqrcode/qrlib.php');

  require_once('/public/dao/bd.php');

  require_once("/public/frameworks/dompdf/autoload.inc.php");
  
  //referenciar o DomPDF com namespace
  use Dompdf\Dompdf;

  $objBd = new bd();
  $link = $objBd->conecta_mysql();

  if(isset($_GET['ide'])){
    
    $ide = base64_decode(filter_input(INPUT_GET, 'ide', FILTER_SANITIZE_SPECIAL_CHARS));

    $sql = "SELECT * FROM eventos e INNER JOIN locais l ON e.id_local = l.id WHERE e.id = $ide";

    $evento = mysqli_fetch_array(mysqli_query($link, $sql));

    $data_inicio = new DateTime($evento['data_inicio']);
    $data_fim = new DateTime($evento['data_fim']);

    switch ($data_fim->format('m')) {
      case '01':
        $mes = 'Janeiro';
        break;
      case '02':
        $mes = 'Fevereiro';
        break;
      case '03':
        $mes = 'Março';
        break;
      case '04':
        $mes = 'Abril';
        break;
      case '05':
        $mes = 'Maio';
        break;
      case '06':
        $mes = 'Junho';
        break;
      case '07':
        $mes = 'Julho';
        break;
      case '08':
        $mes = 'Agosto';
        break;
      case '09':
        $mes = 'Setembro';
        break;
      case '10':
        $mes = 'Outubro';
        break;
      case '11':
        $mes = 'Novembro';
        break;
      case '12':
        $mes = 'Dezembro';
        break;
    }

    if($_SESSION['admin']){ // pre visualização do certificado (admin)
      $html = '
        <head>
          <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="estilo.css">
          <style>
            html{margin: 6rem; margin-bottom: 4.4rem;}
            body{
              margin: 0;            padding 0 !important;
              background-image: url("imagens/bg-certificado2.png");
              background-repeat: no-repeat; background-position: center;
              background-size: 500px 344px !important;

              border: 8px solid rgb(59,110,143); 

            }
            .corpo{margin: 5rem; margin-top: 10rem;}
            .corpo>h1{color: rgb(130, 0, 36)}
            .corpo>h3{color: rgb(0, 43, 92)}
            .img-uemg{width: 450px; text-align: right}

            </style>
        </head>
        <body>
          <div class="container">
            <div class="col-6"></div>
            <div class="col-6 pull-right"><img class="img-uemg" src="imagens/MARCA_UEMG.jpg"></div>
            <div class="corpo font-corpo">
              <h1 align="center">Certificado</h1>
              <h3 align="center">Certificamos que <span id="nome">Nome do Aluno</span> participou do evento <span id="nome">'.$evento["titulo"].'</span> que ocorreu  entre os dias '.$data_inicio->format('d').' à '.$data_fim->format('d').' de '.$mes.' de '.$data_fim->format('Y').'.</h3>
              <h3 align="center" style="margin-top:5rem; margin-bottom: 0">'.$evento['local'].'</h3>
              <hr style="margin: 1rem 4rem;">
              <h3 align="center" style="margin-top: 0">Local</h3>
            </div>

            <div class="container">
              <div class="ass">
                <span class="org">
                  <h4>'.$evento['organizador'].'</h4>
                  <span>Organizador</span>
                </span>
                <span class="dir">
                  <h4>Allyson Takehiro Fujita</h4>
                  <span>Diretor</span>
                </span>
              </div>
            </div>
          </div>  
          
        </body>
          ';
    }
    else{ // Usuário comum
        // a margem abaixo deve ser -1.6rem a menos

      $user =   mysqli_fetch_array(
                  mysqli_query(
                    $link, 
                    "SELECT id, nome, cpf FROM usuarios WHERE email = '{$_SESSION['user']}'"
                  ), 
                  MYSQLI_ASSOC
                );
      // Gerando o QRcode pelo cpf do usuário, que será gerado uma imagem.
      QRcode::png($ide.",".$user['cpf'], "code_".$user['nome'].".png", QR_ECLEVEL_M,4);
      
      $sql = "SELECT a.titulo, a.data_inicio, a.hora_inicio, a.hora_fim FROM atividades a INNER JOIN usuario_atividade ua ON a.id = ua.atividade WHERE ua.usuario =".$user['id']." AND ua.presenca = 1 ORDER BY a.data_inicio";

      $sql = "SELECT * FROM eventos WHERE id = $ide";

      $evento = mysqli_fetch_array(mysqli_query($link, $sql), MYSQLI_ASSOC);


      $html = '
          <div class="credencial-front">
            <figure class="cred-banner">
              <img src="/public/uploads/img-eventos/'.$evento['banner'].'" />
            </figure>

            <div class="cred-evento">
              <p>'.$evento['titulo'].'</p>
            </div>
            
            <div class="cred-corpo">

              <div class="cred-logo"><img src="/public/imagens/UEMG-Logo.png"></div>

              <div class="cred-participante">
                <p style="font-size: 0.25cm;"><span>Participante </span><br><span style="text-transform: uppercase; font-weight: 900; font-size: 0.44cm; padding-top: 0.1cm">'.$user['nome'].'</p>
              </div>             

              <div class="cred-code"><p class="cred-cpf">'.$user['cpf'].'<br><span style="font-size: 0.2cm;">Código</span></p></div>
              <div class="cred-qrcode"><img src="code_'.$user['nome'].'.png"><div>
              
            </div>
          </div>

          <div class="credencial-back">
            <div class="cred-corpo-back">
              <div class="cred-cpf cred-cronograma">
                <p>Meu cronograma</p>
              </div>
              <div class="chrono-table">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th class="primeira-coluna">Atividade</th>
                      <th>Data</th>
                      <th>Início</th>
                      <th>Fim</th>

                      <th>Atividade</th>
                      <th>Data</th>
                      <th>Início</th>
                      <th>Fim</th>';

      $html .=' </tr>
          </thead>
          <tbody>';

      $i = 1;

      $res_atividades = mysqli_query(
        $link, 
        "SELECT titulo, data_inicio, 
                hora_inicio, hora_fim 
          FROM atividades a 
          INNER JOIN usuario_atividade ua ON a.id = ua.atividade 
          INNER JOIN usuarios u ON ua.usuario = u.id 
          WHERE u.id = {$user['id']}"
      );

      while($atividades = mysqli_fetch_array($res_atividades, MYSQLI_ASSOC)){
        $data = new DateTime($atividades['data_inicio']);

        $hora_inicio = new DateTime($atividades['hora_inicio']);
        $hora_fim = new DateTime($atividades['hora_fim']);


        if($i == 1){
          $html .= '  <tr>
                        <td class="td-titulo">'.$atividades['titulo'].'</td>
                        <td class="td-data">'.$data->format('d/m').'</td>
                        <td class="td-inicio">'.$hora_inicio->format('H:i').'</td>
                        <td class="td-fim">'.$hora_fim->format('H:i').'</td>';
          $i++;
        }
        else{
            $html .= '  <td class="cred-segunda-coluna">'.$atividades['titulo'].'</td>
                        <td>'.$data->format('d/m').'</td>
                        <td>'.$hora_inicio->format('H:i').'</td>
                        <td>'.$hora_fim->format('H:i').'</td>
                      </tr>';
          $i--;
        }
      }
      $html .=' 
              </tbody>
            </table>
          </div>
          <div class="footer"></div>
        </div>
      </div>';
    }
  }
  // <table class="chrono-table">
  //               <thead>
  //                 <tr>
  //                   <th>Horário</th>
  //                   <th>Atividade</th>
  //                   <th>Local</th>
  //                 </tr>
  //               </thead>
  //               <tbody>
  //                 <tr>
  //                   <td>18:00</td>
  //                   <td>Como fazer olar <span style="font-style: italic; color: rgb(227, 24, 55);">(Joãozinho das Magnolia)</span></td>
  //                   <td>Lab 1</td>
  //                 </tr>
  //               </tbody>                
  //             </table>
  //Criando a Instancia
  $dompdf = new Dompdf();
  
  // Carrega seu HTML
  $dompdf->load_html(" 
    <meta charset='utf-8'>
    <title>Credencial</title>
    <link href='public/frameworks/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' type='text/css' href='/public/estilo.css'>

    <style>
      html{margin: -18px 0px;}
      body{
        margin: 0;            padding 0 !important;
      }

      table{
        width: 100%;                        font-size: 0.32cm;
      }

      td{padding-bottom: 20px !important;}
      th{font-size: 2.4rem!important;}

      .credencial-front{
        width: 10cm;                      height: 14cm;
        padding-right: 3px;
          padding-bottom: 3px;
        
        border-right: 2px dashed black;
          border-bottom: 2px dashed black;
      }

      .credencial-back{
        width: 21cm;			height: 29.7cm;             
      
        position: fixed;
          top: 15cm;
        margin-right: 3px;
      }
      
      .cred-banner{
        margin: 0;
      }
        .cred-banner img{width: 100%; height: 4cm;}

      .cred-evento{
        height: 1cm;
        background: #3b6e8f;
        font-size: 3em;             font-weight: 900;
        color: white;               text-align: center;
        text-transform: uppercase;
      }
        .cred-evento p{
          margin: 0;
          position: relative;
            top: 1%;
        }
      
      .cred-corpo{
        background-color: #ddd;
        background-position: center;        background-size: 10cm 9cm;
        width: 100%;                        height: 9cm;
        border-left: 0.2cm solid rgb(227, 24, 55);
      }
      
      .cred-participante{
        background: white;
        padding: 0cm 0.5cm 0.1cm;
      
        margin: 0.5cm 1cm;			margin-left: 0;
      
        border-radius: 0 20px 20px 0;
      }
      
      .cred-qrcode{
        position: absolute; 
        top: 10.51cm;			left: 6.5cm;
      }
        .cred-qrcode img{width: 3.5cm; height: 3.5cm; border-radius: 20px 0 0 0;}
      
      .cred-code{
        width: 6.4cm;                       height: 1.5cm;
        background: white;
      
      
        position: absolute;
        top: 7.5cm;
      }
      
      .cred-cpf{
        text-align: center;                 text-transform: uppercase;
        font-size: 0.5cm;
        color: #333;                        font-weight: 900;
      
        margin: 30px;
      }
      
      .cred-logo{
        position: fixed;
      
        top: 8cm;                           left: 3.5cm;
      
      }
        .cred-logo img{width: 3cm; height: 3cm;}
      
      .cred-corpo-back{
        width: 100%;                        height: 14cm;
        font-size: 0.35cm;
      
      }
      
      .cred-cronograma{
        background: #3c6e8f;                padding: 30px;
        margin: 0;                          color: white;             
      }
      
      .chrono-table{
        height: 100%;
        padding: .8cm 0.6cm;
        border-left: 0.2cm solid rgb(227, 24, 55);
      }
      
      .cred-segunda-coluna{border-left: 1px solid #ddd; padding-left: 20px !important;}
    </style>        
    {$html}
");

  // Configurando o DPI
  $dompdf->set_option('dpi', '300');

  //Setando a posição do papel
  $dompdf->set_paper('A4', 'portrait');

  //Renderizar o html
  $dompdf->render(header('Content-type: text/html; charset=UTF-8'));

  //Exibibir a pÃ¡gina
  $dompdf->stream(
    "Credencial - ".$evento['titulo'].".pdf", 
    array(
      "Attachment" => false //Para realizar o download somente alterar para true
    )
  );


  unlink("code_".$user['nome'].".png");

?>