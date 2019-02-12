<?php
    require_once('index.php');

    $end .= "eventos/";

    if(isset($_SESSION['a']) && isset($_SESSION['e'])){

        $objBd = new bd();
        $link = $objBd->conecta_mysql();

        $id = base64_decode($_SESSION["a"]);
        $ide = base64_decode($_SESSION["e"]);

        if(!validaAdm($_SESSION['user'], $ide)){
            # Admin não tem permissão apara editar a atividade.
            $_SESSION['erro'] = base64_encode(9);
            header("Location: {$end}eventos.php?e=".base64_encode($ide));
        
            die();
        }
        
        if(isset($_GET['codigo'])){
            $cod = filter_input(INPUT_GET, 'codigo', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $cpf = substr(strrchr($cod, ","), 1);
        }

        if(isset($_POST['codigo'])){
            $cpf = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $sql ="SELECT nome FROM usuarios WHERE cpf= '{$cpf}'";

        if(mysqli_num_rows(mysqli_query($link, $sql))){
            
            $user = mysqli_fetch_array(mysqli_query($link, $sql), MYSQLI_ASSOC);

            $sql ="SELECT u.nome FROM usuarios u INNER JOIN usuario_atividade ua ON u.id = ua.usuario INNER JOIN atividades a ON ua.atividade = a.id WHERE u.cpf= '{$cpf}' AND a.id = {$id}";
            
            // echo $sql;

            if(mysqli_num_rows(mysqli_query($link, $sql))){

                $sql = "UPDATE usuario_atividade ua INNER JOIN usuarios u ON u.id = ua.usuario INNER JOIN atividades a ON ua.atividade = a.id SET ua.presenca = 1 WHERE a.id = {$id} AND u.cpf = '{$cpf}'";

                mysqli_query($link, $sql);

                $sql = "SELECT u.nome FROM usuarios u INNER JOIN usuario_atividade ua ON u.id = ua.usuario INNER JOIN atividades a ON ua.atividade = a.id WHERE u.cpf= '{$cpf}' AND a.id = {$id} AND ua.presenca = 1";


                if(mysqli_num_rows(mysqli_query($link, $sql))){

                    mysqli_close($link);

                    $_SESSION['u'] = base64_encode($user['nome']);

                    $_SESSION['success'] = base64_encode(1);
                    
                }
                else{
                    mysqli_close($link);
                    $_SESSION['erro'] = base64_encode(1);
                    
                }
                
            }
            else{
                mysqli_close($link);

                $_SESSION['erro'] = base64_encode($user['nome']);
            }
        }
        else{
            mysqli_close($link);
            
            $_SESSION['erro'] = base64_encode(2);
        }

    }

    header("Location: {$end}presenca.php");
