<?php 
require_once("head.php");
?>

	<tr>
		<td>
		
		<script type="text/javascript"> 
		function validasi_input(form){
			if (form.txkode.value.trim().length == 0){ 
				alert("KODE masih kosong!"); 
				form.txkode.value="";
				form.txkode.focus(); 
				return (false); 
			}else if(form.txnama.value.trim().length == 0){
				alert("NAMA/MERK masih kosong!"); 
				form.txnama.value="";
				form.txnama.focus(); 
				return (false); 
			} return (true); 
		}
		</script>
<!--form method="post" action="aksi.php" onsubmit="return validasi_input(this)"> <p>Username: <input name="username" 

type="text"></p> <p><input name="" type="submit" value="Submit"></p> </form-->

			<center><font face="Arial,sans-serif" size="3px"><b>Merk Water Meter</b></font></center>
			<div class="wrapper0">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper11">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return validasi_input(this);">
				<tr>
					<td>KODE</td>
					<td>:</td>
					<td><input type="text" name="txkode" size="3" maxlength="2" value="" /></td>
				</tr>
				<tr>
					<td>NAMA</td>
					<td>:</td>
					<td><input type="text" name="txnama" size="30" maxlength="30" value="" /></td>
				</tr>
				<tr align="right">
					<td>&nbsp;</td>
					<td></td>
					<td><input type="submit" value="Simpan" class="button1" />&nbsp;&nbsp;
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
