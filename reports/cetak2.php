<?php
	session_start();
	require_once("../html2pdf/html2pdf.class.php");
	//requier_once("print_class.php");
	//error_reporting(0);
	$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(10, 0, 10, 0));
	$pdf->setDefaultFont('Arial');
	
	$strContent = "
	<page>
		<div align=\"right\">1</div>
		<h1 align=center>Hello World!</h1><p>Sekarang saya bisa bikin laporan PDF dengan mudah</p><font size=\"18\">erer</font>
	</page>
	<page>
		<div align=\"right\">2</div>
		sdfsfsfdsfdsf		
	</page>
	";
	
	$pdf->WriteHTML($strContent);
	$pdf->Output("sample.pdf","I");
?> 