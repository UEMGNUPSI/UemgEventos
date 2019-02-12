<?php
    function head($title){
        echo "<meta charset='utf-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
        echo "<link rel='shortcut icon' href='/public/imagens/icone.ico' type='image/x-icon'/>";
        echo "<title>{$title}</title>";
        echo "<link rel='stylesheet' href='/public/frameworks/bootstrap/css/bootstrap.css'>
        <link rel='stylesheet' type='text/css' href='/public/estilo.css' media='screen'>";

        echo "<link rel='stylesheet' href='/public/frameworks/Swiper-3.4.2/dist/css/swiper.css'>";
    }
?>
