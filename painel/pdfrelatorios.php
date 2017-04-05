<?php

ob_start();

$html = ob_get_clean();

$html = utf8_encode($html);

$html .= '<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-mb3i{background-color:#D2E4FC;text-align:right;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-6k2t{background-color:#D2E4FC;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
<table class="tg">
  <tr>
    <th class="tg-baqh" colspan="6">Results</th>
  </tr>
  <tr>
    <td class="tg-6k2t">No</td>
    <td class="tg-6k2t">Competition</td>
    <td class="tg-6k2t">John</td>
    <td class="tg-6k2t">Adam</td>
    <td class="tg-6k2t">Robert</td>
    <td class="tg-6k2t">Paul</td>
  </tr>
  <tr>
    <td class="tg-yw4l">1</td>
    <td class="tg-yw4l">Swimming</td>
    <td class="tg-lqy6">1:30</td>
    <td class="tg-lqy6">2:05</td>
    <td class="tg-lqy6">1:15</td>
    <td class="tg-lqy6">1:41</td>
  </tr>
  <tr>
    <td class="tg-6k2t">2</td>
    <td class="tg-6k2t">Running</td>
    <td class="tg-mb3i">15:30</td>
    <td class="tg-mb3i">14:10</td>
    <td class="tg-mb3i">15:45</td>
    <td class="tg-mb3i">16:00</td>
  </tr>
  <tr>
    <td class="tg-yw4l">3</td>
    <td class="tg-yw4l">Shooting</td>
    <td class="tg-lqy6">70%</td>
    <td class="tg-lqy6">55%</td>
    <td class="tg-lqy6">90%</td>
    <td class="tg-lqy6">88%</td>
  </tr>
  
</table>';

include("../mpdf60/mpdf.php");

$mpdf = new mPDF();

$mpdf->allow_charset_conversion = true;

$mpdf->charset_in = 'UTF-8';

$mpdf->WriteHTML($html);

$mpdf->Output('meu-pdf','I');

exit();

?>