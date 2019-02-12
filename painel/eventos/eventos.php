<?php 

require_once("../utilitarios.php");

$evento = array(
  "id"                  => -1,
  "titulo"              => "",
  "descricao"           => "",
  "data_inicio"         => "",
  "data_fim"            => "",
  "organizador"         => "",
  "valor"               => "",
  "pagar_para"          => "Ninguém",
  "status"              => "Ativo",
  "local"               => "",
  "edital"              => 0,
  "submissao_projeto"   => 0,
  "certificado"         => 0,
  "arquivo_edital"      => 0,
  "regra"               => "50.1",
  "banner"              => "",
  "adm"                 => ""
);

if(isset($_GET['e'])){
  
  $id = base64_decode(filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS));

  $base64_evento = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);

  if(!validaAdm($_SESSION['user'], $id)){
    $_SESSION['erro'] = base64_encode(9);
    header("Location: ../eventos/");
    
    die();
  }

  $link = banco();

  $sql = "SELECT e.*, l.local FROM eventos e INNER JOIN locais l ON e.id_local = l.id WHERE e.id = ".$id;
 
  if($result_evento = mysqli_query($link, $sql)){
    $dados = mysqli_fetch_array($result_evento);

    mysqli_close($link);

    if(isset($dados['titulo'])){

      $evento['id']                 = $dados['id'];
      $evento['titulo']             = $dados['titulo'];
      $evento['descricao']          = nl2br($dados['descricao']);
      $evento['data_inicio']        = $dados['data_inicio'];
      $evento['data_fim']           = $dados['data_fim'];
      $evento['organizador']        = $dados['organizador'];
      $evento['valor']              = $dados['valor'];
      $evento['pagar_para']         = $dados['pagar_para'];
      $evento['status']             = $dados['status'];
      $evento['local']              = $dados['local'];
      $evento['edital']             = $dados['edital'];
      $evento['arquivo_edital']     = $dados['arquivo_edital'];
      $evento['submissao_projeto']  = $dados['submissao_projeto'];
      $evento['certificado']        = $dados['certificado'];
      $evento['regra']              = $dados['regra'];
      $evento['banner']             = $dados['banner'];
      $evento['adm']                = $dados['adm'];
      
      unset($dados);

    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php
    require_once("../head.php");
		 
    if($evento['id'] === -1)
      head("Novo Evento");
    else
      head($evento['titulo']);
  ?>
</head>
<body>  
  <main class='container-fluid'>
    <section class="row">
<?php
  require_once("../nav.php");
  navbar("eventos");

  if($evento['id'] === -1)
    navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> Novo Evento", "", "../eventos/");
  else
    navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$evento['titulo']}", "", "../eventos/");

  include_once("{$root}dialog.php");
  if(isset($_SESSION['success'])){
    switch(base64_decode($_SESSION['success'])){
      case '1':
        dialog("success", "Evento salvo com sucesso!");
      break;
      case '2':
        dialog("success", "Evento atualizado com sucesso!");
      break;
      case '7':
        dialog("success", "Banner removido com sucesso!");
      break;
      case '8':
        dialog("success", "Edital removido com sucesso!");
      break;
      case '9':
        dialog("success", "Certificados distribuídos com sucesso!");
      break;
      
    }
  }
  
  if(isset($_SESSION['erro'])){
    switch(base64_decode($_SESSION['erro'])){
      case '1':
        dialog("erro", "Não foi possível salvar este evento!<br />Tente novamente mais tarde.");
      break;
      case '2':
        dialog("erro", "Não foi possível atualizar este evento!<br />Tente novamente mais tarde.");
      break;
      case '3':
        dialog("erro", "O banner não está dentro dos requisitos necessários.");
      break;
      case '4':
        dialog("erro", "O edital não está dentro dos requisitos necessários.");
      break;
      case '5':
        dialog("erro", "Tamanho excedido para o banner.");
      break;
      case '6':
        dialog("erro", "Tamanho excedido para o edital.");
      break;
      case '7':
        dialog("erro", "Não foi possível remover o banner deste evento!<br />Tente novamente mais tarde.");
      break;
      case '8':
        dialog("erro", "Não foi possível remover o edital deste evento!<br />Tente novamente mais tarde.");
      break;
      case '9':
        dialog("alert", "Você não tem permissão para acessar essa página!");
      break;
      case '10':
        dialog("erro", "Não foi possível distribuir os certificados deste evento!<br />Tente novamente mais tarde.");
      break;
      case '11':
        dialog("alert", "Nome existente.<br />Tente outro título para seu evento.");
      break;
    }
  }
  
?> 
  <section class="corpo col-sm-11 col-md-10">
    <?php 
      if($evento['id'] !== -1)
        navTopEventoMobile("");
    ?>
    <section class="row top-admin" style='padding-bottom: 15px'>
      <div class="col-md-8 col-md-offset-2">
        <label><span class='icon glyphicon glyphicon-picture'></span> Banner do Evento</label>
        
        <a tabindex="0" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Este campo informa qual banner (imagem de capa) para seu evento, deixando ele em branco será colocada uma imagem padrão. Caso queira colocar uma imagem clique em escolher arquivo, saiba que a imagem deve estar dentro das seguintes especificações: dimensão de 1140px (Um Mil Cento e Quarenta Pixels) por 500px (Quatrocentos e Quarenta e Cinco Pixels), tamanho máximo de 2MB (Dois Megabyte) e nos formatos .png e .jpg."><span class='glyphicon glyphicon-question-sign'></span></a>

        <?php if($evento['banner'] !== ""){ ?>
          <div id="div-banner" style="margin-bottom: 15px">
            <figure>
              <?php echo "<img class='img-responsive' src='/public/uploads/img-eventos/{$evento['banner']}' />"; ?>
            </figure>
          </div>
          <section class="row">
            <div class="col-xs-12" style='margin-bottom: 15px'>
              <label for="banner" class='middleX text-justify'>Dimensões: 1140px por 500px - Tamanho máx: 2MB - Formatos: .png ou .jpg</label>
            </div>
            <div class="col-sm-8" style='margin-bottom: 15px'>
              <input id="banner" form="formEvento" type="file" name="banner" accept=".png, .jpg, .jpeg" />
            </div>
          
            <?php if($evento['banner'] !== "padrao.png"){ ?>
              <form id="form-removerBanner" class='col-sm-4' method="post" <?php echo "action='{$dao}atualizar/evento.php?e={$base64_evento}'";?> align='center'>
                <button for="form-removerBanner" class="btn btn-danger"><span class="icon glyphicon glyphicon-trash"></span> Remover Imagem</button>

                <input id="removerBanner" name="removerBanner" type="hidden" value="1" />

                <input id="imgBanner" name="imgBanner" type="hidden" <?php echo "value='{$evento['banner']}'"; ?> />
              </form>
            <?php } ?>
          </section>
        <?php 
        }
        else{ ?>
          <section class="row">
            <div class="col-xs-12" style='margin-bottom: 15px'>
              <label for="banner" class='middleX text-justify'>Dimensão: 1140px por 500px - Tamanho máx: 2MB - Formatos: .png ou .jpg</label>
            </div>
            <div class="col-md-12" style='margin-bottom: 15px'>
              <input id="banner" form="formEvento" type="file" name="banner" accept=".png, .jpg, .jpeg" />
            </div>
          </section>
        <?php } 
          if($evento['id'] !== -1 && $evento['certificado']){ ?>
            <section class="row">
              <div class="col-xs-12">
                <section class="row">
                  <div class="col-xs-12">
                    <label>Distribuir Certificados</label>

                    <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Você ativou a opção de gerar certificados automaticamente. Isso significa que clicando no botão gerar será disponibilizado a todos os participantes, que estão fora da regra de corte, irão receber o certificado. Saiba que você poderá executar essa ação apenas uma vez."><span class='glyphicon glyphicon-question-sign'></span></a>
                  </div>
                </section>
                
                <?php
                  require_once("{$root}dao/adm/select/index.php");
                  
                  if(getDistribuirCertificados($evento['id']))
                    echo "<button class='btn btn-info' disabled><span class='icon glyphicon glyphicon-education'></span> Distribuir</button>";
                  else
                    echo "<a class='btn btn-info' href='{$dao}atualizar/certificado.php?e={$base64_evento}'><span class='icon glyphicon glyphicon-education'></span> Distribuir</a>";
                ?>
                
                
              </div>
            </section>
        <?php } ?>
        
      </div>
    </section>
    <?php
      if($evento['id'] === -1)
        $action = "/public/dao/adm/novo/evento.php";
      else
        $action = "/public/dao/adm/atualizar/evento.php?e=".base64_encode($evento['id']);
    ?>
    <form id="formEvento" method="post" <?php echo "action='{$action}'"; ?> enctype="multipart/form-data" style="padding: 0 2rem;">
      <p><b>Dúvida sobre algum campo?</b> Clique em <span class='duvida glyphicon glyphicon-question-sign'></span> ao lado do campo.</p>
      <section class='row'>      
        <div class="col-sm-6 form-group" style="margin-bottom: 2rem">
          <label for="titulo"><span class='glyphicon glyphicon-tags' style='top: 4px;'></span> Título (máx: 36 caracters)</label>
          
          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo nomeará o evento, deve no máximo conter 36 (Trinta e Seis) caracteres. Não é possível existir dois eventos com nomes iguais."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="titulo" class="form-control" type="text"  name="titulo" maxlength="36" <?php echo "value='{$evento['titulo']}'" ?> tabindex="10" required />
        </div>
        <div class="col-sm-6 form-group">
          <label for="organizador"><span class='icon glyphicon glyphicon-user'></span> Organizador (máx: 36 caracteres)</label>
          
          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Neste campo deverá informar apenas UM dos integrades da equipe organizadora, isso caso opte pelo sistema gerar o certificado automaticamente. Deve no máximo conter 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="organizador" class="form-control" type="text"  name="organizador" maxlength="36" <?php echo "value='{$evento['organizador']}'" ?> placeholder='Preencha com um nome apenas do responsável.' tabindex="11" required="true">
        </div>
      </section>
      <section class="row">
        <div class="col-sm-6 form-group">
          <?php
            $link = banco();
            $locais = mysqli_query($link, "SELECT id, local FROM locais");
            if(mysqli_num_rows($locais)){
              echo '<label for="local"><span class="icon glyphicon glyphicon-home"></span> Local</label> ';

              echo '<a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará o local onde será realizado o evento."><span class="glyphicon glyphicon-question-sign"></span></a>';

              echo '<select id="local" class="form-control" name="local" tabindex="12" required>';
                while($local = mysqli_fetch_array($locais, MYSQLI_ASSOC)){
                  if($local['local'] === $evento['local']){
                    echo '<option value="'.$local['id'].'" selected>'.$local['local'].'</option>';
                  }
                  else{
                    echo '<option value="'.$local['id'].'">'.$local['local'].'</option>';
                  }
                }
              echo "</select>";
            }
            else{
              echo '<label for="local"><span class="icon glyphicon glyphicon-home"></span> Local <span class="text-danger">*Nenhum local cadastrado</span></label> ';

              echo '<a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará o local onde será realizado o evento. Note que não há nenhum local, para acrescentar um local vá na área Locais no menu lateral."><span class="glyphicon glyphicon-question-sign"></span></a>';

              echo '<select id="local" class="form-control" name="local" tabindex="12" required></select>';
            }
          ?>
        </div>
      </section>
      <section class="row">
        <div class="col-xs-12 form-group">
          <label for="descricao"><span class="icon glyphicon glyphicon-pencil"></span> Descrição (máx: 500 caracteres)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Escreva um breve resumo sobre o evento. Deve no máximo conter 500 (Quinhentos) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <textarea id="descricao" class="form-control" rows="5" maxlength="500" name="descricao" tabindex="12" required><?php echo $evento['descricao'];?></textarea>
        </div>
      </section>
      <section class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="data_inicio"><span class='icon glyphicon glyphicon-calendar'></span> Data de Início</label>

            <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará quando se dará início ao evento. A data deverá conter o seguinte formato DD/MM/AAAA."><span class='glyphicon glyphicon-question-sign'></span></a>

            <input type="date" id="data_inicio" name="data_inicio" <?php echo "value='{$evento['data_inicio']}'" ?> class="form-control" tabindex="13" required>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label for="data_fim"><span class='icon glyphicon glyphicon-calendar'></span> Data de Término</label>

            <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará quando será o termino do evento. A data deverá conter o seguinte formato DD/MM/AAAA."><span class='glyphicon glyphicon-question-sign'></span></a>

            <input  id="data_fim" class="form-control" type="date" name="data_fim" <?php echo "value='{$evento['data_fim']}'" ?>  tabindex="14" required>
          </div>
        </div>
      </section>
      <section class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="valor"><span class="glyphicon glyphicon-credit-card" style='top: 3px;'></span> Preço (mín: 0 máx: 9999)</label>

            <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Caso seu evento seja pago, informe o valor a se pagar neste campo. Caso seja mais de um valor preencha com qualquer valor EXCETO 0 (Zero) e marque a opção ao lado. Caso seja um evento gratuito, preencha com o valor 0 (Zero). Os valores devem estar entre 0 (Zero) a 9999 (Nove Mil Novecentos e Noventa e Nove)."><span class='glyphicon glyphicon-question-sign'></span></a>

            <div class="input-group">
              <div class="input-group-addon">R$</div>
              <input type="number" class="form-control" id="valor" name="valor" maxlength="4" min="0" max="9999" <?php echo "value='{$evento['valor']}'" ?> tabindex="15">
              <div class="input-group-addon">.00</div>
            </div>
          </div>
        </div>
        <div class="col-sm-6" style="padding-right: 0px;">
          <label for="edital"><span class='icon glyphicon glyphicon-plus'></span> Mais de um valor</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Marque esta opção APENAS se seu evento seja PAGO (campo preço preenchido com o valor acima de 1 (Um)) e possua preços diferentes a serem pagos. Marcando essa opção, no evento será substituido o valor no local de preço por consulte o edital."><span class='glyphicon glyphicon-question-sign'></span></a>

          <div class="input-group">
            <?php $check = $evento["edital"] ? "checked" : ""; ?>
            <input type="checkbox" id="edital" name="edital" onclick="editalObrigatorio()" <?php echo $check; ?> tabindex="16" /><label for="edital" class='label-check'>Marque para exibir "consulte o edital".</label>
          </div>
        </div>
      </section>
      <section class='row'>
        <div class="col-sm-6 form-group">
          <label for="pagar_para"><span class='glyphicon glyphicon-transfer' style='top: 4px'></span> Pagar para (máx: 36 caracteres)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará a quem deverá ser pago para participar do evento, podendo ser uma conta corrento, algum tipo de contato (email, telefone, etc.) ou apenas uma pessoa. Caso seu evento seja gratuito, preencha exatamente com o texto Ninguém. Tamanho máximo é de 36 (Trinta e Seis) caracteres."><span class='glyphicon glyphicon-question-sign'></span></a>

          <input id="pagar_para" class="form-control" type="text" name="pagar_para" maxlength="36" <?php echo "value='{$evento['pagar_para']}'" ?>  tabindex="16" required />
        </div>
      </section>
      <section class="row">
        <div class="col-sm-6 form-group">
          <label for="status"><span class='icon glyphicon glyphicon-stats'></span> Status</label>
          
          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará se o evento está ativo ou desativado. Isso significa que quando ativo o evento tornará visível a todos os usuários. Desativado deverá ser marcado, caso não queria que o evento começe a ser divulgado ou quando o evento foi finalizado."><span class='glyphicon glyphicon-question-sign'></span></a>

          <select id="status" class="form-control" name="status" tabindex="17">
            <?php
              $ativo      = $evento['status'] === "Ativo"       ? "selected" : "";
              $desativado = $evento['status'] === "Desativado"  ? "selected" : "";
            ?>
            <option value="Ativo" <?php echo $ativo; ?>>Ativo</option>
            <option value="Desativado" <?php echo $desativado; ?>>Desativado</option>
          </select>
        </div>
        <div class="col-sm-6 form-group">
          <label for="valor"><span class='icon glyphicon glyphicon-education'></span> Certificado</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Esta opção deverá ser marcada caso queira que o sistema faça um certificado padrão para os participantes dentro da regra de corte estabelecida. No certificado conterá o nome do evento, nome do participante, assinatura eletrônica do atual diretor da unidade Frutal e ainda a assinatura do organizador do evento. Devido a assinatura do organizador é importante que no campo organizador tenha apenas UM dos nomes dos organizadores."><span class='glyphicon glyphicon-question-sign'></span></a>

          <div class="input-group">
            <?php 
              $marcado = $evento['certificado'] ? "checked" : "";
              echo "<input id='certificado' type='checkbox'  name='certificado' tabindex='18' onclick='showRule()' {$marcado} />";
            ?>
            <label for="certificado" class='label-check'>Gerar o certificado automaticamente.</label>
          </div>
        </div>
      </section>
      <section class="row">
        <div id="input-regra" class="col-sm-6 form-group">
          <label for="regra"><span class='icon glyphicon glyphicon-scissors'></span> Regra de Corte (mín: 0 máx: 100)</label>
          
          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Este campo informará ao sistema qual a porcetagem de presença que será entregue o certificado. Os valores permitidos estão entre 0 (Zero) à 100 (Cem), sabendo que o evento entregará o certificado à quem possuí o percentual de presença MAIOR OU IGUAL ao valor informado no campo."><span class='glyphicon glyphicon-question-sign'></span></a>

          <div class="input-group">
            <input id="regra" class="form-control" type="number" name="regra" maxlength="3" min="0" max="100" step="0.1" tabindex="19" required <?php echo "value='{$evento['regra']}'"; ?> />
            <div class="input-group-addon">%</div>
          </div>
        </div>
        <div class="col-sm-6 form-group">
          <label for="submissao"><span class="icon glyphicon glyphicon-cloud-upload"></span> Submissão de Projetos</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Esta opção deverá ser marcada caso queira que o aceite submissões de projetos. Os formatos que serão aceitos dos projetos são pdf e documentos Word."><span class='glyphicon glyphicon-question-sign'></span></a>

          <div class="input-group">
            <?php
              if($evento['submissao_projeto'])
                echo "<input type='checkbox' name='submissao' id='submissao' tabindex='20' checked>";
              else
                echo "<input type='checkbox' name='submissao' id='submissao' tabindex='20'>";
            ?>

            <label for="submissao" class='label-check'>Este evento permite realizar submissões de projetos.</label>
          </div>
        </div>
      </section>
      <section class="row">
        <div class="col-xs-12 form-group">
          <label for="arquivo"><span class='icon glyphicon glyphicon-file'></span> Edital (Tamanho máx: 2MB - Formato: .pdf)</label>

          <a tabindex="90" class="duvida" role="button" data-toggle="popover" data-trigger="focus" data-content="Caso seu evento possua um edital você deverá selecionar o edital, clicando no botão escolher arquivo. Esse edital ficará disponível para todos vizualirarem."><span class='glyphicon glyphicon-question-sign'></span></a>
          
          <section class="row">
            <div class="col-xs-6">
              <?php
                if($evento['arquivo_edital']){            
                  echo "<section id='div-edital' class='row'>";
                    echo "<div class='col-sm-8' style='margin-bottom: 1rem'>";
                      echo "<a href='../uploads/editais/{$evento['arquivo_edital']}' target='_blank' >{$evento['arquivo_edital']}</a>";
                    echo "</div>";
                    echo "<div class='col-sm-8'>";
                      echo "<input id='arquivo' type='file' name='arquivo' accept='.pdf' tabindex='21' />";
                    echo "</div>";
                    echo "<div class='col-sm-4'>";
                      echo "<button form='form-removerEdital' class='btn btn-danger' style='margin-bottom: 2rem'><span class='icon glyphicon glyphicon-trash'></span> Remover Edital</button>";

                      echo "<input id='removerEdital' form='form-removerEdital' name='removerEdital' type='hidden' value='1' />";
        
                      echo "<input id='arquivoEdital' form='form-removerEdital' name='arquivoEdital' type='hidden' value='{$evento['arquivo_edital']}' />";
                    echo "</div>";
                  echo "</section>";
                }
                else{
                  echo "<input id='arquivo' type='file' name='arquivo' accept='.pdf' tabindex='21' />";
                }
              ?>
            </div>
          </section>
        </div>
      </section>
    </form>
    <section class="row top-admin" style='margin-bottom: 0; padding-bottom: 15px;'>
      <div class="col-xs-12 text-center">
        <button form="formEvento" class="btn btn-success" style='width: 50%'><span class='glyphicon glyphicon-floppy-disk' style='padding-right: 2px' tabindex='22'></span> Salvar</button> 
      </div>
    </section>
    <?php
    if($evento['arquivo_edital'])
      echo "<form id='form-removerEdital' method='post' action='{$dao}atualizar/evento.php?e={$base64_evento}'></form>";
    ?>
  </section>
  </section>
</main>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/public/frameworks/bootstrap/js/bootstrap.min.js"></script>

  <script type="text/javascript">

    showRule();

    window.addEventListener("load", function(){
      var edital = document.getElementById("edital");
      var arq = document.getElementById("arquivo");

      if(!document.getElementById("div-edital")){
        if(edital.checked){
          arq.required = true;
        }
        else{
          arq.required = false;
        }
      }
      
      $(function () {
        $('[data-toggle="popover"]').popover()
      });
    });
    
    function editalObrigatorio(){
      var edital = document.getElementById("edital");
      var arq = document.getElementById("arquivo");
      if(edital.checked){
        arq.required = true;
      }
      else{
        arq.required = false;
      }
    }

    function confirmar(id, ide) {
      var apagar = confirm("Confirma a exclusão?");
      if (apagar){
        location.href = 'apagar_atividade.php?id='+ id +'&ide='+ ide;
      }
    }

    function showRule(){
      if(document.getElementById("certificado").checked){
        document.getElementById("regra").setAttribute('type','number');

        document.getElementById("input-regra").style.display = "block";
      }
      else{
        document.getElementById("regra").setAttribute('type','hidden');

        document.getElementById("input-regra").style.display = "none";

      }
    }
  </script>
</body>
</html>