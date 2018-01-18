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
$tgl= date('Y-m-d');//"2014-05-06";
$cbg="";
//$prd=gperiode();
$prd=$_GET['periode'];
//echo date('Y-m-d');
//echo $prd;
?>
<html>
	<head>
    	<title>Pelanggan Non Tunggak</title>
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
			header("Content-Disposition: attachment; filename=pel_non_tunggak_BRIVA_".$tgl.".xls");
		//}
		?>    	
    	<table width="100%" align="center" border="1" cellpadding="1" cellspacing="1"  style="border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:13px;">
        	<tr><td colspan="19" style="text-align:center;font-weight:bold;font-size:20px;">Data Pelanggan PDAM tanpa Tunggakan per <?php echo $tgl;?></td></tr>
			<tr style="text-align:center;font-weight:bold;">
				<td>Nomor</td>
				<td>Nolama</td>
				<td>Nama</td>
				<td>Alamat</td>
				<td>Gol</td>
				<td>Kond.WM</td>
				<td>Blok</td>
				<td>Wilayah</td>
				<td>Cabang</td>
				<td>Periode</td>
				<td>St. Lalu</td>
				<td>St. Kini</td>
				<td>Pakai</td>
				<td>Uang Air</td>
				<td>Adm</td>
				<td>Meter</td>
				<td>Meterai</td>
				<td>Denda</td>
				<td>Total</td>
			</tr>
			
			<?php
            $sql="
			SELECT DISTINCT r.nomor,m.nolama,m.nama,m.alamat,m.gol,m.kondisi_meter,m.kode_blok,m.kode_wilayah,m.cabang,r.periode,r.standlalu,r.standkini,r.pakai,r.uangair,r.adm,r.meter,r.meterai,r.denda,(r.uangair+r.adm+r.meter+r.meterai+r.denda)
			FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor
			WHERE r.status_bayar=1 AND (SELECT COUNT(q.nomor) FROM rekening1 AS q WHERE q.periode<$prd AND q.status_bayar=0 AND q.nomor=r.nomor)=0 AND (r.periode=$prd)
			ORDER BY m.nolama ASC
			";
			$qry=mysql_query($sql)or die(mysql_error());
			while($row=mysql_fetch_row($qry)){
				$cbg=$row[0];
				echo"				
				<tr>					
					<td align=\"center\">$row[0]&nbsp;</td>
					<td align=\"center\">$row[1]&nbsp;</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td align=\"center\">$row[4]</td>
					<td align=\"center\">$row[5]&nbsp;</td>
					<td align=\"center\">$row[6]&nbsp;</td>
					<td align=\"center\">$row[7]&nbsp;</td>
					<td align=\"center\">$row[8]&nbsp;</td>
					<td align=\"center\">$row[9]</td>
					<td>$row[10]</td>
					<td>$row[11]</td>
					<td>$row[12]</td>
					<td>$row[13]</td>
					<td>$row[14]</td>
					<td>$row[15]</td>
					<td>$row[16]</td>
					<td>$row[17]</td>
					<td>$row[18]</td>
				</tr>				
				";				
			}
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