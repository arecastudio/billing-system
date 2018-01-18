<?php 
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();

if(isset($_POST['Simpan777'])){
	$kode=strip_tags($_POST['txkode']);
	$nama=strip_tags($_POST['txnama']);
	//$sql=mysql_query("select * from merk where merk='".$kode."' or nama='".$nama."'");//validasi data
	//if ($row=mysql_fetch_row($sql)){		
	//	echo"<script language='javascript'>alert('Data dengan KODE dimaksud, sudah ada!');</script>";
	//}else{
		$sql=mysql_query("insert into merk(merk,nama)value('$kode','$nama') on duplicate key update merk='$kode',nama='$nama';");
		if ($sql){
			//echo"Data berhasil disimpan";		
			echo"<script language='javascript'>alert('Data berhasil disimpan!');</script>";
			//header ('Location:customer.php');				
		}else{
			echo "<b style=\"color:yellow;\">Gagal simpan data</b><br />";
			echo "<b style=\"color:yellow;\">".mysql_error()."</b>";	
		}
	//}
}elseif(isset($_POST['hapus777'])){
	$kode=strip_tags($_POST['txkode']);
	$nama=strip_tags($_POST['txnama']);
	if($kode<>""){
		mysql_query("delete from merk where merk='$kode'")or die(mysql_error());
		echo "<script language='javascript'>alert('Data Meter [$kode - $nama] berhasil dihapus!');</script>";
	}
}

require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">		
			function suvalid(frm0){				
				//alert('ererer');
				if(frm0.txkode.value.trim().length==0){
					alert('Masukkan KODE Water Meter!');
					frm0.txkode.value="";
					frm0.txkode.focus();
					return false;
				}else if(frm0.txnama.value.trim().length==0){
					alert('Masukkan Merk/Nama Water Meter!');
					frm0.txnama.value="";
					frm0.txnama.focus();
					return false;
				}else{
					return true;
				}
				//alert('ererer');
			}
			
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
			
			function ubah(kode,nama){
				document.getElementById("txkode").value=kode;
				document.getElementById("txnama").value=nama;
			}

		</script>
		<br />
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Tarif Rekening per Golongan</b></font></center>
			<div class="wrapper">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper1">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>KODE</td>
					<td>:</td>
					<td><input type="text" name="txkode" id="txkode" size="3" maxlength="2" value="" onKeyPress="return isNumb(event);" /></td>
				</tr>
				<tr>
					<td>NAMA</td>
					<td>:</td>
					<td><input type="text" name="txnama" id="txnama" size="30" maxlength="30" value="" /></td>
				</tr>
				<tr align="right">
					<td>&nbsp;</td>
					<td></td>
					<td><input type="submit" name="Simpan" value="Simpan" class="button1" />&nbsp;&nbsp;					
					<input type="reset" value="Batal" class="button1" />&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" name="hapus" value="Hapus" class="kelas_tombol" />
					</td>
				</tr>
			</form>
			</table>			
			</div>
			
			<!--br /-->
			<table width="950px" align="center" border="0" cellpadding="2" cellspacing="2"><!-- style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded"-->
			<tr>
				<td width="100%" align="center">
					<div style="height:420px;overflow:auto">
					<table width="100%" align="center" border="1" cellpadding="1" cellspacing="2"  style="border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:9px;background:#ffffee;">
						<tr style="font:calibri;font-size:10px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:center;">
							<td>No</td>							
							<td>Tgl SK</td>
							<td>Nomor</td>
							<td>Prd</td>
							<td>Gol</td>
							<td>Keterangan</td>
							<td>Trf<br/>1</td>
							<td>Trf<br/>2</td>
							<td>Trf<br/>3</td>
							<td>Trf<br/>4</td>
							<td>Trf<br/>5</td>
							<td>Smp<br/>1</td>
							<td>Smp<br/>2</td>
							<td>Smp<br/>3</td>
							<td>Smp<br/>4</td>
							<td>Jns<br/>Dnd</td>
							<td>Dnd<br/>1</td>
							<td>Dnd<br/>2</td>
							<td>Dnd<br/>3</td>
							<td>Min<br/>[M<sup>3</sup>]</td>
							
							<td>Ctrl</td>
						</tr>
						<?php
						
						$sql="
						SELECT DISTINCT tgl_sk, no_sk, gol, keterangan, tarip1, tarip2, tarip3, tarip4, tarip5, 
						sampai1, sampai2, sampai3, sampai4, jenis_denda, denda1, denda2, denda3, negatif, positif, turun, naik, 
						minimum, adm, meter, biaya_sb, uang_jaminan, pendaftaran, balik_nama, ganti_wm, tabul, periode, persen, 
						jenis, nama_user, tgl_input, kriteria_khusus, prosen_flat, harga_air, status_penyisihan
						FROM tarif
						ORDER BY gol ASC,periode DESC
						;";
						
						$i=0;$gol0=0;$tebal="normal";$pakai=0;
						$qry=mysql_query($sql)or die(mysql_error());
						while($row=mysql_fetch_row($qry)){
							$i++;
							
							$tebal="normal";$pakai=0;
							if($gol0!=trim($row[2])){$tebal="bold";$pakai=1;}
							$gol0=$row[2];
							
							if($i % 2==0){
								if($pakai==1){
								//	echo"<tr style=\"background:#ffffbb;text-align:right;\">";
									echo"<tr height=\"50px\"  style=\"background:#ffffee;text-align:right;\">";
								}else{
									echo"<tr style=\"background:#ffffee;text-align:right;\">";
								}
							}else{
								if($pakai==1){
								//	echo"<tr style=\"background:#bbbbff;text-align:right;\">";
									echo"<tr height=\"50px\" style=\"background:#eeeeff;text-align:right;\">";
								}else{
									echo"<tr style=\"background:#eeeeff;text-align:right;\">";
								}
							}
							
							echo"							
								<td align=\"center\">$i</td>
								<td align=\"center\">$row[0]</td>
								<td align=\"center\">$row[1]</td>
								<td style=\"color:red;font-weight:$tebal;text-align:center;\">$row[30]</td>
								<td style=\"color:blue;font-weight:$tebal;text-align:center;\">$row[2]</td>
								<td align=\"left\">$row[3]</td>
								<td>".number_format($row[4],0)."</td>
								<td>".number_format($row[5],0)."</td>
								<td>".number_format($row[6],0)."</td>
								<td>".number_format($row[7],0)."</td>
								<td>$row[8]</td>
								<td>$row[9]</td>
								<td>$row[10]</td>
								<td>$row[11]</td>								
								<td>$row[12]</td>								
								<td align=\"center\">$row[13]</td>
								<td>".number_format($row[14],0)."</td>
								<td>".number_format($row[15],0)."</td>
								<td>".number_format($row[16],0)."</td>
								<td align=\"center\">$row[21]</td>								
							";
							if($pakai==1)echo"<td align=\"center\"><input type=\"button\" value=\"Pilih\" name=\"ubah".$i."\" onClick=\"ubah('$row[2]','$row[30]');\" /></td>";
							echo"</tr>";
						}
						
						?>
					</table>					
					</div>
					<marquee style="color:#ccff00;font-style:italic;font-face:arial;font-size:12px;background:#000000;">Catatan:&nbsp;&nbsp;Tarif yang sedang dipakai ditandai dengan tinggi baris yang lebih besar dan tulisan tebal pada kolom tertentu.</marquee>
				</td>
			</tr>
			</table>
			<!---->
			
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
