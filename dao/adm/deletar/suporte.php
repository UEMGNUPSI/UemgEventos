<?php 

require_once("index.php");

$end .= "nupsi/";

$id	= base64_decode(filter_input(INPUT_GET, 's', 
	  FILTER_SANITIZE_SPECIAL_CHARS));

$objBd = new bd();
$link = $objBd->conecta_mysql();

if(mysqli_query($link, "DELETE FROM suporte WHERE id = {$id}")){
    mysqli_close($link);

    $_SESSION['success'] = base64_encode(3);

    header("Location: {$end}");

    die();
}
else{
    mysqli_close($link);

    $_SESSION['erro'] = base64_encode(3);

    header("Location: {$end}");

    die();
}

?>