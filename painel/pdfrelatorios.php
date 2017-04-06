<?php

ob_start();
$html = ob_get_clean();

$html = utf8_encode($html); 

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


$id = "12";
$result_evento = "select * from eventos where id = '$id' LIMIT 1";
$resultado_evento = mysqli_query($conn,$result_evento);
$row_evento = mysqli_fetch_assoc($resultado_evento);



$html .= 
"
    <html>
        <body>
        <h1>Eventos abertos</h1>
        id: ".row_evento['id']."<br>
        Título: ".row_evento['titulo']."<br>
        Descrição: ".row_evento['descricao']."<br>
        Data de início: ".row_evento['data_inicio']."<br>
        Data do fim: ".row_evento['data_fim']."<br>
        Organizador: ".row_evento['organizador']."<br>
        Valor: ".row_evento['valor']."<br>
        Pagar para: ".row_evento['paga_para']."<br>


        </body>
    </html>
";


$arquivo = "Cadastro01.pdf";

include("../mpdf60/mpdf.php");

$mpdf = new mPDF();

$mpdf->allow_charset_conversion = true;

$mpdf->charset_in = 'UTF-8';

$mpdf->WriteHTML($html);

$mpdf->Output('meu-pdf','I');

exit();

?>