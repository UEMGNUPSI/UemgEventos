<?php

function navbar($index){
    strtolower($index);
    
    $nupsi          = "";
    $home           = "";
    $evento         = "";
    $local          = "";
    $curso          = "";
    $categoria      = "";
    $administrador  = "";
    $relatorio      = "";
    
    switch($index){
        case "nupsi":
            $nupsi          = "class='ativo'";
        break;
        case "home":
            $home           = "class='ativo'";
        break;
        case "eventos":
            $evento         = "class='ativo'";
        break;
        case "locais":
            $local          = "class='ativo'";
        break;
        case "cursos":
            $curso          = "class='ativo'";
        break;
        case "categorias":
            $categoria      = "class='ativo'";
        break;
        case "administradores":
            $administrador  = "class='ativo'";
        break;
        case "relatorios":
            $relatorio      = "class'ativo'";
        break;
    }
?>
    <aside class='col-xs-2 col-sm-1 col-md-2 nav-admin'>
        <header class='header-admin'>
            <h4 class='middleY hidden-xs hidden-sm' style="margin: 0;"><?php echo getNome($_SESSION['user']); ?></h4>
            <span id='nav-show' class='mobile-menu middleY hidden-md hidden-lg glyphicon glyphicon-menu-hamburger'></span>
        </header>
        <nav class='nav-overflow'>
            <ul class="nav" >
                <?php if(intval(getId($_SESSION['user'])) ===  1){
                    echo "<li {$nupsi}>";
                        echo "<a class='nav-item' href='{$GLOBALS['end']}nupsi/' tabindex='1'><span class='icon-nav glyphicon glyphicon-comment'></span><span class='lbl-nav hidden-xs hidden-sm'> NUPSI</span></a>";
                    echo "</li>";
                } ?>
                <li <?php echo $home; ?>>
                    <a class='nav-item' <?php echo "href='{$GLOBALS['end']}'"; ?> tabindex='2'><span class='icon-nav glyphicon glyphicon-dashboard'></span><span class='lbl-nav hidden-xs hidden-sm'> Início</span></a>
                </li>
                <li <?php echo $evento; ?>>
                    <a class='nav-item' <?php echo "href='{$GLOBALS['end']}eventos/'"; ?> tabindex='3'><span class='icon-nav glyphicon glyphicon-flag'></span><span class='lbl-nav hidden-xs hidden-sm'> Eventos</span></a>
                </li>
                <li <?php echo $local; ?>>
                    <a class='nav-item'<?php echo "href='{$GLOBALS['end']}locais/'"; ?> tabindex='4'><span class='icon-nav glyphicon glyphicon-home'></span><span class='lbl-nav hidden-xs hidden-sm'> Locais</span></a>
                </li>
                <li <?php echo $curso; ?>>
                    <a class='nav-item' <?php echo "href='{$GLOBALS['end']}cursos/'"; ?> tabindex='5'><span class='icon-nav glyphicon glyphicon-blackboard'></span><span class='lbl-nav hidden-xs hidden-sm'> Cursos</span></a>
                </li>
                <li <?php echo $categoria; ?>>
                    <a class='nav-item' <?php echo "href='{$GLOBALS['end']}categorias/'"; ?> tabindex='6'><span class='icon-nav glyphicon glyphicon-certificate'></span><span class='lbl-nav hidden-xs hidden-sm'> Categorias</span></a>
                </li>
                <?php if(intval(getId($_SESSION['user'])) ===  1){
                    echo "<li {$administrador}>";
                        echo "<a class='nav-item' href='{$GLOBALS['end']}administradores/' tabindex='7'><span class='icon-nav glyphicon glyphicon-user'></span><span class='lbl-nav hidden-xs hidden-sm'> Administradores</span></a>";
                    echo "</li>";
                } ?>
                <li <?php echo $relatorio; ?>>
                    <a class='nav-item' <?php echo "href='{$GLOBALS['end']}relatorios/'"; ?> tabindex='8'><span class='icon-nav glyphicon glyphicon-file'></span><span class='lbl-nav hidden-xs hidden-sm'> Relatórios</span></a>
                </li>
                <li>
                    <a class='nav-item' href="/public/dao/user/sair.php" tabindex='9'><span class='icon-nav glyphicon glyphicon-log-out'></span><span class='lbl-nav hidden-xs hidden-sm'> Sair</span></a>
                </li>
            </ul>
        </nav>
    </aside>
<?php
}

