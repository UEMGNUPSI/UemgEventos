$(document).ready(function(){
    // Mascaras 
    $('#cpfInput').mask('000.000.000-00');
    $('#raInput').mask('00-00000');
    $('#anoInput').mask('0000');
    $('#telInput').mask('(00) 0 0000-0000');
    $('#cnpjInput').mask('00.000.000/0000-00');

    $("#Outra").on("click", function(e){
        $("#raInput").val("");
        $("#anoInput").val("");
        $("#cursoInput").val("");
    });
    $("#UEMG").on("click", function(e){
        $("#instituicaoInput").val("");
    });

    $(function(){
        var regex = new RegExp('[^ a-zA-ZàèìòùáéíóúâêîôûãõÀÈÌÒÙÁÉÍÓÚÂÊÎÔÛÃÕ]', 'g');
        // repare a flag "g" de global, para substituir todas as ocorrências
        $('#nomeInput').bind('input', function(){
            $(this).val($(this).val().replace(regex, ''));
        });
        
    });

    // Nome
    $('#nomeInput').keypress(function(e) { 
        var s = String.fromCharCode(e.which);

        if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
            $('#nomeInput').css("border-color", "#dc3444");
            $('#nomeLabel').css("color", "#dc3444");
            $('#capsNomeAtivado').css("display", "inline");
            return false;
        }
        else{
            normalizarCampo("nome");
            $('#capsNomeAtivado').css("display", "none");
        }
    });

    // CPF
    $("#cpfInput").change(function(e){
        normalizarCampo("cpf");
    });

    // Data de Nascimento
    $("#nascInput").change(function(e){
        normalizarCampo("nasc");
    });

    // Curso
    $("#cursoInput").change(function(e){
        normalizarCampo("curso");
    });

    // RA ou MASP
    $("#raInput").change(function(e){
        normalizarCampo("ra");
    });

    // Ano
    $("#anoInput").change(function(e){
        normalizarCampo("ano");
    });

    // Telefone
    $("#telInput").change(function(e){
        normalizarCampo("tel");
    });

    // CNPJ
    $("#cnpjInput").change(function(e){
        normalizarCampo("cnpj");
    });

    // Instituição
    $('#instituicaoInput').keypress(function(e) { 
        var s = String.fromCharCode( e.which );
        
        var chr = String.fromCharCode(e.which);
        if ("qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM0123456789 ".indexOf(chr) < 0)
        return false;

        if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
        printaErro("instituicao");
        }
        else{
        normalizarCampo("instituicao");
        }
    });

    // E-mail
    $("#emailInput").change(function(e){
        normalizarCampo("email");
    });

    // Senha
    $("#senhaInput").change(function(e){
        var senha = document.getElementById("senhaInput").value;
        var senhaCon = document.getElementById("senhaConInput").value;
        
        if(senha === senhaCon && (senha !== "" && senhaCon !== "")){
            normalizarCampo("senha");
            $("#senhaErroCon").css("display", "none");
            normalizarCampo("senhaCon");
        }

        if(senha !== ""){
            $("#senhaErro").css("display", "none");
        }
    });

    // Senha CASP LOCK
    $("#senhaInput").keypress(function(e){
        var s = String.fromCharCode(e.which);
        
        var chr = String.fromCharCode(e.which);

        if( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
            $('#senhaCuidado').css("display", "inline");
        }
        else{
            $('#senhaCuidado').css("display", "none");
        }
    });

    // ReSenha
    $("#senhaConInput").change(function(e){
        var senha = document.getElementById("senhaInput").value;
        var senhaCon = document.getElementById("senhaConInput").value;

        if(senha === senhaCon && (senha !== "" && senhaCon !== "")){
            normalizarCampo("senha");
            $("#senhaErroCon").css("display", "none");
            normalizarCampo("senhaCon");
        }

        if(senhaCon !== ""){
            $("#senhaErro").css("display", "none");
        }
    });

    // ReSenha CASP LOCK
    $("#senhaConInput").keypress(function(e){
        var s = String.fromCharCode(e.which);
        
        var chr = String.fromCharCode(e.which);

        if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
            $('#senhaConCuidado').css("display", "inline");
        }
        else{
            $('#senhaConCuidado').css("display", "none");
        }
    });
});



$("#next1").click(function(){
    var uemg = document.getElementById("UEMG");
    var outra = document.getElementById("Outra");

    if(uemg.checked || outra.checked){
        proximo("phase2", "phase1");
        setTimeout(function(){ $('#nomeInput').focus(); }, 300);
    }
    else
        proximo("phase1", "phase2");

});

