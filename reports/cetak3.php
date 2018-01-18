<?php
require_once('../html2fpdf/html2fpdf.php');


error_reporting(0);
$f='license.txt';
$pdf=new HTML2FPDF();
$pdf->SetFont( 'Arial', '', 10 );//isi string kosong dgn B atau I untuk jenis font
$pdf->AddPage();
 $strContent="
 <table width=\"500\">
 	<tr>
		<td>df</td>
		<td>sdfsfsf</td>
	</tr>
 </table>
 
 ";//file_get_contents($f);
$pdf->WriteHTML($strContent);
$pdf->SetFont( 'Arial', 'I', 18 );
$pdf->AddPage();
 $strContent="<p  style=\"font-size:24;\">66666666</p><br><hr>";//file_get_contents($f);
$pdf->WriteHTML($strContent);
//$pdf->setDefaultFont('Arial');
header('Content-type: application/pdf');
$pdf->Output("sample.pdf","I");
?> 