function navTop($title){
    echo "<header class='top-header'>";
        echo "<section id='nav-row' class='row'>";
            echo "<div class='col-xs-7 col-sm-10' style='padding: 0;'>";
                echo "<p class='titulo'>{$title}</p>";
            echo "</div>";
        echo "</section>";
    echo "</header>";
}

function navTopEvento($title, $item, $voltar){
    $item           = strtolower($item);

    $atividade      = "";
    $pagamento      = "";
    $projeto        = "";
    $certificado    = "";

    switch($item){
        case "atividade":
            $atividade = "ativo";
        break;
        case "pagamento":
            $pagamento = "ativo";
        break;
        case "projeto":
            $projeto = "ativo";
        break;
        case "certificado":
            $certificado = "ativo";
        break;
    }
    
    echo "<header class='top-header' style='padding: 0 15px !important;'>";
        echo "<section id='nav-row' class='row'>";
            echo "<div class='col-xs-7 col-sm-10' style='padding: 0;'>";
                echo "<p class='titulo'>{$title}</p>";
                
                if(isset($GLOBALS['base64_evento'])){
                    echo "<a class='btn links hidden-xs hidden-sm hidden-md  {$atividade}' href='atividades.php?e={$GLOBALS['base64_evento']}'>Atividades</a>";
                    echo "<a class='btn links hidden-xs  hidden-sm hidden-md {$pagamento}' href='pagamentos.php?e={$GLOBALS['base64_evento']}'>Pagamentos</a>";
                    echo "<a class='btn links hidden-xs hidden-sm  hidden-md {$projeto}' href='projetos.php?e={$GLOBALS['base64_evento']}'>Projetos</a>";
                    // echo "<a class='btn links hidden-xs hidden-sm  hidden-md {$certificado}' href='certificado.php?e={$GLOBALS['base64_evento']}'>Certificados</a>";
                }                
            echo "</div>";
            echo "<div class='col-xs-5 col-sm-2'>";
                echo "<section class='row'>";
                    echo "<a id='btnVoltar' class='btn voltar' href='{$voltar}'><span class='icon glyphicon glyphicon-arrow-left'></span> Voltar</a>";
                echo "</section>";
            echo "</div>";
        echo "</section>";
    echo "</header>";
}

function navTopEventoMobile($item){
    $item           = strtolower($item);

    $atividade      = "";
    $pagamento      = "";
    $projeto        = "";
    $certificado    = "";

    switch($item){
        case "atividade":
            $atividade = "ativo";
        break;
        case "pagamento":
            $pagamento = "ativo";
        break;
        case "projeto":
            $projeto = "ativo";
        break;
        case "certificado":
            $certificado = "ativo";
        break;
    }

    ?>
    <section class='row opcao-mobile visible-xs-block visible-sm-block visible-md-block'>
      <a <?php echo "class='btn links {$atividade}' href='atividades.php?e={$GLOBALS['base64_evento']}'"; ?>>Atividades</a>
      <a <?php echo "class='btn links {$pagamento}' href='pagamento.php?e={$GLOBALS['base64_evento']}'"; ?>>Pagamentos</a>
      <a <?php echo "class='btn links {$projeto}' href='projetos.php?e={$GLOBALS['base64_evento']}'"; ?>>Projetos</a>
    </section>
    <?php
}

?>