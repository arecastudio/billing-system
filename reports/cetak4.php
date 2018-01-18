<?php
ob_start();
 include('../area.php');
 $content = ob_get_clean();
 
// conversion HTML => PDF
 require_once('../html2pdf/html2pdf.class.php');
 try
 {
 $html2pdf = new HTML2PDF('L','A4', 'fr', false, 'ISO-8859-15');
 $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
 $html2pdf->Output('msf.pdf');
 }
 catch(HTML2PDF_exception $e) { echo $e; }
?>