$("#next2").click(function(){
    var uemg = document.getElementById("UEMG");

    var nome = document.getElementById("nomeInput");
    var nomeStyle = window.getComputedStyle(document.getElementById("capsNomeAtivado"));
    var cpf = document.getElementById("cpfInput");
    var nasc = document.getElementById("nascInput");

    if(nome.value !== "" && cpf.value.length === 14 && nasc.value.length === 10 && nomeStyle["display"] === "none"){
        if(uemg.checked){
            proximo("phase3", "phase2");
            setTimeout(function(){ $('#cursoInput').focus(); }, 300);
        }
        else{
            proximo("phase4", "phase2");
            setTimeout(function(){ $('#telInput').focus(); }, 300);
        }
        
    }
    else{
        proximo("phase2", "phase1");

        if(nome.value.length === 0)
        printaErro("nome");
        
        if(cpf.value.length <= 13)
        printaErro("cpf");
        
        if(nasc.value.length <= 9 || nasc.value.length >= 11)
        printaErro("nasc");
    }
});

$("#next3").click(function(){
    var uemg = document.getElementById("UEMG");

    var curso = document.getElementById("cursoInput");
    var ra = document.getElementById("raInput");
    var ano = document.getElementById("anoInput");

    if(curso.value !== "" && ra.value.length === 8 && ano.value.length === 4){
        proximo("phase4", "phase3");
        setTimeout(function(){ $('#telInput').focus(); }, 300);
        if(uemg.checked)
            $("#outraIns").css("display", "none");
    }
    else{
        proximo("phase3", "phase2");

        if(curso.value.length === 0)
        printaErro("curso");
        
        if(ra.value.length <= 7)
        printaErro("ra");
        
        if(ano.value.length <= 3)
        printaErro("ano");
    }

});

$("#next4").click(function(){
    var tel = document.getElementById("telInput");
    var cnpj = document.getElementById("cnpjInput");
    var instituicao = document.getElementById("instituicaoInput");

    if((tel.value === "" || (tel.value.length === 16 || tel.value.length === 15)) &&
        (cnpj.value === "" || cnpj.value.length === 18) &&
        instituicao.value.length >= 0){
        proximo("phase5", "phase4");
        setTimeout(function(){ $('#emailInput').focus(); }, 300);
    }
    else{
        proximo("phase4", "phase3");

        if(tel.value.length <= 14 && tel.value !== "")
            printaErro("tel");
        
        if(cnpj.value.length <= 17 && cnpj.value !== "")
            printaErro("cnpj");
    }
});

$("#back1").click(function(){
    proximo("phase1", "phase2");
});
$("#back2").click(function(){
    proximo("phase2", "phase3");
});
$("#back3").click(function(){
    var uemg = document.getElementById("UEMG");

    if(uemg.checked)
        proximo("phase3", "phase4");
    else
        proximo("phase2", "phase4");
});
$("#back4").click(function(){
    proximo("phase4", "phase5");
});

// Funções <---

function normalizarCampo(campo){
    $("#"+campo+"Input").css("border-color", "#c7c7c7");
    $("#"+campo+"Label").css("color", "#313f50");
    $("#"+campo+"Erro").css("display", "none");
}

function proximo(prox, ant){
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
        }, 300);
        }
    });
}
    
function printaErro(campo){
    $("#"+campo+"Erro").css("display", "inline");
    $("#"+campo+"Input").css("border-color", "#dc3444");
    $("#"+campo+"Label").css("color", "#dc3444");
}

function senhasDiferente(){
    $("#senhaErroCon").css("display", "inline");
    $("#senhaInput").css("border-color", "#dc3444");
    $("#senhaConInput").css("border-color", "#dc3444");
    $("#senhaLabel").css("color", "#dc3444");
    $("#senhaConLabel").css("color", "#dc3444");
}

$("#formCadastro").submit(function(e){
    var email = document.getElementById("emailInput").value;
    var senha = document.getElementById("senhaInput").value;
    var senhaCon = document.getElementById("senhaConInput").value;

    var emailValido = email.substr(email.indexOf("@"));
    var emailValidoAux = emailValido.substr(emailValido.indexOf(".")+1);

    if(email !== "" && (emailValido !== emailValidoAux && emailValidoAux.length >=2 ) && 
       (senha !== "" && (senha.length >= 5 && senha.length <= 20)) &&
       (senhaCon !== "" && (senhaCon.length >= 5 && senhaCon.length <= 20))){
        if(senha === senhaCon){
            $("#formCadastro").submit();
        }
        else{
            senhasDiferente();
        }
    }
    else{
        proximo("phase5", "phase4");
        if(email === "" || (emailValidoAux.length < 2 || emailValido === emailValidoAux))
            printaErro("email");
        if(senha === "" || senha.length < 5 || senha.length > 20)
            printaErro("senha");
        if(senhaCon === "" || senhaCon.length < 5 || senhaCon.length > 20)
            printaErro("senhaCon");
        if(senha !== senhaCon)
            senhasDiferente();
    }
    e.preventDefault();
});    
