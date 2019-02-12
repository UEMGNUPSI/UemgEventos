<!-- Navbar -->
<?php
  if(!isset($navHome))
    $navHome = "";
  if(!isset($navEvento))
    $navEvento = "";
  if(!isset($navSuporte))
    $navSuporte = "";
  
  if(isset($_SESSION["PrimeiroAcesso"]))
    primeiroAcesso($_SESSION["user"]);
?>
<nav class="navbar navbar-inverse navbar-custom navbar-fixed-top nav-color">
  <div class="container">

  <!-- header -->

        <div class="navbar-header">

        <!-- botao toggle  <a href='#' data-toggle='modal' data-target='#janela'>entrar</a> -->
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
        <li <?php echo $navHome; ?> ><a href="/public/">início</a></li>
        <li <?php echo $navEvento; ?> ><a href="/public/eventos.php">eventos</a></li>
        <li <?php echo $navSuporte; ?> ><a href="/public/suporte.php">suporte</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li>
        <form id='filtro' action='index.php' class="form-inline" method="get">
          <div id="barra-pesquisa" class="input-group input-group-sm ">
            <span class="input-group-addon" id="sizing-addon3"><button class="btn btn-pesquisa" type="submit"><span id="icon-pesquisa" class="glyphicon glyphicon-search"></span></button></span></span>
            <input type="text" name="busca" class="form-control" placeholder="Pesquise atividades aqui..." aria-describedby="basic-addon1">
            
          </div>
        </form>
      </li>
      <?php 
        if(isset($_SESSION['admin']) && $_SESSION['admin']){
          echo "<li class='dropdown'>";
            echo "<a  href='#' class='dropdown-toggle' data-toggle='dropdown'>minha conta<span class='glyphicon glyphicon-menu-down minha-conta' aria-hidden='true'></span></a>";
            echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuDivider' >";
              echo "<li> <a href='painel/'><span class='glyphicon glyphicon-stats' style='top: 2px; padding-right: .6rem;'></span> painel administrativo</a> </li>";
              echo "<li role='separator' class='divider'></li>";
              echo "<li> <a href='dao/user/sair.php' style='color: #e84040;'><span class='glyphicon glyphicon-log-out' style='top: 2px; padding-right: .6rem;'></span> sair</a> </li>";
            echo "</ul>";
          echo "</li>";
        }
        else if(isset($_SESSION['admin']) &&  !$_SESSION['admin']){
          echo "<li class='dropdown'>";
            echo "<a  href='#' class='dropdown-toggle' data-toggle='dropdown'>minha conta<span class='glyphicon glyphicon-menu-down minha-conta' aria-hidden='true'></span></a>";
            echo "<ul class='dropdown-menu' aria-labelledby='dropdownMenuDivider' >";
              echo "<li> <a href='/public/perfil/'><span class='icon glyphicon glyphicon-user' style='font-size: 14px; padding-right: .6rem;'></span> meu perfil</a> </li>";
              echo "<li role='separator' class='divider'></li>";
              echo "<li> <a href='/public/dao/user/sair.php' style='color: #e84040;'><span class='glyphicon glyphicon-log-out' style='top: 2px; padding-right: .6rem;'></span> sair</a> </li>";
            echo "</ul>";
          echo "</li>";
        }
        else{ echo "<li><a href='#' data-toggle='modal' data-target='#janela' onclick=\"setTimeout(function(){ $('#email').focus(); }, 300)\">entrar</a></li>"; } ?>
      </ul>
    </div>
  </div>
</nav>

<?php
  if(isset($_GET['erro']) && $_GET['erro'] === "2"){
    echo "<script>";
      echo "window.onload = function(){";
        echo "$('#janela').modal('show');";
      echo "}";
    echo "</script>";
    dialog("erro", "Usuário ou senha inválidos!");
  }
    

  function primeiroAcesso($user){
    $objBd = new bd();
    $link = $objBd->conecta_mysql();
    if($resul_pri = mysqli_query($link, "SELECT nome FROM usuarios WHERE email = '{$user}'")){
      $pri = mysqli_fetch_array($resul_pri);

      echo "<section id='saudacoes' class='modal fade' tabindex='-1' role='dialog' style='padding: 0;'>";
        echo "<div class='modal-dialog saudacoes'>";
          echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
              echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
              echo "<h4 class='modal-title'><span class='icon glyphicon glyphicon-exclamation-sign'></span> Saudações <b>{$pri['nome']}</b>!</h4>";
            echo "</div>";
            echo "<div class='modal-body' style=''>";
              echo "<p>Sua conta foi recém criada. Agora você poderá desfrutar dos eventos que acontecem na UEMG Frutal. Saiba que com o UEMG Eventos você poderá acumular certificados dos eventos no qual participou, além de poder realizar submissões de projetos para eventos qualificado para tal função.</p>";
              echo "<p>Sinta-se a vontade para escolher quais atividades deseja participar. Para isso, basta clicar no botão de se inscrever no canto superior direito das atividades.</p>";
              echo "<p>Caso possua alguma dúvida, sugestão, elógio ou encontou algum erro, acesse a opção suporte na barra superior de navegação.</p>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</section>";

      echo "<script type='text/javascript'>";
        echo "console.log('entrou');";
        echo "window.onload = function(){";
          echo "$('#saudacoes').modal('show');";
        echo "};";
      echo "</script>";
    }

    unset($_SESSION['PrimeiroAcesso']);
    mysqli_close($link);
      
  }
?>