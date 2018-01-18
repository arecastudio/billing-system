<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
//ob_flush();
//set_time_limit(24000);
require_once("global_functions.php");
require_once("head.php");

$ope=$_SESSION['nama_user'];
$lok="KOR";
$tgl=date('Y-m-d');
$jam=date('H:i:s');

kunci_halaman("util_hapus_tung",$secret,$ope);

//echo"<script language='javascript'>alert('Data berhasil disimpan!');</script>";
if(isset($_POST['hapus'])){	
	$sql="
	insert ignore into rekening1_hapus(nomor,nolama,nama,cabang,kode_wilayah,kode_blok,dkd,gol,periode,standlalu,standkini,pakai,loket,tbayar,uangair,adm,meter,denda,meterai,total,status_bayar,periode_tarif,periode_meterai)
	select r.nomor,r.nolama,r.nama,r.cabang,r.kode_wilayah,r.kode_blok,r.dkd,r.gol,r.periode,r.standlalu,r.standkini,r.pakai,r.loket,r.tbayar,r.uangair,r.adm,r.meter,r.denda,r.meterai,r.total,r.status_bayar,r.periode_tarif,r.periode_meterai from rekening1 as r where r.nomor='".$_POST['txnomor']."' and r.status_bayar=0 and (r.periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	$sql="
	update rekening1_hapus set tgl_hapus='$tgl',op_hapus='$ope',jam_hapus='$jam'
	where nomor='".$_POST['txnomor']."' and status_bayar=0 and (periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	$sql="
	delete from rekening1 where nomor='".$_POST['txnomor']."' and status_bayar=0 and (periode between ".$_POST['p1']." and ".$_POST['p2'].")
	;";
	$qry=mysql_query($sql)or die(mysql_error());
	
	echo"<script language='javascript'>alert('Data berhasil dihapus!');</script>";
}

require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">					
			function checkKey(){
				if (window.event.keyCode == 13){
					alert("you hit return!");
				}
			}
			
			function isNumb(evt){
				var charCode = (evt.which) ? evt.which : event.keyCode				
				if (charCode > 31 && (charCode < 48 || charCode > 57)){
					return false;
				}
				return true;
			}
		</script>
		<br />
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:15px;"><b>Penghapusan Tunggakan Rek. Pelanggan [Koreksi]</b></font></center>
			<div class="wrapper5">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper1" style="font-size:15px;font-family:courier;">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>Periode Rek.</td>
					<td>
						<input type="text" size="8px" id="p1" name="p1" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:13px;font-family:courier;color:#0f0;background:#000;" />s/d
						<input type="text" size="8px" id="p2" name="p2" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:13px;font-family:courier;color:#0f0;background:#000;" />
					</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>
						<input type="text" size="15px" id="txnomor" name="txnomor" maxlength="6" onKeyPress="return isNumb(event);" style="font-size:15px;font-family:courier;color:#0f0;background:#000;" />
					</td>
				</tr>
				<tr align="right">				
					<td colspan="2">
						<input type="submit" name="hapus" value="Hapus" class="kelas_tombol" />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<a href="custcredit.php" style="font-size:11px;color:#00f;font-family:verdana;">Klik disini untuk Cek Tunggakan Pelanggan</a>
					</td>
				</tr>
			</form>
			</table>
			
			</div>
			
			<br />						
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
