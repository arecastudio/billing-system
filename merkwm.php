<?php 
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();

if(isset($_POST['Simpan'])){
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
}elseif(isset($_POST['hapus'])){
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
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Merk Water Meter</b></font></center>
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
			<table width="400px" align="center" border="0" cellpadding="2" cellspacing="2"><!-- style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded"-->
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
					<table width="100%" align="center" border="1" cellpadding="1" cellspacing="2"  style="border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:13px;background:#ffffee;">
						<tr style="font:calibri;font-size:13px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:center;">
							<td>No</td>
							<td width="50px">Merk</td>
							<td>Nama</td>
							<td>Ctrl</td>
						</tr>
						<?php
						
						$sql="
						SELECT DISTINCT merk,nama
						FROM merk
						ORDER BY merk ASC
						;";
						
						$i=0;
						$qry=mysql_query($sql)or die(mysql_error());
						while($row=mysql_fetch_row($qry)){
							$i++;
							if($i % 2==0){
								echo"<tr>";
							}else{
								echo"<tr style=\"background:#eeeeff;\">";
							}
							echo"
							
								<td align=\"center\">$i</td>
								<td align=\"center\">$row[0]</td>
								<td>$row[1]</td>
								<td align=\"center\"><input type=\"button\" value=\"Pilih\" name=\"ubah".$i."\" onClick=\"ubah('$row[0]','$row[1]');\" /></td>
							</tr>
							";
						}
						
						?>
					</table>
					</div>
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
