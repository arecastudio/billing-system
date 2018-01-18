<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//require_once("head.php");

ini_set('max_execution_time', 0);//unlimited
ini_set('memory_limit', '512M');		
ini_set('query_cache_type', '1');
ini_set('query_cache_size', '26214400');


$tgl="";
//$tgl="2014-05-06";
$tgl=$_GET['tanggal'];
//$tanggal=;
$ksr="";
//echo date('Y-m-d');

					$lembar=0;
					$rekening=0;
					$adm=0;
					$meter=0;
					$denda=0;
					$meterai=0;
					$total=0;
					
					$lembar1=0;
					$rekening1=0;
					$adm1=0;
					$meter1=0;
					$denda1=0;
					$meterai1=0;
					$total1=0;

?>
<html>
	<head>
    	<title>Rekap LPP</title>
    </head>
    <body>
    	<!--form name="f1" method="post" action=""><input type="submit" name="konversi" value="Simpan ke format Excel" /></form-->
		<?php
		$konversi=0;
		//if(isset($_POST['konversi'])){
		//if($konversi=1){
			//$konversi=1;
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=LPP_$tgl.xls");
		//}
		?>
    	<h3 align="center"><b>REKAP LAPORAN PENERIMAAN DAN PENAGIHAN</b></h3>        
    	<table width="1200px" align="center" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;border-style:dotted;font-family:Cambria;font-size:12px;line-height:0.0;">
        	<?php
            $sql="SELECT DISTINCT t.loket FROM transaksi AS t WHERE t.tbayar='".$tgl."' AND t.batal=0 ORDER BY t.loket";
			$qry=mysql_query($sql)or die(mysql_error());
			while($row=mysql_fetch_row($qry)){
				$ksr=$row[0];
				echo"				
				<tr height=\"16\" style=\"vertical-align:middle\" >
					<td colspan=\"2\" style=\"border:dotted \">LOKET</td>
					<td align=\"center\" colspan=\"1\" style=\"border:dotted \">
						<b>$row[0]</b>
					</td>
					<td align=\"center\" colspan=\"6\" style=\"border:dotted \">
					</td>
				</tr>
				<tr height=\"16\" style=\"vertical-align:middle\" >
					<td colspan=\"2\" style=\"border:dotted \">TANGGAL</td>
					<td align=\"center\" colspan=\"1\" style=\"border:dotted \">
					
						$tgl
						
					</td>
					<td align=\"center\" colspan=\"6\" style=\"border:dotted \">
					</td>
				</tr>
				<tr height=\"16\" style=\"vertical-align:middle\" >
					<th width=\"50px\" style=\"border:dotted \">No.</th>
					<th style=\"border:dotted \">Jenis Pelanggan</th>					
					<th style=\"border:dotted \">Lembar</th>
					<th style=\"border:dotted \">Rekening Air</th>
					<th style=\"border:dotted \">Adm</th>
					<th style=\"border:dotted \">Meter</th>
					<th style=\"border:dotted \">Denda</th>
					<th style=\"border:dotted \">Meterai</th>
					<th style=\"border:dotted \">Total</th>
				</tr>				
				";
				$i=0;$row2=0;
				$sql2="SELECT m.gol,(SELECT DISTINCT tf.keterangan FROM tarif AS tf WHERE tf.gol=r.gol LIMIT 0,1)AS ket, COUNT(*), SUM(r.uangair),SUM(r.adm),SUM(r.meter),SUM(r.denda),SUM(r.meterai),SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda) FROM rekening1 AS r				
				INNER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode
				INNER JOIN master AS m ON m.nomor=r.nomor
				WHERE r.status_bayar=1 AND t.batal=0 AND t.tbayar='$tgl' AND t.loket='$ksr' GROUP BY m.gol;";

				$qry2=mysql_query($sql2)or die(mysql_error());
				while($row2=mysql_fetch_row($qry2)){
					$i++;
					$lembar+=$row2[2];
					$rekening+=$row2[3];
					$adm+=$row2[4];
					$meter+=$row2[5];
					$denda+=$row2[6];
					$meterai+=$row2[7];
					$total+=$row2[8];
					
					$lembar1+=$row2[2];
					$rekening1+=$row2[3];
					$adm1+=$row2[4];
					$meter1+=$row2[5];
					$denda1+=$row2[6];
					$meterai1+=$row2[7];
					$total1+=$row2[8];
					echo"
					<tr height=\"16\" style=\"vertical-align:middle\" >
						<td align=\"center\" style=\"border:dotted \">$i</td>
						<td style=\"border:dotted \">$row2[0] - $row2[1]</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[2])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[3])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[4])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[5])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[6])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[7])."</td>
						<td align=\"right\" style=\"border:dotted \">".formatMoney($row2[8])."</td>
						
					</tr>
					
					
					";
				}
				echo"
				<tr style=\"font-weight:bold;border:dotted;vertical-align:middle; \" height=\"16\" >
				<td align=\"center\" colspan=\"2\" style=\"border:dotted \">Sub Total</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($lembar)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($rekening)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($adm)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($meter)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($denda)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($meterai)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($total)."</td>
				
				</tr>
				
				
				";
				$lembar=0;
					$rekening=0;
					$adm=0;
					$meter=0;
					$denda=0;
					$meterai=0;
					$total=0;
				
				
				echo"
				<tr height=\"16\">
					<td colspan=\"9\">&nbsp;</td>
				</tr>
				";
				
			}
			echo"
				<tr style=\"font-weight:bold;border:dotted;vertical-align:middle;\" height=\"16\">
				<td align=\"center\" colspan=\"2\" style=\"border:dotted \">Total</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($lembar1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($rekening1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($adm1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($meter1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($denda1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($meterai1)."</td>
				<td align=\"right\" style=\"border:dotted \">".formatMoney($total1)."</td>
				
				</tr>
				
				
				";
			
			?>
            
        </table>
        <?php
        //if($konversi=1){
			exit();
		//}
		?>
    </body>
</html>	
<?php
putus();
?>