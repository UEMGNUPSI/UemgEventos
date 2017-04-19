<?php 


session_start();

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

if(!isset($_SESSION['usuario'])){
	$login = 1;
}else{
	$login = 0;
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>UEMG Eventos</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="estilo.css">

  <!-- Fonte da Barra de Navegação -->
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:700" rel="stylesheet"> 

  <!-- Fonte da Barra de Pesquisa -->
  <link href="https://fonts.googleapis.com/css?family=Signika+Negative:300" rel="stylesheet">  

</head>
<body>
<?php 
  if($erro == 2){
  ?>
  <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Erro ao Logar! </strong> Usuario e(ou) Senha invalido(s)!
    </div>
  <?php  
  }

 ?>
<form class="modal fade" id="janela" method="post" action="validar_acesso.php">
      <div class="modal-dialog" id='teste'>
      <!-- https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_tabulators_close -->
        <div class="modal-content">
          
          <div id="Logar" class="tab">
             <!-- cabecalho -->
            <div class="modal-header">
              <button class="close" data-dismiss="modal"><span>&times;</span></button>
              <h4 class="modal-title"><span id="icon-login" class="glyphicon glyphicon-user"></span> Efetuar Login</h4>


            </div>
            <!-- corpo -->
            <div class="modal-body div-login">
              <div class="form-group">
                <label for="email"><span id="icon-email-pass" class="glyphicon glyphicon-user"></span> E-mail</label>
                <input id='email' type="text" class="form-login" id="campo_usuario" name="usuario"/>
                
              </div>

              <div class="form-group">
                <label for="senha"><span id="icon-email-pass" class="glyphicon glyphicon-lock"></span> Senha</label>
                <input id='senha' type="password" class="form-login red" id="campo_senha" name="senha" maxlength="20"/>
                
              </div>

              <div>
                <a href="#" >Esqueceu sua senha?</a>
              </div>
            </div>
          </div>

          <!-- rodape -->
          <div class="modal-footer">
            <a href="cadastro.php" id="btn-cadastrar" class="btn-custom btn-logar" style="float: left;" >Cadastrar</a>
            <button class="btn-custom btn-logar" type="submit">Logar</button>
            <button class="btn-custom btn-cancelar" data-dismiss="modal">Cancelar</button>
          </div>

        </div>
      </div>
    </form>



<nav class="navbar navbar-inverse navbar-custom  navbar-fixed-top nav-color">
  <div class="container">

  <!-- header -->

        <div class="navbar-header">

        <!-- botao toggle-->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
          <span class="sr-only">alternar navegação</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="index.php" class="navbar-brand">
            <span class="img-logo">UEMG Eventos</span>
        </a>

        </div>
    
    <div class="collapse navbar-collapse" id="barra-navegacao">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">home</a></li>
        <li><a href="atividades.php">atividades</a></li>
        <li><a href="eventos.php">eventos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li>
        <form class="form-inline">
          <div id="barra-pesquisa" class="input-group input-group-sm ">
            <span class="input-group-addon" id="sizing-addon3"><button class="btn btn-pesquisa" type="submit"><span id="icon-pesquisa" class="glyphicon glyphicon-search"></span></button></span></span>
            <input type="text" class="form-control" placeholder="Pesquise aqui..." aria-describedby="basic-addon1">
            
          </div>
        </form>
      </li>
      <?php if($login == 0){ echo "<li class='dropdown'>
      <a  href='#' class='dropdown-toggle' data-toggle='dropdown'>minha conta<span class='glyphicon glyphicon-menu-down minha-conta' aria-hidden='true'></span></a>
      <ul class='dropdown-menu' aria-labelledby='dropdownMenuDivider' >
        <li> <a href='#'>editar</a> </li>
        <li> <a href='#'>minhas atividades</a> </li>

        <li role='separator' class='divider'></li>

        <li> <a href='sair.php'>sair</a> </li>

      </ul>

      </li>";}else{ echo "<li><a href='#' data-toggle='modal' data-target='#janela'>entrar</a></li>"; } ?>

      </ul>
    </div>
  </div>


</nav>
<!-- Carrossel -->
<div class="container">

  <ul class="slides">
    <div id="tooltip">Destaques</div>
    <input type="radio" name="radio-btn" id="img-1" checked />
    <li class="slide-container">
    <div class="slide">
      <img src="http://farm9.staticflickr.com/8072/8346734966_f9cd7d0941_z.jpg" />
        </div>
    <div class="navi">
      <label for="img-6" class="prev">&#x2039;</label>
      <label for="img-2" class="next">&#x203a;</label>
    </div>
    </li>

    <input type="radio" name="radio-btn" id="img-2" />
    <li class="slide-container">

        <div class="slide">

          <img src="imagens/img02.png" />
        </div>
    <div class="navi">
      <label for="img-1" class="prev">&#x2039;</label>
      <label for="img-3" class="next">&#x203a;</label>
    </div>
    </li>

    <input type="radio" name="radio-btn" id="img-3" />
    <li class="slide-container">
        <div class="slide">
          <img src="http://farm9.staticflickr.com/8068/8250438572_d1a5917072_z.jpg" />
        </div>
    <div class="navi">
      <label for="img-2" class="prev">&#x2039;</label>
      <label for="img-4" class="next">&#x203a;</label>
    </div>
    </li>

    <input type="radio" name="radio-btn" id="img-4" />
    <li class="slide-container">
        <div class="slide">
          <img src="http://farm9.staticflickr.com/8061/8237246833_54d8fa37f0_z.jpg" />
        </div>
    <div class="navi">
      <label for="img-3" class="prev">&#x2039;</label>
      <label for="img-5" class="next">&#x203a;</label>
    </div>
    </li>

    <input type="radio" name="radio-btn" id="img-5" />
    <li class="slide-container">
        <div class="slide">
          <img src="http://farm9.staticflickr.com/8055/8098750623_66292a35c0_z.jpg" />
        </div>
    <div class="navi">
      <label for="img-4" class="prev">&#x2039;</label>
      <label for="img-6" class="next">&#x203a;</label>
    </div>
    </li>

    <input type="radio" name="radio-btn" id="img-6" />
    <li class="slide-container">
        <div class="slide">
          <img src="http://farm9.staticflickr.com/8195/8098750703_797e102da2_z.jpg" />
        </div>
    <div class="navi">
      <label for="img-5" class="prev">&#x2039;</label>
      <label for="img-1" class="next">&#x203a;</label>
    </div>
    </li>

    <li class="nav-dots">
      <label for="img-1" class="nav-dot" id="img-dot-1"></label>
      <label for="img-2" class="nav-dot" id="img-dot-2"></label>
      <label for="img-3" class="nav-dot" id="img-dot-3"></label>
      <label for="img-4" class="nav-dot" id="img-dot-4"></label>
      <label for="img-5" class="nav-dot" id="img-dot-5"></label>
      <label for="img-6" class="nav-dot" id="img-dot-6"></label>
    </li>
</ul>
</div>


<!-- Carrossel 
<div class="container">
  <section class="carousel slide" data-ride="carousel">
  
    <ol class="carousel-indicators">

      <li data-target="#carrossel" data-slide-to="0" class="active"></li>
      <li data-target="#carrossel" data-slide-to="1" class="active"></li>
    </ol>

    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img class="img-carousel img-responsive" src="imagens/Tamanho-Banner.png" alt="banner01" align="center">
      </div>


      <div class="item">
        <img class="img-carousel img-responsive" src="imagens/img02.png" alt="banner02" align="center">
      </div>

    <a class="left carousel-control" href="#carrossel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carrossel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

  </section>

</div> -->

<div class="container">
  <!-- Atividade -->
  <div class="col-xs-5 div-atividades">
    <div class="col-lg-9"><h3 class="titulo">Atividade</h3></div>
    <div class="col-lg-3" style="padding-left: 0; padding-right: 0"><button class="btn-custom btn-inscreva" type="submit"><span id="icon-plus" class="glyphicon glyphicon-plus"></span> Inscreva-se</button></div>
    <div class="row col-lg-12 corpo-atividade">
      <div class="col-lg-4" style="padding-left: 0"><img class="img-atividade" src="imagens/Exemplo.png"></div>
      <div class="col-lg-8 " style="padding-left: 25px; padding-right: 0">
        <h4>Palestra sobre programação orientado a gambiarra</h4>
        <div class="col-lg-6 div-info">
          <p>Data: 17/04/2017</p>
          <p>Palestrante: Juninho Hater Java</p>
        </div>
        <div class="col-lg-6 div-info">
          <p>Horário: 19:00</p>
          <p>Local: Afiteatro UEMG Unidade Frutal</p>
        </div>
      </div>
    </div>
    <div class=" row col-lg-12 div-descricao">
      <h4>Descrição</h4>
      <p>Nesta palestra você verá de tudo sobre e mais um pouco sobre a mais nova sensação, programação orientado a gambiarra.</p>
    </div>
  </div>
  
  <div class="col-xs-1" style="width: 2%; height: 0; padding-left: 0; padding-right: 0;"></div>
  <!-- Evento -->
  <dir class=" col-xs-5 div-eventos">
    <div class="col-lg-9"><h3 class="titulo">Evento</h3></div>
    <div class="col-lg-3" style="padding-left: 0; padding-right: 0"><button class="btn-custom btn-inscreva" type="submit"><span id="icon-plus" class="glyphicon glyphicon-plus"></span> Ver atividades</button></div>
    <div class="row col-lg-12 corpo-atividade">
      <div class="col-lg-4" style="padding-left: 0"><img class="img-atividade" src="imagens/Exemplo.png"></div>
      <div class="col-lg-8 ">
        <h4>Semana da viagem no tempo</h4>
        <div class="col-lg-6 div-info">
          <p>Data de início: 17/04/2017</p>
          <p>Data de termino: 17/04/2016</p>
        </div>
        <div class="col-lg-6 div-info">
          <p>Horário: 19:00</p>
          <p>Local: Afiteatro UEMG Unidade Frutal</p>
        </div>
      </div>
    </div>
    <div class=" row col-lg-12 div-descricao">
      <h4>Descrição</h4>
      <p>Prepare sua mochila para essa aventura do barulho, e lembre-se não toque em nada!</p>
    </div>
  </dir>

  <div class="col-xs-5 div-atividades">
    <div class="col-lg-9"><h3 class="titulo">Atividade</h3></div>
    <div class="col-lg-3" style="padding-left: 0; padding-right: 0"><button class="btn-custom btn-inscreva" type="submit"><span id="icon-plus" class="glyphicon glyphicon-plus"></span> Inscreva-se</button></div>
    <div class="row col-lg-12 corpo-atividade">
      <div class="col-lg-4" style="padding-left: 0"><img class="img-atividade" src="imagens/Exemplo.png"></div>
      <div class="col-lg-8 " style="padding-left: 25px; padding-right: 0">
        <h4>Palestra sobre programação orientado a gambiarra</h4>
        <div class="col-lg-6 div-info">
          <p>Data: 17/04/2017</p>
          <p>Palestrante: Juninho Hater Java</p>
        </div>
        <div class="col-lg-6 div-info">
          <p>Horário: 19:00</p>
          <p>Local: Afiteatro UEMG Unidade Frutal</p>
        </div>
      </div>
    </div>
    <div class=" row col-lg-12 div-descricao">
      <h4>Descrição</h4>
      <p>Nesta palestra você verá de tudo sobre e mais um pouco sobre a mais nova sensação, programação orientado a gambiarra.</p>
    </div>
  </div>
  
  <dir class=" col-xs-5 div-eventos">
    <div class="col-lg-9"><h3 class="titulo">Evento</h3></div>
    <div class="col-lg-3" style="padding-left: 0; padding-right: 0"><button class="btn-custom btn-inscreva" type="submit"><span id="icon-plus" class="glyphicon glyphicon-plus"></span> Ver atividades</button></div>
    <div class="row col-lg-12 corpo-atividade">
      <div class="col-lg-4" style="padding-left: 0"><img class="img-atividade" src="imagens/Exemplo.png"></div>
      <div class="col-lg-8 ">
        <h4>Semana da viagem no tempo</h4>
        <div class="col-lg-6 div-info">
          <p>Data de início: 17/04/2017</p>
          <p>Data de termino: 17/04/2016</p>
        </div>
        <div class="col-lg-6 div-info">
          <p>Horário: 19:00</p>
          <p>Local: Afiteatro UEMG Unidade Frutal</p>
        </div>
      </div>
    </div>
    <div class=" row col-lg-12 div-descricao">
      <h4>Descrição</h4>
      <p>Prepare sua mochila para essa aventura do barulho, e lembre-se não toque em nada!</p>
    </div>
  </dir>
</div>
  
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

<footer>
  <div class="col-lg-12 rodape">
  <div class="col-xs-8">
    <div class="col-xs-6">
      <h3>NUPSI Contato</h3>
      <p>Av. Professor Mário Palmerio, 1001 - Bairro Universitário - Frutal/MG
         CEP: 38200-000 </p>
    </div>
    <div class="col-xs-6">
      <h3>UEMG Contato</h3>

      <p>Av. Professor Mário Palmerio, 1001 - Bairro Universitário - Frutal/MG
         CEP: 38200-000 - Telefone (34) 3423-2700 - FAX (34) 3423-2727 </p>

      <p>Site: <a href="http://frutal.uemg.br" target="_blank">UEMG Unidade Frutal</a></p>
      <p>E-mail: diretoria.frutal@uemg.br</p>
    </div>
    
  </div>

  <div class="col-lg-4" style="padding-right: 0">
    <img id="img-nupsi" src="imagens/NUPSI.png">
    <a href="http://frutal.uemg.br" target="_blank"><img id="img-uemg" src="imagens/frutal.png"></a>
    
  </div>
    
    
  </div>
    
</footer>

</html>