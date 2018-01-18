<?php 
ob_start();
session_start();
require_once("mydb.php");

if(isset($_POST['Simpan'])){
	$kode=strip_tags($_POST['txkode']);
	$ket=strip_tags($_POST['txket']);
	$sql=mysql_query("select * from abnormal where kabnorm='".$kode."' or keterangan='".$ket."'");//validasi data
	if ($row=mysql_fetch_row($sql)){		
		echo"<script language='javascript'>alert('Data dengan KODE dimaksud, sudah ada!');</script>";
	}else{
		$sql=mysql_query("insert into abnormal(kabnorm,keterangan)value('$kode','$ket')");
		if ($sql){
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
				if(frm0.txkode.value.trim().length==0){
					alert('Masukkan KODE Water Meter!');
					frm0.txkode.value="";
					frm0.txkode.focus();
					return false;
				}else if(frm0.txket.value.trim().length==0){
					alert('Masukkan Merk/Nama Water Meter!');
					frm0.txket.value="";
					frm0.txket.focus();
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

		</script>
		<br />
			<div align="center" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>KONDISI WATER METER</b></div>		
			<div class="wrapper">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper1">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>KODE</td>
					<td>:</td>
					<td><input type="text" name="txkode" size="3" maxlength="2" value="" onKeyPress="return isNumb(event);" /></td>
				</tr>
				<tr>
					<td>KETERANGAN</td>
					<td>:</td>
					<td><input type="text" name="txket" size="30" maxlength="30" value="" /></td>
				</tr>
				<tr align="right">
					<td>&nbsp;</td>
					<td></td>
					<td><input type="submit" name="Simpan" value="Simpan" class="button1" />&nbsp;&nbsp;
					<input type="button" value="Hapus" class="button1" />&nbsp;&nbsp;
					<input type="reset" value="Batal" class="button1" />&nbsp;&nbsp;					
					<input type="button" value="Lihat" class="button1" />&nbsp;&nbsp;
					</td>
				</tr>
			</form>
			</table>
			
			</div>			
		</td>
	</tr>
	
<?php
require_once("foot.php");
?>
