<?php

ob_start();

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "uemg_eventos";

$conn =mysqli_connect($servidor,$usuario,$senha,$dbname);
if(!$conn){
  die("falha na conexao" . mysql_connect_error());
}
else{
  //echo '</tr>';
}
$id = "1";
$result_evento = "select * from eventos where id = '$id'";
$result_usuario = mysqli_query($conn,$result_evento);
$row_usuario = mysqli_fetch_assoc($result_usuario);

$html = ob_get_clean();

$html = utf8_encode($html);

$html .= 
"
    <html>
        <body>
        <h1>Batata quando nasce</h1>
        id: ".row_usuario['id']."<br>


        </body>
    </html>
";

include("../mpdf60/mpdf.php");

$mpdf = new mPDF();

$mpdf->allow_charset_conversion = true;

$mpdf->charset_in = 'UTF-8';

$mpdf->WriteHTML($html);

$mpdf->Output('meu-pdf','I');

exit();

?>