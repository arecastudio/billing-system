<?php 
ob_start();
session_start();
require_once("mydb.php");
sambung();

if(isset($_GET['kode'])){
	$kd1=$_GET['kode'];
	$qry=mysql_query("delete from master_wilayah where kode_wilayah=".$kd1);
	header("location:area.php");	
}

if(isset($_POST['Simpan'])){
	$cabang=strip_tags($_POST['optcabang']);
	$kode=strip_tags($_POST['txkode']);
	$nama=strip_tags($_POST['txnama']);	
	$sql=mysql_query("select * from master_wilayah where kode_wilayah='$kode' or nama_wilayah='$nama'");//validasi data
	if ($row=mysql_fetch_row($sql)){		
		$sql=mysql_query("update master_wilayah set nama_wilayah='$nama',kode_cabang='$cabang' where kode_wilayah='$kode'	") or die(mysql_error());
		if ($sql){
			//echo"Data berhasil disimpan";		
			echo"<script language='javascript'>alert('Data berhasil di-ubah!');</script>";
			//header ('Location:customer.php');				
		}else{
			echo"Gagal ubah data<br />";
			echo mysql_error();		
		}
	}else{
		$sql1=mysql_query("insert into master_wilayah(kode_cabang,kode_wilayah,nama_wilayah)value('$cabang','$kode','$nama')");
		if ($sql1){
			//echo"Data berhasil disimpan";		
			echo"<script language='javascript'>alert('Data berhasil disimpan!');</script>";
			//header ('Location:customer.php');				
		}else{
			echo"Gagal simpan data<br />";
			echo mysql_error();		
		}
	}
}

require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">		
			function suvalid(frm0){				
				//alert('ererer');
				if(frm0.optcabang.value.trim().length==0){
					alert('Masukkan KODE Water Meter!');
					frm0.optcabang.value="";
					frm0.optcabang.focus();
					return false;
				}else if(frm0.txkode.value.trim().length==0){
					alert('Masukkan Merk/Nama Water Meter!');
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
			
			function ubah(cb,kd,nm){
				document.getElementById("optcabang").value=cb;
				document.getElementById("txkode").value=kd;
				document.getElementById("txnama").value=nm;
			}
			
			function hapus(kd){
				if (confirm("Yakin untuk hapus?\n Kode Data:"+kd)) {
					document.location = "area.php?kode="+kd;
				}
			}

		</script>
		<br />
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Data Wilayah</b></font></center>
			<div class="wrapper">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" align="center"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>Cabang</td>
					<td>:</td>
					<td>
						<select name="optcabang" id="optcabang" onChange="cabang(optcabang.value)" required>
							<option value="" selected="selected">--Pilih--</option>
							<?php
							$sql=mysql_query("select cabang,nama from cabang order by cabang");
							while($row=mysql_fetch_row($sql)){
								echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Kode Wilayah</td>
					<td>:</td>
					<td><input type="text" name="txkode" id="txkode" size="3" maxlength="2" value="" onKeyPress="return isNumb(event);" /></td>
				</tr>
				<tr>
					<td>Nama Wilayah</td>
					<td>:</td>
					<td><input type="text" name="txnama" id="txnama" size="30" maxlength="30" value="" /></td>
				</tr>
				<tr align="right">
					<td>&nbsp;</td>
					<td></td>
					<td><input type="submit" name="Simpan" value="Simpan" class="button1" />&nbsp;&nbsp;
					<input type="reset" value="Batal" class="button1" />&nbsp;&nbsp;
					</td>
				</tr>
			</form>
			</table>
			<br />
			<table width="500px" border="1" cellpadding="2" cellspacing="2" align="center" class="wrapper" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
				<tr bgcolor="#000" style="font-size:14px;color:#FFFFFF">
					<td align="center">No.</td><td align="center">Cabang</td><td align="center">Kd Wil</td><td>Nama</td><td align="center">Kontrol</td>
				</tr>
				<?php
				$i=0;$row=0;$qry="";$sql="";
				$sql="select kode_cabang,kode_wilayah,nama_wilayah from master_wilayah order by kode_cabang,kode_wilayah";				
				$qry=mysql_query($sql) or die(mysql_error());
				if($qry){
				while($row=mysql_fetch_array($qry)){
					$i++;
					echo"<tr>";
					echo"<td align=center>$i</td>";
					echo"<td align=center>".trim($row[0])."&nbsp;</td>";
					echo"<td align=center>".trim($row[1])."&nbsp;</td>";
					echo"<td>".trim($row[2])."&nbsp;</td>";
					//echo"<td align=center>".trim($row[3])."&nbsp;</td>";					
					echo"<td align=center><input type=\"button\" name=\"btedit".$i."\" value=\"Edit\" onClick=\"ubah('".trim($row[0])."','".trim($row[1])."','".trim($row[2])."');\">&nbsp;<input type=\"button\" value=\"Hapus\" name=\"bthapus".$i."\" onClick=\"hapus('".trim($row[1])."');\"><input type=\"hidden\" name=$row[0] value=$row[0]></td>";
					echo"</tr>";
					//echo"<input type=\"button\" value=\"klik".$row[2]."\" name=\"k1".$row[2]."\" onclick=\"alert('".$row[2]."');\" />";
				}
				}				
				?>
			</table>
			
			</div>
			<br />						
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
