<?php

  session_start();
  if(!isset($_SESSION['user']) || !isset($_POST['l']) || !isset($_POST['e'])){
    header("Location: /public/");

    die();
  }

  require_once('/public/dao/bd.php');

  $local      = base64_decode($_POST['l']);
  $evento_id  = base64_decode(filter_input(INPUT_POST, 
  'e', FILTER_SANITIZE_SPECIAL_CHARS));
  die();
  $objBd = new bd();
  $link = $objBd->conecta_mysql();

  // Pasta onde o arquivo vai ser salvo
  // $_UP['pasta'] = $_SERVER['DOCUMENT_ROOT']."/public/uploads/projetos/";

  

  // Tamanho máximo do arquivo (em Bytes)
  $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

  // Array com as extensões permitidas
  $_UP['extensoes'] = array('doc', 'docx', 'pdf');

  // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
  $_UP['renomeia'] = false;

  // Array com os tipos de erros de upload do PHP
  $_UP['erros'][0] = 'Não houve erro';
  $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
  $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
  $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
  $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($_FILES['arquivo']['error'] != 0 && $_FILES['arquivo']['error'] != 4) {
    $_SESSION['erro'] = base64_encode(1);

    mysqli_close($link);

    header("Location: {$local}");

    die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
  }

  if ($_FILES['arquivo']['error'] == 4) {
    $_SESSION['erro'] = base64_encode(1);

    mysqli_close($link);

    header("Location: {$local}");

    die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
  }

  // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
  // Faz a verificação da extensão do arquivo
  $extensao = substr(strstr($_FILES['arquivo']['type'], "/"), 1);

  if (array_search($extensao, $_UP['extensoes']) === false) {
    $_SESSION['erro'] = base64_encode(2);

    mysqli_close($link);

    header("Location: {$local}");
    
    die();
  }
  // Faz a verificação do tamanho do arquivo
  if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
    $_SESSION['erro'] = base64_encode(3);

    mysqli_close($link);

    header("Location: {$local}");
  }
  // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
  // Primeiro verifica se deve trocar o nome do arquivo

  $nome_final = $_FILES['arquivo']['name'];

  

  $nome_final = md5(htmlentities($nome_final, ENT_QUOTES)).'.'.$extensao;

  echo $_UP['pasta'].$nome_final;

  echo "<br/>".file_exists($_UP['pasta'] . $nome_final);
	
  while(file_exists($_UP['pasta'] . $nome_final)){
    $nome_final = md5(htmlentities($_FILES['arquivo']['name'], ENT_QUOTES).rand(1,9999)).'.'.$extensao;
  }
  
  // Depois verifica se é possível mover o arquivo para a pasta escolhida
  if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
    if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta_arquivo'] . $nome_arquivo_final)){
    // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo

    $data = date('Y-m-d H:i:s');

    $user = mysqli_fetch_array(
      mysqli_query(
        $link,
        "SELECT id FROM usuarios WHERE email = '{$_SESSION['user']}'"
      ),
      MYSQLI_ASSOC
    );

    $view_file = substr(strstr($nome_final, '.', true), 0);


    $sql = "SELECT * FROM projetos WHERE usuario = {$user['id']} AND evento = {$evento_id} AND aprovacao <> 0"; 

    if(mysqli_num_rows(mysqli_query($link, $sql))){
      $sql = "DELETE FROM projetos WHERE usuario = {$user['id']}";

      mysqli_query($link, $sql);
    }

    $sql = "INSERT INTO projetos(usuario, evento, nome, data_hora, aprovacao) VALUES ({$user['id']}, $evento_id, '$nome_final', '$data', 0)";

    mysqli_query($link, $sql);

    $_SESSION['success'] = base64_encode(1);
  } else {
    // Não foi possível fazer o upload, provavelmente a pasta está incorreta

    $_SESSION['erro'] = base64_encode(1);
}

mysqli_close($link);

// header("Location: {$local}");

die();
