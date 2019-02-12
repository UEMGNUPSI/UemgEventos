<?php 


session_start();

require_once('dao/bd.php');

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(isset($_GET['erro_usuario'])){
	$erro_usuario = $_GET['erro_usuario'];
}else{
	$erro_usuario = 0;
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php 
    require_once("head.php");
    head("UEMG Eventos");
  ?>

  <link href="frameworks/dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-cadastro">

<?php 
  if($erro_usuario == 2){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Logar! </strong> Usuario e(ou) Senha invalido(s)!
    </div>
  <?php  
  }

  if($erro_usuario == 1){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>E-mail já cadastrado! Tente um e-mail diferente.</strong> 
    </div>
  <?php  
  }
 ?>

 <?php 
  if(isset($_GET['sucesso'])){
  ?>
  <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-lable="Fechar">&times;</button>
      <strong>Usuario registrado com sucesso!</strong> 
    </div>
  <?php  
  }

 ?>

<?php 
  if($erro == 2){
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Erro ao Logar! </strong> Usuario e(ou) Senha invalido(s)!
  </div>
  <?php  
  }

  if($erro == 3){
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>CPF inválido! </strong> Tente novamente!
  </div>
  <?php  
  }

  if($erro == 4){
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>RA inválido! </strong> Tente novamente!
  </div>
  <?php  
  }

  if($erro == 5){
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>As senhas não se coincidem! </strong> Tente novamente!
  </div>
  <?php
  }

  include('login.php');

  require_once("nav.php");
  require_once("dialog.php");

  if(isset($_GET['erro'])){
    switch(base64_decode($_GET['erro'])){
      default:
        $erro = base64_decode(filter_input(INPUT_GET, 'erro', FILTER_SANITIZE_SPECIAL_CHARS));
        dialog("alert", "{$erro} já cadastrado no sistema!");
      break;
    }
  }
  

 ?>

<section class="container div-cadastro">
  <section class="row titulo">
    <div class="col-xs-12 div-cadastro-titulo">
      
      <h3 class="titulo-cadastro"><span style="padding: 0 1rem">+</span>Novo Usuário</h3>
      <p style="text-align: justify">Com seu cadastro na plataforma UEMG Eventos, você terá diversas vantagens como: certificados gerados automaticamente, ficar por dentro dos eventos e ainda realizar submissões de projetos.</p>
      <p>Se inscreva. <b>É grátis</b>. ;)</p>
    </div>
  </section>
  
  <section class="row">
    <div class="col-md-12">
      <h4 style="margin-bottom: 2.2rem">Para se inscrever, vamos precisar saber um pouco mais sobre você.</h4>
    </div>
  </section>
  <section class="row">
    <div id='phase1' class="col-md-12">
      <div class="col-md-12 form-cadastro">
        <p class="info-cadastro"><span class="icon glyphicon glyphicon-info-sign"></span> Primeiramente de onde você é?</p>
        <div style="margin-top: 16px">
          <label style="padding-right: 25px;"><input id="UEMG" type="radio" name="tipo" value="aluno" > UEMG Frutal</label>
          <label><input id="Outra" type="radio" name="tipo" value="nao-aluno"> Outra Instituição</label>
        </div>
      </div>
      <div class="col-md-12 btn-group">
        <button id='next1' class="btn-custom avancar">Avançar</button>
      </div>
    </div>

    <form id="formCadastro" method="post" action="dao/user/usuario.php" >
      <div id="phase2" class="col-md-12">
        <!-- Segunda etapa  -->

        <div class="col-md-12">
          <p class="info-cadastro"><span class="icon glyphicon glyphicon-info-sign"></span> Agora precisamos saber algumas informações importantes.</p>
          <section class="row" style="margin-top: 16px">
            <div class="col-md-6">
              <div class="form-group">
                <label id="nomeLabel" for="nomeInput">
                  Qual seu nome completo?
                  <span id="capsNomeAtivado" class="erro" style="padding-left: 1rem;"> * CAPS LOCK ativado.</span>
                  <span id="nomeErro" class="erro"> * Campo Vazio</span>
                </label>
                <input id="nomeInput" class="form-custom" type="text" name="nome" maxlength="42"  placeholder="máx: 42 caracteres" style="text-transform: capitalize;" required />
              </div>
              <div class="form-group">
                <label id="cpfLabel" for="cpfInput">
                  Qual seu CPF?
                  <span id="cpfErro" class="erro"> * CPF Vazio ou Inválido</span>
                </label>
                <input id="cpfInput" class="form-custom" type="text" name="cpf"  required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label id="nascLabel" for="nascInput">
                  Quando foi que você nasceu?
                  <span id="nascErro" class="erro"> * Data de Nascimento Vazia ou Inválida</span>
                </label>
                <input id="nascInput" class="form-custom" name="nasc" required />
              </div>
            </div>
          </section>
          <div class="col-md-6 btn-group">
            <input id="back1" class="btn-custom voltar" value="Voltar" type="button" />
            <input id="next2" class="btn-custom avancar" value="Avançar" type="button" />
          </div>
        </div>

        <!-- Fim segunda etapa -->
      </div>

      <div id="phase3" class="col-md-12">
        <!-- Terceira etapa -->
          <div class="col-md-12">
            <p class="info-cadastro"><span class="icon glyphicon glyphicon-info-sign"></span> Agora que nos conhecemos melhor, gostariamos de saber das suas informações como docente ou discente da UEMG.</p>
            <section class="row" style="margin-top: 16px">
              <div class="col-md-6">
                <div class="form-group">
                  <label id="cursoLabel" for="cursoInput">
                    Qual curso você frequenta?
                    <span id="cursoErro" class="erro"> * Campo Vazio</span> 
                  </label>
                  <select id="cursoInput" class="form-custom" name="curso" >
                    <option disabled selected style="display: none;" value="">Selecione</option>
                  <?php 
                    $sql = "SELECT titulo, id FROM cursos ORDER BY titulo";

                    $resultado_id = mysqli_query($link, $sql);

                    if($resultado_id){
                    while($curso = mysqli_fetch_array($resultado_id)){

                      echo "<option value='".$curso['id']."'>".$curso['titulo']."</option>";

                    }
                  }

                  ?>
                  </select>
                </div>
                <div class="form-group">
                  <label id="raLabel" for="raInput">
                    Qual seu RA ou MASP?
                    <span id="raErro" class="erro"> * Campo Vazio ou Inválido</span>
                  </label>
                  <input id="raInput" class="form-custom" name="ra" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label id="anoLabel" for="anoInput">
                    Qual foi o ano em que ingressou na UEMG?
                    <span id="anoErro" class="erro"> * Campo Vazio ou Inválido</span>
                  </label>
                  <input  id="anoInput" class="form-custom" name="ano" type="text" />
                </div>
              </div>
            </section>
            <div class="col-md-6 btn-group">
              <input id="back2" class="btn-custom voltar" value="Voltar" type="button" />
              <input id="next3" class="btn-custom avancar" value="Avançar" type="button" />
            </div>
          </div>

          <!-- Fim terceira etapa -->
      </div>
      <div id="phase4" class="col-md-12">
        <!-- Quarta etapa -->
          <div class="col-md-12">
            <p class="info-cadastro"><span class="icon glyphicon glyphicon-info-sign"></span> Tem mais alguma informação que gostaria de nos fornecer? Saiba que estes campos <b>não são obrigatórios</b> serem preenchidos.</p>
            <section class="row" style="margin-top: 16px">
              <div class="col-md-6">
                <div class="form-group">
                  <label id="telLabel" for="telInput">
                    Qual seu celular ou telefone?
                    <span id="telErro" class="erro"> * Campo Inválido</span>
                  </label>
                  <input id="telInput" class="form-custom" type="text" name="tel" />
                </div>
                <div class="form-group">
                  <label id="cnpjLabel" for="cnpjInput">
                    Você possuí CNPJ?
                    <span id="cnpjErro" class="erro"> * Campo Inválido</span>
                  </label>
                  <input id="cnpjInput" class="form-custom" type="text" name="cnpj" />
                </div>
              </div>
              <div id="outraIns" class="col-md-6">
                <div class="form-group">
                  <label id="instituicaoLabel" for="instituicaoInput">
                    Veio de outra instituição, qual?
                  </label>
                  <input id="instituicaoInput" class="form-custom" type="text" name="instituicao" maxlength="42" placeholder="máx: 42 caracteres" />
                </div>
              </div>
            </section>
            <div class="col-md-6 btn-group">
              <input id="back3" class="btn-custom voltar" value="Voltar" type="button" />
              <input id="next4" class="btn-custom avancar" value="Avançar" type="button" />
            </div>
          </div>
        <!-- Fim quarta etapa -->
      </div>
      <div id="phase5" class="col-md-12">
        <!-- Quinta etapa -->
        <div class="col-md-12">
          <p class="info-cadastro"><span class="icon glyphicon glyphicon-info-sign"></span> Agora seu cadastro está quase no fim, só precisamos dessas últimas informações para que você possa acessar sua conta no UEMG Eventos.</p>
          <section class="row" style="margin-top: 16px">
            <div class="col-md-6">
              <div class="form-group">
                <label id="emailLabel" for="emailInput">
                  Qual o seu e-mail?
                  <span id="emailErro" class="erro"> * Campo Vazio ou Inválido</span>
                </label>
                <input id="emailInput" class="form-custom" type="email" name="email" maxlength="42" placeholder="ex: exemplo@exemplo.com máx: 42 caracteres" required>
              </div>  
            </div>
            <div class="col-md-12">
              <section class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label id="senhaLabel" for="senhaInput">
                      Qual a senha que deseja criar?
                      <span id="senhaErro" class="erro"> * Campo Vazio ou Inválido</span>
                      <span id="senhaCuidado" class="atencao"> Cuidado CAPS LOCK ativado</span>
                      <span id="senhaErroCon" class="erro"> * As senhas não se coincidem</span>
                    </label>
                    <input id="senhaInput" class="form-custom" type="password" name="senha" minlength="5" maxlength="20" placeholder="De 5 a 20 caracteres"  required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label id="senhaConLabel" for="senhaConInput">
                      Repita sua senha, para maior segurança:
                      <span id="senhaConErro" class="erro"> * Campo Vazio ou Inválido</span>
                      <span id="senhaConCuidado" class="erro"> Cuidado CAPS LOCK ativado</span>
                    </label>
                    <input id="senhaConInput" class="form-custom" type="password"  placeholder="De 5 a 20 caracteres"  required>
                  </div>
                </div>
              </section>
            </div>
          </section>
          <div class="col-md-6 btn-group">
            <input id="back4" class="btn-custom voltar" value="Voltar" type="button" />
            <button class="btn-custom finalizar">Finalizar</button>
          </div>
        </div>
        <!-- Fim quinta etapa -->
      </div>
    </form>
    
    
  </section>
</section>
<?php require_once("footer.php"); ?>
  <script type="text/javascript" src="js/cadastro.js"></script>

  <script src="frameworks/jquery mask/jquery.mask.min.js"></script>

  <script src="frameworks/dist/js/datepicker.min.js"></script>
  <script src="frameworks/dist/js/i18n/datepicker.pt.js"></script>
</body>
</html>