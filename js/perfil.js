function showItem(ant, prox){
    $("#"+ant).animate({
        left: "-10px",
        opacity: "0"
    },{
        duration: 300,
        complete: function(){
            $("#"+ant).css("display", "none");
            $("#"+prox).css("display","block");
            $("#"+prox).css("left","10px");
            $("#"+prox).animate({
                left: "0",
                opacity: "1"
            },{ 
                duration: 300,
                complete: function(){
                    $("#"+prox+"Titulo").css("background", "#f8f8f8");
                    $("#"+ant+"Titulo").css("background", "transparent");
                }
            });
        }
    });
}

$(document).ready(function(){
    $("#infoPerfil").click(function(){
        if(!$( "#infoPerfil" ).hasClass( "ativo" ) && $("#eventosPerfil").hasClass("ativo")){
            $("#infoPerfil").addClass("ativo");
            $("#eventosPerfil").removeClass("ativo");
            
            showItem("eventos", "info");
        }

        if(!$( "#infoPerfil" ).hasClass( "ativo" ) && $("#submissaoPerfil").hasClass("ativo")){
            $("#infoPerfil").addClass("ativo");
            $("#submissaoPerfil").removeClass("ativo");
            
            showItem("submissao", "info");
        }
    });

    $("#eventosPerfil").click(function(){
        if(!$( "#eventosPerfil" ).hasClass( "ativo" ) && $("#submissaoPerfil").hasClass("ativo")){
            $("#eventosPerfil").addClass("ativo");
            $("#submissaoPerfil").removeClass("ativo");

            showItem("submissao", "eventos");

            showTblEventos();
        }

        if(!$( "#eventosPerfil" ).hasClass( "ativo" ) && $("#infoPerfil").hasClass("ativo")){
            $("#eventosPerfil").addClass("ativo");
            $("#infoPerfil").removeClass("ativo");
            
            showItem("info", "eventos");

            showTblEventos();
        }
    });

    $("#submissaoPerfil").click(function(){
        if(!$( "#submissaoPerfil" ).hasClass( "ativo" ) && $("#infoPerfil").hasClass("ativo")){
            $("#submissaoPerfil").addClass("ativo");
            $("#infoPerfil").removeClass("ativo");

            showItem("info", "submissao");
        }

        if(!$( "#submissaoPerfil" ).hasClass( "ativo" ) && $("#eventosPerfil").hasClass("ativo")){
            $("#submissaoPerfil").addClass("ativo");
            $("#eventosPerfil").removeClass("ativo");

            showItem("eventos", "submissao");
        }
    });

    $("#sairPerfil").click(function(){
        window.location="../dao/user/sair.php";
    });

    // var q = $("#q").val();

    // $("#pagAtual").text("1");

    // $.ajax({
    //     url: "tabelaAtividades.php?q="+q,

    //     success: function(data){
    //         $("#tblAtividades").html(data);
    //     }
    // });

    // $("#ant").click(function(){
    //     if(parseInt($("#pagAtual").text()) > 1){
    //         var proximo = parseInt($("#pagAtual").text()) - 1;

    //         $.ajax({
    //             url: "tabelaAtividades.php?q="+q+"&pagina="+proximo,

    //             success: function(data){
    //                 $("#tblAtividades").html(data);
                    
    //                 $("#pagAtual").text(proximo);

    //                 if(parseInt($("#pagAtual").text()) === 1)
    //                     $("#ant").css("display", "none");

    //                 if(parseInt($("#pagAtual").text()) < parseInt($("#pagUlt").text()))
    //                     $("#prox").css("display", "block");
    //             }
    //         });
    //     }        
    // });

    // $(".dropButton").click(function(){
    //     var prox = $(this).text();
    //     $("#pagAtual").text(prox);
    //     $.ajax({
    //         url: "tabelaAtividades.php?q="+q+"&pagina="+prox,
            
    //         success: function(data){
    //             $("#tblAtividades").html(data);
                
    //             $("#pagAtual").val($(this).text());

    //             if(parseInt($("#pagAtual").text()) > 1)
    //                 $("#ant").css("display", "inline");
    //             else
    //                 $("#ant").css("display", "none");

    //             if(parseInt($("#pagAtual").text()) < parseInt($("#pagUlt").text()))
    //                 $("#prox").css("display", "block");
    //         }
    //     });
    // });

    // $("#prox").click(function(){
    //     var proximo = parseInt($("#pagAtual").text()) + 1;

    //     $.ajax({
    //         url: "tabelaAtividades.php?q="+q+"&pagina="+proximo,

    //         success: function(data){
    //             $("#tblAtividades").html(data);
                
    //             $("#pagAtual").text(proximo);

    //             if($("#ant").css("display") === "none")
    //                 $("#ant").css("display", "block");
                
    //             if(parseInt($("#pagAtual").text()) === parseInt($("#pagUlt").text()))
    //                 $("#prox").css("display", "none");
    //         }
    //     });
    // });

});

function showTblEventos(){

    // Tabela Eventos
    $.ajax({
        url: "tblEventos.php",

        success: function(data){
            $("#tblEventos").html(data);
        }
    });
}