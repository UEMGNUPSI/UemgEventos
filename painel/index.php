<!DOCTYPE html>
<html>
<head>
    <?php
        require_once("utilitarios.php");
        
        require_once("head.php");

        head("Painel do Administrador");
        
    ?>
</head>
<body>
    <main class="container-fluid">
        <section class='row'>
        <?php
            require_once("nav.php");
            navbar("home");

            navTop("<span class='icon glyphicon glyphicon-dashboard'></span> Início");

            include_once("../dialog.php");

            switch(isset($_SESSION['erro']) && base64_decode($_SESSION['erro'])){
                case '9':
                    dialog("alert", "Você não tem permissão para acessar esta página!");
                break;
            }
        ?>
            <article class='corpo col-xs-10 col-sm-11 col-md-10'>
                <header class="row top-admin" style="padding-bottom: 15px;">
                    <h3 class="col-12 text-center">Bem Vindo ao Painel do Administrador!</h3>
                </header>
                <section class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p>Nesta seção você poderá adicionar novos eventos e suas respectivas atividades ao sistema.</p>
                        <p>Efetuar os gerenciamentos necessários ao seu evento.</p>

                        <section class="row">
                            <header class="col-xs-12">
                                <h4 class="text-red primeiros-passos"><span     class="glyphicon glyphicon-info-sign"></span> Primeiros Passos</h4>
                            </header>

                            <div>
                                <div class="col-md-5 passo bg-dark-yellow text-t8">
                                    <span class="num-passo">1</span>
                                    <p>Não se esqueça! Para um evento existir, primeiro deverá registrar um local no sistema. <a href="locais/locais.php">Clique aqui</a> que te levaremos até lá!</p>
                                </div>
                                <div class="col-md-5 col-md-offset-1 passo bg-dark-red" style="color: #ffffffa6;">
                                    <span class="num-passo">2</span>
                                    <p>Já possui um local cadastrado? <a href="locais/locais.php">Clique aqui</a> que te levaremos ao seu próximo passo, criar um evento!</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            </article>
        </section>
    </main>

    <?php require_once("scripts.php"); ?>
</body>
</html>