<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
?>

<style>
.kelas_tombol1{
	border-radius:4px;
	cursor:pointer;
	font-size: 14px;
	font-family:Arial;
	font-weight:normal;
	border: 1px solid #d02718;padding: 2px 8px;
	text-shadow:1px 1px 0px #810E05;
	box-shadow:inset 1px 1px 0px 0px #f5978e;
	background:linear-gradient(180deg, #f24537 5%, #c62d1f 100%);
	color:#ffffff;
	display:inline-block;
}
</style>

<?php
$info="";
$kokol=$_GET['nomor'];
if(trim($kokol)!=''){	
	//
	if(isset($_POST['simpan'])){
		$sql_save="
		INSERT IGNORE INTO pel_kolektif_d(kode_kolektif,nomor)
		VALUES('".$kokol."','".trim($_POST['txnomor'])."')		
		;";
		mysql_query($sql_save)or die(mysql_error());
	}
	//	
	$eskiel="
	SELECT DISTINCT ket_kolektif,alamat_kolektif,kode_cabang,kode_wilayah,kode_blok,dkd,penanggung_jawab,telp
	FROM pel_kolektif
	WHERE kode_kolektif='$kokol'
	LIMIT 1
	";
	
	$query=mysql_query($eskiel)or die(mysql_error());
	if($brs=mysql_fetch_row($query)){
		$dapat=true;
		$ket=trim($brs[0]);
		$alm=trim($brs[1]);
		
		$cbg=trim($brs[2]);
		$wil=trim($brs[3]);
		$blk=trim($brs[4]);
		$dkd=trim($brs[5]);
		
		$pjw=trim($brs[6]);
		$tlp=trim($brs[7]);		
	}
	
	
	$lqs="
	SELECT DISTINCT nomor
	FROM pel_kolektif_d
	WHERE kode_kolektif='$kokol'
	;";
	$qy=mysql_query($lqs)or die(mysql_error());
	while($rw=mysql_fetch_row($qy)){
		$nmr=$rw[0];
		if(isset($_POST[$nmr])){
			//echo"hapus $nmr pada $kokol";
			mysql_query("DELETE FROM pel_kolektif_d WHERE kode_kolektif='$kokol' AND nomor='$nmr';")or die(mysql_error());
		}
	}
}
?>
<html>
<head>
<title>Collective Member Entry</title>
</head>
<body>
<table style="font-family:calibri;" width="750px">
	<form id="f1" name="f1" action="" method="post">
    <tr style="background:#eee;font-size:18px;font-weight:bold;">
    	<td colspan="2"><?php echo"$kokol - $ket - $alm";?><br/>Input Nomor</td>
    </tr>
    <tr>
    	<td width="150px"><input type="radio" id="r1" name="acuan" value="nomor" checked />Nomor</td>
        <td><input type="text" id="tx1" name="txnomor" size="7pe" maxlength="6" onKeyPress="return isNumb(event);" /></td>
    </tr>    
    <tr>
    	<td colspan="2">
        <input type="submit" name="simpan" value="Tambahkan" class="kelas_tombol1" />&nbsp;
        <input type="reset" name="batal" value="Batal" class="kelas_tombol1" />
        </td>
    </tr>
    </form>
    <tr>
    	<td colspan="2">
        	<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            	<tr style="background:linear-gradient(#ddd,#666);color:#fff;">
                	<th width="3px">No.</th>
                    <th>Nomor</th>
                    <th>NoLama</th>
                    <th>Nama</th>
                    <th>Alamat</th>
					<th>Control</th>
                </tr>
                <form name="f2" id="f2" method="post" action="">
				<?php
				$kokol=$_GET['nomor'];//ORDER BY m.nolama ASC
                if(trim($kokol)!=''){
					$sql="
					SELECT p.nomor,m.nolama,m.nama,m.alamat
					FROM pel_kolektif_d AS p
					LEFT OUTER JOIN master AS m ON m.nomor=p.nomor
					WHERE p.kode_kolektif='$kokol'
					ORDER BY m.nolama ASC
					;";
					
					//echo"<script type=\"text/javascript\">opener.location=window.opener.document.URL;</script>";
					
					$qry=mysql_query($sql)or die(mysql_error());
					$i=0;
					//echo"<input type=\"hidden\" id=\"hnomor\" name=\"hnomor\" value=\"\" />";
					while($row=mysql_fetch_row($qry)){
						$i++;
						if($i%2==0){
							$wrn="#ccf";
						}else{
							$wrn="#ffc";
						}
						echo"
						<tr style=\"background:$wrn;\">
							<td align=\"center\">$i</td>
							<td style=\"color:#505;cursor:pointer;\" ><u>$row[0]</u></td>							
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>							
							<td align=\"center\"><input type=\"submit\" name=\"$row[0]\" id=\"$row[0]\" value=\"Hapus\" class=\"kelas_tombol1\" ></td>
						</tr>
						";
					}
				}
				echo "<script type=\"text/javascript\">document.getElementById('tx1').focus();</script>";
				?>
                </form>
            </table>        
        </td>
    </tr>
</table>
</body>
</html>
<?php
putus();
?>