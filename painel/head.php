<?php
    function head($title){
        echo "<meta charset='utf-8' />";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1' />";
        echo "<meta http-equiv='X-UA-Compatible' content='IE=edge' />";

        echo "<link rel='shortcut icon' href='/public/imagens/icone.ico' type='image/x-icon'/>";

        echo "<title>{$title}</title>";
        
        echo "<link rel='stylesheet' href='/public/frameworks/bootstrap/css/bootstrap.min.css' />";
        echo "<link rel='stylesheet' type='text/css' href='{$GLOBALS['end']}estilo.css' media='screen' />";

        echo "<script src='/public/js/navAdmin.js' /></script>";
    }

?>