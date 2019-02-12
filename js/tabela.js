var lastTable = "";
var lastStatus = "";
var lastSearch = "";

var atualizaTabelaStatus = function(url, tabela, status, busca, pagina){
    $.ajax({
        method: "POST",
        url: url,
        data: {tabela: tabela, status: status, busca: busca, pagina: pagina},

        success: function(data){
            $("#tbl"+tabela).html(data);
            
            if(tabela !== lastTable || status !== lastStatus || busca !== lastSearch){
                atualizaProx($("#numPaginas").val());

                lastTable = tabela;
                lastStatus = status;
                lastSearch = busca;
            }
            
        }
    });
}

var atualizaTabelaUsuario = function(url, tabela, status, atividade, busca, pagina){
    $.ajax({
        method: "POST",
        url: url,
        data: {tabela: tabela, status: status, atividade: atividade, busca: busca, pagina: pagina},

        success: function(data){
            $("#tbl"+tabela).html(data);

            if(tabela !== lastTable || busca !== lastSearch){
                atualizaProx($("#numPaginas").val());
                
                lastTable = tabela;
                lastSearch = busca;
            }
        }
    });
}

var atualizaTabelaProjetos = function(url, tabela, evento, opcao, busca, pagina){
    $.ajax({
        method: "POST",
        url: url,
        data: {tabela: tabela, evento: evento, status: opcao, busca: busca, pagina: pagina},

        success: function(data){
            $("#tbl"+tabela).html(data);

            if(tabela !== lastTable || busca !== lastSearch){
                atualizaProx($("#numPaginas").val());
                
                lastTable = tabela;
                lastSearch = busca;
            }
        }
    });
}

var atualizaTabela = function(url, tabela, busca, pagina){
    $.ajax({
        method: "POST",
        url: url,
        data: {tabela: tabela, status: status, busca: busca, pagina: pagina},

        success: function(data){
            $("#tbl"+tabela).html(data);
            
            if(tabela !== lastTable || busca !== lastSearch){
                atualizaProx($("#numPaginas").val());

                lastTable  = tabela;
                lastSearch = busca;
            }
        }
    });
}

var atualizaTabelaPagamento = function(url, tabela, status, busca, pagina){
    $.ajax({
        method: "POST",
        url: url,
        data: {tabela: tabela, status: status, busca: busca, pagina: pagina},

        success: function(data){
            $("#tbl"+tabela).html(data);
            
            if(tabela !== lastTable || status !== lastStatus || busca !== lastSearch){
                atualizaProx($("#numPaginas").val());

                lastTable = tabela;
                lastStatus = status;
                lastSearch = busca;
            }
            
        }
    });
}

