<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

if(isset($_POST['Simpan'])){
	$wil=strip_tags($_POST['optwil']);
	$dkd=strip_tags($_POST['txdkd']);
	$jalan=strip_tags($_POST['txjalan']);
	$tgl=strip_tags($_POST['opttgl']);
	$loket=strip_tags($_POST['optloket']);
	$sql=mysql_query("select * from dkd where dkd='$dkd'");//validasi data
	//if ($row=mysql_fetch_row($sql)){		
		//echo"<script language='javascript'>alert('Data dengan KODE DKD dimaksud, sudah ada!');</script>";
	//}else{
		$sql1=mysql_query("insert into dkd(rayon,kode_wilayah,dkd,jalan,tgl,loket)values((select distinct kode_cabang from master_wilayah where kode_wilayah='$wil' limit 1),'$wil','$dkd','$jalan','$tgl','$loket') on duplicate key update jalan='$jalan',tgl='$tgl',loket='$loket',kode_wilayah='$wil',rayon=(select distinct kode_cabang from master_wilayah where kode_wilayah='$wil' limit 1);");
		if ($sql1){
			//echo"Data berhasil disimpan";		
			echo"<script language='javascript'>alert('Data berhasil disimpan!');</script>";
			//header ('Location:customer.php');				
		}else{
			echo "<b style=\"color:yellow;\">Gagal simpan data</b><br />";
			echo "<b style=\"color:yellow;\">".mysql_error()."</b>";		
		}
	//}
}elseif(isset($_POST['hapus'])){
	$dkd=strip_tags($_POST['txdkd']);
	$jalan=strip_tags($_POST['txjalan']);
	if($dkd<>""){
		mysql_query("delete from dkd where dkd='$dkd'")or die(mysql_error());
		echo "<script language='javascript'>alert('Data DKD [$dkd - $jalan] berhasil dihapus!');</script>";
	}
}

require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">		
			function suvalid(frm0){				
				//alert('ererer');
				if(frm0.optwil.value.trim().length==0){
					alert('Pilih Wilayah!');
					frm0.optwil.value="";
					frm0.optwil.focus();
					return false;
				}else if(frm0.txdkd.value.trim().length==0){
					alert('Masukkan Kode DKD!');
					frm0.txdkd.value="";
					frm0.txdkd.focus();
					return false;
				}else if(frm0.txjalan.value.trim().length==0){
					alert('Masukkan Nama Jalan!');
					frm0.txjalan.value="";
					frm0.txjalan.focus();
					return false;
				}else if(frm0.opttgl.value.trim().length==0){
					alert('Pilih Tanggal Pencatatan!');
					frm0.opttgl.value="";
					frm0.opttgl.focus();
					return false;
				}else if(frm0.optloket.value.trim().length==0){
					alert('Pilih Loket Pembayaran!');
					frm0.optloket.value="";
					frm0.optloket.focus();
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
		
			function cari(){
				var kode=document.getElementById("txdkd").value;
				
			}
			
			function ubah(cbg,dkd,jln,tgl,lkt){
				document.getElementById("optwil").value=cbg;
				document.getElementById("txdkd").value=dkd;
				document.getElementById("txjalan").value=jln;
				document.getElementById("opttgl").value=tgl;
				document.getElementById("optloket").value=lkt;
			}
		
		</script>
		<br />
			<center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Daerah Pembacaan [DKD]</b></font></center>
			<div class="wrapper">
			
			<table width="400px" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" align="center" class="wrapper1">
			<form id="frmerkwm" name="frmerkwm" method="post" action="" onSubmit="return suvalid(this);">
				<tr>
					<td>Wilayah</td>
					<td>:</td>
					<td>
						<select name="optwil" id="optwil" onChange="cabang(optwil.value)" required>
							<option value="" selected="selected">--Pilih--</option>
							<?php
							$sql=mysql_query("select kode_wilayah,nama_wilayah from master_wilayah order by kode_wilayah");
							while($row=mysql_fetch_row($sql)){
								echo"<option value=".trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td>DKD</td>
					<td>:</td>
					<td><input type="text" name="txdkd" id="txdkd" size="5" maxlength="4" value="" onKeyPress="return isNumb(event);" required /></td>
				</tr>
				<tr>
					<td>Nama Jalan</td>
					<td>:</td>
					<td><input type="text" name="txjalan" id="txjalan" size="43" maxlength="100" value="" required /></td>
				</tr>
				<tr>
					<td>Tgl Pencatatan</td>
					<td>:</td>
					<td>
						<select name="opttgl" id="opttgl"  required>
							<option value="" selected="selected">-Tgl-</option>
							<script type="text/javascript">
								var i;
								for (i=1;i<=30;i++){
									document.write("<option value="+i+">"+i+"</option>");
								}
							</script>
						</select>
					</td>
				</tr>
				<tr>
					<td>Loket Pembayaran</td>
					<td>:</td>
					<td>
						<select name="optloket" id="optloket"  required>
							<option value="" selected="selected">--Pilih--</option>
							<option value="I">Internal/Dalam PDAM</option>
							<option value="X">External/Luar PDAM</option>
						</select>
					</td>
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
			<table width="600px" align="center" border="0" cellpadding="2" cellspacing="2"><!-- style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded"-->
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
					<table width="100%" align="center" border="1" cellpadding="1" cellspacing="2"  style="border-collapse:collapse;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:13px;background:#ffffee;">
						<tr style="font:calibri;font-size:13px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);text-align:center;">
							<td>No</td>
							<td width="50px">DKD</td>
							<td>Jalan</td>
							<td>Cbg</td>
							<td>Wil</td>
							<td>Tgl</td>
							<td>Lkt</td>
							<td>Ctrl</td>
						</tr>
						<?php
						
						$sql="
						SELECT DISTINCT dkd,jalan,rayon,kode_wilayah,tgl,loket
						FROM dkd
						ORDER BY dkd ASC
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
								<td align=\"center\">$row[2]</td>
								<td align=\"center\">$row[3]</td>
								<td align=\"center\">$row[4]</td>
								<td align=\"center\">$row[5]</td>
								<td align=\"center\"><input type=\"button\" value=\"Pilih\" name=\"ubah".$i."\" onClick=\"ubah('$row[3]','$row[0]','$row[1]','$row[4]','$row[5]');\" /></td>
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
