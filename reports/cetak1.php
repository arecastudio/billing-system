<?php
session_start();
session_register(mixed 'dsf');
$hitung=session_id();

include("../mpdf57/mpdf.php");
$mpdf=new mPDF('c');
$mpdf->mirrorMargins = 1; // Use different Odd/Even headers and footers and mirror margins
$mpdf->defaultheaderfontsize = 10; /* in pts */
$mpdf->defaultheaderfontstyle = B; /* blank, B, I, or BI */
$mpdf->defaultheaderline = 1; /* 1 to include line below header/above footer */
$mpdf->defaultfooterfontsize = 12; /* in pts */
$mpdf->defaultfooterfontstyle = B; /* blank, B, I, or BI */
$mpdf->defaultfooterline = 1; /* 1 to include line below header/above footer */
$mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}|Report Data Pelanggan');
$mpdf->SetFooter('{PAGENO}'); /* defines footer for Odd and Even Pages - placed at Outer margin */
$mpdf->SetFooter(array(
 'L' => array(
 'content' => 'Text to go on the left',
 'font-family' => 'sans-serif',
 'font-style' => 'B', /* blank, B, I, or BI */
 'font-size' => '10', /* in pts */
 ),
 'C' => array(
 'content' => '- {PAGENO} -',
 'font-family' => 'serif',
 'font-style' => 'BI',
 'font-size' => '18', /* gives default */
 ),
 'R' => array(
 'content' => 'Printed @ {DATE j-m-Y H:m}',
 'font-family' => 'monospace',
 'font-style' => '',
 'font-size' => '10',
 ),
 'line' => 1, /* 1 to include line below header/above footer */
), 'E' /* defines footer for Even Pages */
);

$thead="
<table border=\"1\" style=\"font-size:11px;\" width=\"600px\" align=\"center\">
	<tr>
		<td>No.</td>
		<td>Nomor</td>
		<td>No. Lama</td>
		<td>Nama</td>
		<td>Alamat</td>
		<td>No. Rumah </td>
		<td>RT</td>
		<td>RW</td>
		<td>Cabang</td>
		<td>Wil</td>
		<td>Blok</td>
		<td>DKD</td>
		<td>Jns Pel </td>
		<td>Kondisi WM </td>
		<td>Gol</td>		
	</tr>
</table>
";

$html = "
<h2>Data Pelanggan</h2>
".$thead."
<p>ini adalah contoh file report pertama </p>


<h3>Even / Left page</h3>

<p>Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros
at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit
amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis,
nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellusmetus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam
odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet
odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>

".$hitung."

";
for($i=1;$i<=10;$i++){
$mpdf->WriteHTML($html);
if ($i<10)$mpdf->WriteHTML("<pagebreak />");
}
$mpdf->Output();
exit;
?>