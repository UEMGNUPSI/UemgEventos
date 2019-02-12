<?php

require_once("../utilitarios.php");

if(isset($_GET['e'])){
    $id             =   base64_decode(filter_input(INPUT_GET, 'e', 
                        FILTER_SANITIZE_SPECIAL_CHARS));

    $base64_evento  =   filter_input(INPUT_GET, 'e', 
                        FILTER_SANITIZE_SPECIAL_CHARS);

}

?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		require_once("../head.php");
		head("Pagamentos");
	?>	
</head>
<body>
	<main class="container-fluid">
		<section class='row'>
            <?php 
                require_once("../nav.php");
                navbar("eventos");

                $evento = mysqli_fetch_array(mysqli_query(banco(), "SELECT titulo FROM eventos WHERE id = {$id}"));

                navTopEvento("<span class='icon glyphicon glyphicon-flag'></span> {$evento['titulo']}", "pagamento", "../eventos/eventos.php?e={$base64_evento}");

                unset($evento);

                include_once("{$root}dialog.php");

                if(isset($_SESSION['success'])){
                    switch(base64_decode($_SESSION['success'])){
                        case '1':
                            dialog("success", "Evento salvo com sucesso!");
                        break;
                        case '3':
                            dialog("success", "Evento excluido com sucesso!");
                        break;
                    }
                }

                if(isset($_SESSION['erro'])){
                    switch(base64_decode($_SESSION['erro'])){
                        case '3':
                            dialog("erro", "Não foi possível excluir este evento! Pode ser que ainda há atividades cadastradas ou tente novamente mais tarde.");
                        break;
                        case '9':
                            dialog("alert", "Você não tem permissão para acessar essa página!");
                        break;
                    }
                }
            ?>
            <span id='notification'></span>
            <section class="corpo col-sm-11 col-md-10">
                <?php 
                    navTopEventoMobile("pagamentos");
                ?>
                <section class="row top-admin">
                    <section class="row">
                        <div class="col-sm-7" style='margin-bottom: 2rem'>
                            <label for="busca" style='display: block'><span class='icon glyphicon glyphicon-search'></span> Pesquisar participante</label>
                            <input id='busca' type="search" name="busca" placeholder="Buscar por participante..." class="form-control">
                        </div>
                        <div class="col-sm-5">

                            <label style="display: block;"><span class='icon glyphicon glyphicon-cog'></span> Atribuir à Todos como:</label>

                            <input id="rdoPago" type="radio" name="status" value="Ativo"> <label for="rdoPago"> Pago</label>
							
							<input id="rdoPendente" type="radio" name="status" value="Desativado" style="margin-left: 20px;"> <label for="rdoPendente" style="margin-right: 20px;"> Pedente</label>

                            <button id="btnTodos" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk" style="padding-right: 2px"></span> Atribuir</button>
                        </div>
                    </section>
                </section>
                <section class='row'>
                    <input type="hidden" id="evento" <?php echo "value='{$base64_evento}'"; ?> />
                    
                    <div id='tblPagamento' class='col-sm-12 table-responsive'></div>
                    
                    <?php require_once("../paginacao.php"); ?>
            </section>
        </section>
    </main>

<?php require_once("../scripts.php"); ?>

<script src='/public/js/tabela.js'></script>
<script>
    var url 	= "../tabela.php";
    var tabela 	= "Pagamento";
    var pagina 	= $("#pagina").val();
    var status 	= $("#evento").val();
    var texto   = $("#busca").val();
        
    $(window).load(function(){
        atualizaTabelaPagamento(url, tabela, status, texto, pagina);

        $("#busca").keyup(function(){
            texto = $("#busca").val();

            atualizaTabelaStatus(url, tabela, status, texto, pagina);
        });
    });

    

    
</script>
</body>
</html>
            