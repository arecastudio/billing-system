<?php
require_once("mydb.php");
sambung();
//ob_flush();
//set_time_limit(24000);
require_once("global_functions.php");

//deklarasi bof
$nom="";
$nom="";
$nomla="";
$nama="";
$dkd="";
$alamat="";
$norumah="";
$rt="";
$rw="";
$kpos="";
$cabang="";
//deklarasi eof

if(isset($_POST['cari'])){
	$nomor=trim($_POST['txnomor']);
	$nolama=trim($_POST['txnolama']);
	$query="select m.nomor,m.nolama,m.nama,m.dkd,d.jalan,m.alamat,m.norumah,m.rt,m.rw,m.kode_pos,m.cabang,c.nama,m.kode_wilayah,w.nama_wilayah from master as m,dkd as d,cabang as c,master_wilayah as w where m.kode_wilayah=w.kode_wilayah and c.cabang=m.cabang and m.dkd=d.dkd and m.nomor='$nomor' or m.nolama='$nolama'";
	$sql=mysql_query($query) or die(mysql_error());
	if($row=mysql_fetch_row($sql)){
		$nom=trim($row[0]);
		$nomla=trim($row[1]);
		$nama=trim($row[2]);
		$dkd=trim($row[3])."-".trim($row[4]);
		$alamat=trim($row[5]);
		$norumah=trim($row[6]);
		$rt=trim($row[7]);
		$rw=trim($row[8]);
		$kpos=trim($row[9]);
		$cabang=trim($row[10])."-".trim($row[11]);
		$wilayah=trim($row[12])."-".trim($row[13]);
	}
}

require_once("head.php");
?>

<script	type="text/javascript">
	function isNumb(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode				
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}
		return true;
	}
	
	function ulang(){
		
		//if(isset($_POST['cari'])){unset($_POST['cari']);}
		window.location.href='custcredit.php';
		document.getElementById("txnomor").value="";
		document.getElementById("txnolama").value="";
		document.getElementById("txnomor").focus();
	}
</script>

	<tr>
		<td>
		<!--########################################################################################-->
		<table width="600px" border="0" cellpadding="0" cellspacing="0" align="center" background="img/grids.gif">
			<tr align="center" bgcolor="white">
				<td width="50%"><a href="custcredit.php">TUNGGAKAN PELANGGAN</a></td>
				<td width="50%"><a href="custinfo.php">CETAK DATA MASTER PELANGGAN</a></td>
			</tr>			
		</table>
		<div align="center" style="padding:2px 0;text-shadow:4px -4px 2px red;color:#ff0;font-size:19px;"><b>TUNGGAKAN PELANGGAN</b></div>		
		<div class="wrapper">		
		<table border="0" align="center" cellpadding="0" cellspacing="4" class="wrapper1" bgcolor="#fff" width="450px" background="img/grids.gif">
			<form id="frcari" method="post" action="">
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td><input type="text" name="txnomor" size="7px" value="<?php echo $nom;?>" maxlength="6" onKeyPress="return isNumb(event);">
				&nbsp;No. Lama&nbsp;:&nbsp;<input type="text" name="txnolama" size="12px" value="<?php echo $nomla;?>" maxlength="10" onKeyPress="return isNumb(event);">&nbsp;
				<input type="submit" name="cari" value="Cari">&nbsp;<input type="button" value="Batal" onClick="window.location.href='custcredit.php';">
				</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td><input type="text" name="txnama" value="<?php echo $nama;?>" size="30px" disabled></td>
			</tr>
			<tr>
				<td>DKD/ Kd. Jln</td>
				<td>:</td>
				<td><input type="text" name="tx" value="<?php echo $dkd;?>" size="35px" disabled></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td><input type="text" name="tx" value="<?php echo $alamat;?>" size="40px" disabled></td>
			</tr>
			<tr>
				<td>No. Rumah</td>
				<td>:</td>
				<td><input type="text" name="tx" value="<?php echo $norumah;?>" size="5px" disabled>&nbsp;
				RT&nbsp;:&nbsp;<input type="text" name="tx" value="<?php echo $rt;?>" size="5px" disabled>&nbsp;
				RW&nbsp;:&nbsp;<input type="text" name="tx" value="<?php echo $rw;?>" size="5px" disabled>&nbsp;
				KPos&nbsp;:&nbsp;<input type="text" name="tx" value="<?php echo $kpos;?>" size="5px" disabled>
				</td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td>:</td>
				<td><input type="text" name="tx" value="<?php echo $cabang;?>" size="20px" disabled></td>
			</tr>
			<tr>
				<td>Wilayah</td>
				<td>:</td>
				<td><input type="text" name="tx" value="<?php echo $wilayah;?>" size="20px" disabled></td>
			</tr>
			<tr>
				<td>Blok</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="4px" disabled></td>
			</tr>
			<tr>
				<td>Golongan</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="20px" disabled></td>
			</tr>
			<tr>
				<td>Merk WM</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="15px" disabled>&nbsp;
				No. Seri WM &nbsp;:&nbsp;<input type="text" name="tx" value="" size="10px" disabled>
				</td>
			</tr>
			<tr>
				<td>Diameter Pipa</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="15px" disabled></td>
			</tr>
			<tr>
				<td>Jenis Pelanggan</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="15px" disabled></td>
			</tr>
			<tr>
				<td>Status Putus</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="2px" disabled></td>
			</tr>
			<tr>
				<td>Tgl. Pasang</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="20px" disabled></td>
			</tr>
			<tr>
				<td>Jml. Tunggakan</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="4px" disabled>&nbsp;(Lembar yang belum di-bayar)</td>
			</tr>
			<tr>
				<td>Piutang</td>
				<td>:</td>
				<td><input type="text" name="tx" value="" size="20px" disabled></td>
			</tr>
			</form>
		</table>
		</div>
		<!--########################################################################################-->
		</td>
	</tr>
	
<?php
if(isset($_POST['cari'])){unset($_POST['cari']);}
putus();
require_once("foot.php");
?>