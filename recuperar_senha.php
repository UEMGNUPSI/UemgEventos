<?php

    session_start();

    include('config.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once('dao/bd.php');

    $url = isset($_GET['l']) ? base64_decode($_GET['l']) : "/public";

    if(isset($_SESSION['user'])){
        header("Location: {$url}");
        die();
    }

    function formEmail(){
        echo "<header class='row'>";
            echo "<h4 class='text-dark-yellow'>Esqueceu sua senha?</h4>";
            echo "<p>Preencha o formulário abaixo para requisitar uma nova senha!</p>";
        echo "</header>";
        echo "<form action='recuperar_senha.php' method='post'>";
            echo "<div class=item-info middleX'>";
                echo "<label for='inputEmail' class='item-label'><span class='glyphicon glyphicon-envelope' style='top: 2px'></span> E-mail</label>";
                echo "<input id='inputEmail' class='form-custom' type='email' name='email' style='width: 100%;' />";
            echo "</div>";
            echo "<button class='btn-custom btn-recuperar middleX'>Requisitar Nova Senha</button>";
        echo "</form>";
    }

    function formNovaSenha($token){
        echo "<style>";
            echo ".erro-span{";
                echo "font-weight: 400;";
                echo "text-transform: none;";
                echo "color: #dc3444;";
                echo "display: none;";
            echo "}";
        echo "</style>";
        echo "<header class='row'>";
            echo "<h4 class='text-dark-yellow'>Nova Senha</h4>";
            echo "<p>Preencha o formulário abaixo para alterar sua uma nova senha!</p>";
        echo "</header>";
        echo "<form id='formAltera' action='dao/user/atualiza_usuario.php?e={$token}' method='post'>";
            echo "<div class=item-info middleX'>";
                echo "<label id='senhaLabel' for='senhaInput' class='item-label'>Nova Senha <span id='senhaCuidado' class='erro-span'>CAPS LOCK ativado! </span><span id='senhaErro' class='erro-span'>As senhas não se coincidem ou campo inválido!</span></label>";
                echo "<input id='senhaInput' class='form-custom' type='password' name='novaSenha' placeholder='min: 5 caracteres e máx: 20 caracteres' />";
            echo "</div>";
            echo "<div class=item-info middleX'>";
                echo "<label id='senhaConLabel' for='senhaConInput' class='item-label'>Digite Novamente a Senha <span id='senhaErroCon' class='erro-span'>As senhas não se coincidem ou campo inválido!</span></label>";
                echo "<input id='senhaConInput' class='form-custom' type='password' name='senhaCon' placeholder='min: 5 caracteres e máx: 20 caracteres' />";
            echo "</div>";
            echo "<button id='alterar' class='btn-custom btn-recuperar middleX'>Alterar Senha</button>";
        echo "</form>";
        echo "<script>";
            echo "window.onload = function(){\n";
                echo "$('#senhaInput').keypress(function(e){\n";
                    echo "var s = String.fromCharCode(e.which);\n";
                    echo "var chr = String.fromCharCode(e.which);\n";
                    echo "var tamanho = $('#senhaInput').val().length;\n";

                    echo "if( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ){\n";
                        echo "$('#senhaCuidado').css('display', 'inline');\n";
                        echo "$('#senhaLabel').css('color', '#dc3444');\n";
                        echo "$('#senhaInput').css('border-color', '#dc3444');\n";
                        echo "return false";
                    echo "}\n";
                    echo "else{\n";
                        echo "$('#senhaCuidado').css('display', 'none');\n";
                        echo "$('#senhaInput').css('border-color', '#c7c7c7');\n";
                        echo "$('#senhaLabel').css('color', '#313f50');\n";
                    echo "}\n";
                    echo "if(tamanho > 20)";
                        echo "return false";
                echo "});\n";

                echo "$('#senhaConInput').keypress(function(e){\n";
                    echo "var tamanho = $('#senhaConInput').val().length;\n";

                    echo "$('#senhaErroCon').css('display', 'none');\n";
                    echo "$('#senhaConInput').css('border-color', '#c7c7c7');\n";
                    echo "$('#senhaConLabel').css('color', '#313f50');\n";

                    echo "if(tamanho > 20)";
                        echo "return false";
                echo "});\n";
                
                echo "$('#alterar').click(function(e){\n";
                    echo "var senha = $('#senhaInput').val();\n";
                    echo "var senhaCon = $('#senhaConInput').val();\n";
                    echo "console.log(senha+' '+senhaCon);\n";
                    echo "if(senha !== '' && (senha.length >= 5 && senha.length <= 20) && (senhaCon !== '' && (senhaCon.length >= 5 && senhaCon.length <= 20))){\n";
                        echo "if(senha === senhaCon){\n";
                            echo "$('#formAltera').submit();\n";
                        echo "}\n";
                        echo "else{\n";
                            echo "$('#senhaErroCon').css('display', 'inline');\n";
                            echo "$('#senhaErro').css('display', 'inline');\n";
                            echo "$('#senhaLabel').css('color', '#dc3444');\n";
                            echo "$('#senhaInput').css('border-color', '#dc3444');\n";
                            echo "$('#senhaConLabel').css('color', '#dc3444');\n";
                            echo "$('#senhaConInput').css('border-color', '#dc3444');\n";
                        echo "}\n";
                    echo "}\n";
                    echo "else{\n";
                        echo "$('#senhaErroCon').css('display', 'inline');\n";
                        echo "$('#senhaErro').css('display', 'inline');\n";
                        echo "$('#senhaInput').css('border-color', '#dc3444');\n";
                        echo "$('#senhaConInput').css('border-color', '#dc3444');\n";
                        echo "$('#senhaLabel').css('color', '#dc3444');\n";
                        echo "$('#senhaConLabel').css('color', '#dc3444');\n";
                    echo "}\n";
                    echo "e.preventDefault();\n";
                echo "});\n";
            echo "}\n";
        echo "</script>";
    }

    
?>

<!DOCTYPE html>
<html>
<head>
    <?php 
        require_once("head.php");
        head("UEMG Eventos");
        
    ?>
</head>
<body style="margin: 0">
    <?php 
        include('login.php');
        require_once("nav.php");
        require("dialog.php");

        function send($user){
            require 'frameworks/PHPMailer/src/PHPMailer.php';
            require 'frameworks/PHPMailer/src/Exception.php';
            require 'frameworks/PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    
            try {
    
                $token = md5(random_int(-1000, 1000).$user['email'].random_int(-1000, 1000));
    
                $novaSenha = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?t={$token}";
    
                $mail->CharSet = "UTF-8";
    
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    
                $mail->isSMTP();                                           // Set mailer to use SMTP
    
                $mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
    
                $mail->Port = 587;                                        // TCP port to connect to
    
                $mail->SMTPAuth = true;                             // Enable SMTP authentication
    
                $mail->Username = 'uemgeventos@gmail.com';                 // SMTP username
                $mail->Password = 'nupsi*01';                                               // SMTP password
    
                $mail->isHTML(true);
    
                $mail->setFrom("uemgeventos@gmail.com", "UEMG Eventos");
                $mail->addAddress($user['email'], $user['nome']);
    
                $mail->Subject = "Solicitação de Alteração de Senha";
    
                $mail->Body = "
            <!DOCTYPE html>
            <html>
                <head>
                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                    <meta charset='utf-8' />
                    <link href='https://fonts.googleapis.com/css?family=Hind+Vadodara:300,400,700' rel='stylesheet' />

                    <style>
                        body{
                            font-family: 'Hind Vadodara', sans-serif !important;
                                color: #313f50 !important;
                                
                            margin: 0;
                        }
                        main{
                            background: #fafafa !important;
                            padding: 1rem;
                        }
                    
                        h2{
                            margin: 0;
                            color: #002b5c !important;
                            text-transform: uppercase;
                            font-size: 1.4rem !important;
                        }
                    
                        a{
                            text-decoration: none;
                            background: #cedeef;
                            color: #0c2548de !important;
                            padding: .3rem 2rem;
                            border-radius: 20px;
                        }
                            a:hover, a:focus, a:visited, a:active{text-decoration: none;}
                    
                        em{
                            display: block;
                            color: #00000060 !important;
                                font-size: .65rem;
                    
                            margin-top: 2rem;
                            
                        }
                    
                        footer{
                            
                            display: block;
                            
                            background-color: #3b6e8f;
                            background-image: url('imagens/MARCA_UEMG_negativa.jpg');
                                background-blend-mode: lighten;
                                background-repeat: no-repeat;
                                background-position: right;
                                background-size: contain;
                            
                            padding: 1.7rem;
                        
                            margin: 1rem -16px -17px -16px;
                        }
                    
                        
                    </style>
                </head>
                <body >
                    <main style='font-family: 'Hind Vadodara', sans-serif !important; color: #313f50 !important;'>
                        <header><h2 align='center'>Solicitação de Nova Senha</h2></header>
                        <p>Olá <b>{$user['nome']}</b>!</p>
                        <p style='margin-bottom: 2rem;'>Você solicitou uma redefinição da sua senha no site UEMG Eventos, para isso clique no botão abaixo. Caso não tenha requisitado, apenas ignore esse e-mail.</p>
                        <div align='center'>
                            <a href='{$novaSenha}'>Redefinir Senha</a>
                            <em>Esta mensagem é enviada automaticamente, por favor não responda este e-mail.</em>
                        </div>
                        <footer></footer>
                    </main>
                </body>
            <html>";
    
                $mail->AltBody = "Olá {$user['nome']}! Você solicitou uma redefinição da sua senha no site UEMG Eventos, para isso acesse o link abaixo. Caso não tenha requisitado, apenas ignore esse e-mail. Link: {$novaSenha}";
                
                if($mail->send())
                    return $token;
                else
                    return 0;
            } catch (Exception $e) {
                dialog("erro", "A mensagem não pode ser enviada ao seu e-mail. Tente novamente mais tarde.");

                echo $mail->ErrorInfo;
                return 0;
            }
        }

        if(isset($_POST['email'])){
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    
            $objBd = new bd();
            $link = $objBd->conecta_mysql();
    
            if($user = mysqli_query($link, "SELECT * FROM usuarios WHERE email = '{$email}'")){
                if(mysqli_num_rows($user)){
                    $user = mysqli_fetch_array($user);
    
                    mysqli_close($link);
    
                    if($token = send($user)){
                        $objBd = new bd();
                        $link = $objBd->conecta_mysql();
    
                        if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM requisitar_senha WHERE email = '{$user['email']}'")))
                            mysqli_query($link, "DELETE FROM requisitar_senha WHERE email = '{$user['email']}'");
        
                        if(mysqli_query($link, "INSERT INTO requisitar_senha(email, data, token) VALUES ('{$user['email']}', '".date("Y-m-d H:i")."', '{$token}')")){
                            unset($_POST['email']);
                            unset($user);
                            unset($token);
        
                            dialog("success", "Um link foi enviado ao seu e-mail e ele expirará em 10 minutos.");
                            
                            mysqli_close($link);
                        }
                    }
                    else
                        dialog("erro","Não foi possível enviar uma mensagem ao seu e-mail, certifique-se que preencheu seu e-mail corretamente.");
                }
                else{
                    dialog("alert", "E-mail não encontrado no sistema! Certifique-se que preencheu seu e-mail corretamente.");
                }
            }
        }
    ?>
    
    <main class="container" style="height: calc(100vh - 50px);">
        <div class='col-md-6 center recuperar'>
            <?php 
                if(isset($_GET['t'])){
                    $token = filter_input(INPUT_GET, 't',FILTER_SANITIZE_SPECIAL_CHARS);

                    $objBd = new bd();
                    $link = $objBd->conecta_mysql();

                    $requisicao = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM requisitar_senha WHERE token = '{$token}'"));

                    mysqli_close($link);
                    
                    $horaRequisicao = new DateTime($requisicao['data']);
                    $horaAgora = new DateTime(date("Y-m-d H:i"));

                    $interval = $horaRequisicao->diff($horaAgora);

                    if(intval($interval->format("%d")) === 0 &&
                      (intval($interval->format("%H")) === 0) &&
                      ($interval->format("%R") === "+") &&
                      (intval($interval->format("%i")) < 10)){
                        formNovaSenha($token);
        echo "</div>";
    echo "</main>";
                      }
                    else{
                        formEmail();
        echo "</div>";
    echo "</main>";
                        dialog("erro", "Essa requisição já foi expirada! Tente recuperar sua senha novamente.");
                    }
                }
                else{
                    formEmail();
        echo "</div>";
    echo "</main>";
                }
        
            ?>
</body>
<?php 
        require_once("footer.php");
    ?>
</html>