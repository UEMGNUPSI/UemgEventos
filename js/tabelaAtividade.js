$(document).ready(function(){
    var q = $("#q").val();

    $("#pagAtual").text("1");

    $.ajax({
        url: "tabelaAtividades.php?q="+q,

        success: function(data){
            $("#tblAtividades").html(data);
        }
    });

    $("#ant").click(function(){
        if(parseInt($("#pagAtual").text()) > 1){
            var proximo = parseInt($("#pagAtual").text()) - 1;

            $.ajax({
                url: "tabelaAtividades.php?q="+q+"&pagina="+proximo,

                success: function(data){
                    $("#tblAtividades").html(data);
                    
                    $("#pagAtual").text(proximo);

                    if(parseInt($("#pagAtual").text()) === 1)
                        $("#ant").css("display", "none");

                    if(parseInt($("#pagAtual").text()) < parseInt($("#pagUlt").text()))
                        $("#prox").css("display", "block");
                }
            });
        }        
    });

    $(".dropButton").click(function(){
        var prox = $(this).text();
        $("#pagAtual").text(prox);
        $.ajax({
            url: "tabelaAtividades.php?q="+q+"&pagina="+prox,
            
            success: function(data){
                $("#tblAtividades").html(data);
                
                $("#pagAtual").val($(this).text());

                if(parseInt($("#pagAtual").text()) > 1)
                    $("#ant").css("display", "inline");
                else
                    $("#ant").css("display", "none");

                if(parseInt($("#pagAtual").text()) < parseInt($("#pagUlt").text()))
                    $("#prox").css("display", "block");
            }
        });
    });

    $("#prox").click(function(){
        var proximo = parseInt($("#pagAtual").text()) + 1;

        $.ajax({
            url: "tabelaAtividades.php?q="+q+"&pagina="+proximo,

            success: function(data){
                $("#tblAtividades").html(data);
                
                $("#pagAtual").text(proximo);

                if($("#ant").css("display") === "none")
                    $("#ant").css("display", "block");
                
                if(parseInt($("#pagAtual").text()) === parseInt($("#pagUlt").text()))
                    $("#prox").css("display", "none");
            }
        });
    });
});