<?php

    require_once('index.php');

    $end .= "eventos/";

    if(isset($_GET['p']) && isset($_GET['e']) && isset($_GET['a'])){
        $id 		    = 	base64_decode(filter_input(INPUT_GET, 
                        'p', FILTER_SANITIZE_SPECIAL_CHARS));

        $base64_id 	    = 	filter_input(INPUT_GET, 'p', 
                            FILTER_SANITIZE_SPECIAL_CHARS);

        $evento 		= 	base64_decode(filter_input(INPUT_GET, 
                            'e', FILTER_SANITIZE_SPECIAL_CHARS));

        $base64_evento 	= 	filter_input(INPUT_GET, 'e', 
                            FILTER_SANITIZE_SPECIAL_CHARS);

        $avaliacao 	    = 	filter_input(INPUT_GET, 'a', 
                            FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(!validaAdm($_SESSION['user'], $evento)){
            # Admin não tem permissão apara editar a atividade.
            $_SESSION['erro'] = base64_encode(9);
            header("Location: {$end}");
        
            die();
        }

        $objBd = new bd();
        $link = $objBd->conecta_mysql();

        if(mysqli_query($link, "UPDATE projetos SET aprovacao = {$avaliacao} WHERE id = {$id}")){
            mysqli_close($link);
            
            $_SESSION['success'] = base64_encode(1);
            header("Location: {$end}projetos.php?e={$base64_evento}");
        
            die();

        }
        else{
            mysqli_close($link);
            
            $_SESSION['erro'] = base64_encode(1);
            header("Location: {$end}projetos.php?e={$base64_evento}");
        
            die();
        }

    }
    else{
        $_SESSION['erro'] = base64_encode(9);
        header("Location: {$end}");
        
        die();
    }

    
