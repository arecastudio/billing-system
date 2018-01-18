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
    	<title>Rekap DRD</title>
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
			header("Content-Disposition: attachment; filename=nilai.xls");
		//}
		?>
    	<h2 align="center"><b>REKAP DRD Rekening <?php echo $prd;?></b></h3>        
    	<table width="900px" align="center" border="1" cellpadding="1" cellspacing="1"  style="border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:13px;">
        	<?php
            $sql="SELECT DISTINCT cabang,nama FROM cabang WHERE cabang<>'00' ORDER BY cabang";
			$qry=mysql_query($sql)or die(mysql_error());
			while($row=mysql_fetch_row($qry)){
				$cbg=$row[0];
				echo"				
				<tr>
					<td colspan=\"2\">CABANG</td>
					<td colspan=\"7\">
						$row[0] - $row[1]
					</td>
				</tr>
				<tr>
					<td colspan=\"2\">TANGGAL</td>
					<td colspan=\"7\">
						$tgl
					</td>
				</tr>
				<tr>
					<th width=\"50px\">No.</th>
					<th>Jenis Pelanggan</th>					
					<th>Lembar</th>
					<th>Rekening Air</th>
					<th>Adm</th>
					<th>Meter</th>
					<th>Denda</th>
					<th>Meterai</th>
					<th>Total</th>
				</tr>				
				";
				$i=0;$row2=0;//$prd="201405";
				$sql2="SELECT m.gol,(SELECT DISTINCT tf.keterangan FROM tarif AS tf WHERE tf.gol=m.gol LIMIT 0,1)AS ket, FORMAT(COUNT(*),0), FORMAT(SUM(r.uangair),0),FORMAT(SUM(r.adm),0),FORMAT(SUM(r.meter),0),FORMAT(SUM(r.denda),0),FORMAT(SUM(r.meterai),0),FORMAT(SUM(r.uangair + r.adm + r.meter + r.meterai + r.denda),0) FROM rekening1 AS r
INNER JOIN master AS m ON m.nomor=r.nomor
WHERE r.periode=$prd AND m.cabang='$cbg' GROUP BY m.gol;";

				$qry2=mysql_query($sql2)or die(mysql_error());
				while($row2=mysql_fetch_row($qry2)){
					$i++;
					echo"
					<tr>
						<td align=\"center\">$i</td>
						<td>$row2[0] - $row2[1]</td>
						<td align=\"right\">$row2[2]</td>
						<td align=\"right\">$row2[3]</td>
						<td align=\"right\">$row2[4]</td>
						<td align=\"right\">$row2[5]</td>
						<td align=\"right\">$row2[6]</td>
						<td align=\"right\">$row2[7]</td>
						<td align=\"right\">$row2[8]</td>
					</tr>
					";
				}
				echo"
				<tr height=\"50px\">
					<td colspan=\"9\">&nbsp;</td>
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