var atualizaPagina = function (pag){
    var texto = $("#busca").val();
    var total = parseInt($("#numPaginas").val());

    switch(tabela){
        case "Usuarios":
            atualizaTabelaUsuario(url, tabela, evento, atividade, texto, pag);
        break;
        case "Eventos":
            atualizaTabelaStatus(url, tabela, status, texto, pag);
        break;
        case "Atividades":
            atualizaTabelaStatus(url, tabela, status, texto, pag);
        break;
        case "Projetos":
            atualizaTabelaProjetos(url, tabela, evento, status, texto, pag);
        break;
        default:
            atualizaTabela(url, tabela, texto, pag);
        break;

    }

    $("#pagina").val(pag);

    $("#pagAtual").text(pag);

    if(pag !== 1 && pag < total){
        $("#ant").html(
            "<a class='pagina pull-right' onclick='atualizaPagina("+(pag-1)+")'>"+
                "<span class='icon glyphicon glyphicon-menu-left'></span> Página anterior"+
            "</a>"
        );

        $("#prox").addClass("col-xs-6 col-sm-6 col-md-5");

        $("#prox").html(
            "<a class='pagina pull-left' onclick='atualizaPagina("+(pag+1)+")'>"+
                "Proxima página <span class='icon glyphicon glyphicon-menu-right'></span>"+
            "</a>"
        );
    }
    else if(pag >= total){
        if(total === 1){
            $("#ant").text("");
            $("#dropPag").text("");

            $("#prox").html(
                "<a class='pagina pull-left' onclick='atualizaPagina("+(pag)+")'>"+
                    "Proxima página <span class='icon glyphicon glyphicon-menu-right'></span>"+
                "</a>"
            );
        }
        else{
            $("#prox").text("");

            $("#ant").html(
                "<a class='pagina pull-right' onclick='atualizaPagina("+(pag-1)+")'>"+
                    "<span class='icon glyphicon glyphicon-menu-left'></span> Página anterior"+
                "</a>"
            );
        }
    }
    else{
        $("#ant").text("");
        $("#dropPag").text("");

        $("#prox").html(
            "<a class='pagina pull-left' onclick='atualizaPagina("+(pag+1)+")'>"+
                "Proxima página <span class='icon glyphicon glyphicon-menu-right'></span>"+
            "</a>"
        );
    }

    if(total > 4 && pag >= 4 && pag < total - 1){
        $("#dropPag").html(
            itensPagina(1, 1)+
            itensPagina(0, 0)+
            itensPagina(1, pag-2)+
            itensPagina(1, pag-1)+
            itensPagina(1, pag)+
            itensPagina(1, pag+1)+
            itensPagina(1, pag+2)+
            itensPagina(0, 0)+
            itensPagina(1, total)
        );
    }
    else if(total > 4 && pag === total - 1){
        $("#dropPag").html(
            itensPagina(1, 1)+
            itensPagina(0, 0)+
            itensPagina(1, pag-2)+
            itensPagina(1, pag-1)+
            itensPagina(1, pag)+
            itensPagina(1, total)
        );
    }
    else if(total > 4 && pag === total){
        $("#dropPag").html(
            itensPagina(1, 1)+
            itensPagina(0, 0)+
            itensPagina(1, total-3)+
            itensPagina(1, total-2)+
            itensPagina(1, total-1)+
            itensPagina(1, total)
        );
    }
    else if(total >= 4){
        $("#dropPag").html(
            itensPagina(1, 1)+        
            itensPagina(1, 2)+
            itensPagina(1, 3)+
            itensPagina(1, 4)+
            itensPagina(0, 0)+
            itensPagina(1, total)
        );
    }
    else{
        $("#dropPag").text("");
        for(var i = 1; i <= total; i++){
            $("#dropPag").html($("#dropPag").html()+itensPagina(1, i));
        }
    }

    if(total === 0){
        $("#ant").text("");
        $("#divDropPag").text("");
        $("#prox").text("");
    }
}

var atualizaProx = function(total){
    $("#ant").text("");
    $("#divDropPag").text("");
    $("#prox").text("");

    if(parseInt(total) > 1){
        $("#prox").html(
            "<a class='pagina pull-left' onclick='atualizaPagina(2)'>"+
                "Proxima página <span class='icon glyphicon glyphicon-menu-right'></span>"+
            "</a>"
        );

        $("#divDropPag").html(
            "<div class='dropdown text-center'>"+
                "<button class='btn btn-default dropdown-toggle btn-drop' type='button' id='dropPagina' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'>"+
                    "<span id='pagAtual' style='padding-right: 5px'>1</span>"+
                    " <span class='caret'></span>"+
                "</button>"+
                "<ul id='dropPag' class='dropdown-menu' aria-labelledby='dropPagina'></ul>"+
            "</div>"
        );

        atualizaDrop(parseInt(total));
    }
}

var atualizaDrop = function(total){
    
    for(var i = 1; i <= total; i++){
        
        if(total > 4 && i <= 4){
            $("#dropPag").html($("#dropPag").html()+"<li><a class='pagItens' onclick='atualizaPagina("+i+")'>"+i+"</a></li>");
        }
        else if(total <= 4){
            $("#dropPag").html($("#dropPag").html()+"<li><a class='pagItens' onclick='atualizaPagina("+i+")'>"+i+"</a></li>");
        }

        if(total > 4 && i === 4){
            $("#dropPag").html($("#dropPag").html()+"<li role='separator' class='divider'></li>");

            $("#dropPag").html($("#dropPag").html()+"<li><a class='pagItens' onclick='atualizaPagina("+total+")'>"+total+"</a></li>");
        }
    }
}
    
function itensPagina(funcao, pag){
    if(funcao){
    var html = "<li>";

        html += "<a class='pagItens' onclick='atualizaPagina("+pag+")'>"+pag+"</a>";
    }
    else{
        var html = "<li role='separator' class='divider'>";
    }
    html += "</li>";

    return html;
}