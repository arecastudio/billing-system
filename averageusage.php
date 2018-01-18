<?php 
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");
?>

	<tr>
		<td>
		<script type="text/javascript">		
			$(document).ready(function() {
				$("#txnomor").change(function(){
					var nomor = $("#txnomor").val();
					$.ajax({
						url: "choose.php",
						data: "nomor="+nomor,
						cache: false,
						success: function(msg){
							$("#optwilayah").html(msg);
						}
					});
				});
			  
			});
			
			function suvalid(frm0){				
				//alert('ererer');
				if(frm0.txkode.value.trim().length==0){
					alert('Masukkan KODE Cabang!');
					frm0.txkode.value="";
					frm0.txkode.focus();
					return false;
				}else if(frm0.txnama.value.trim().length==0){
					alert('Masukkan Nama Cabang!');
					frm0.txnama.value="";
					frm0.txnama.focus();
					return false;
				}else if(frm0.txkacab.value.trim().length==0){
					alert('Masukkan Nama Kepala Cabang!');
					frm0.txkacab.value="";
					frm0.txkacab.focus();
					return false;
				}else if(frm0.txnik.value.trim().length==0){
					alert('Masukkan NIK Ka. Cabang!');
					frm0.txnik.value="";
					frm0.txnik.focus();
					return false;
				}else{
					return true;
				}
				//alert('ererer');
			}
			
			function validasi(frm){
				if(window.confirm('Yakin untuk simpan data?')==true){
					return true;			
				}else {
					return false;
				}
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
			
			function pilih(nomor){
				location.replace("choose.php?nomor="+nomor);
			}

		</script>
		
			<br/>
			<div class="wrapper">
			
			<table width="600px" border="0" cellpadding="2" cellspacing="2" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
			<form name="f1" method="post" action="" onSubmit="return suvalid(this);">
				<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
				  <td colspan="2"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>Rata-rata Pemakaian Pelanggan Non-Meter</b></font></center></td>
			  </tr>
				<tr>
				  <td colspan="2">&nbsp;</td>
			  </tr>
				<tr>
					<td width="150">Nomor/No Lama</td>					
					<td><input type="text" name="txnomor" id="txnomor" size="10" maxlength="15" value="" onKeyPress="return isNumb(event);" />
						&nbsp;&nbsp;<input type="submit" name="cari" value="Cari" class="kelas_tombol" />					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
			</form>
				<tr>
					<td>&nbsp;</td>
					<td><p style="color:#00f;font-weight:bold;">
					<?php
					if(isset($_POST['cari'])){
						$nmr=$_POST['txnomor'];
						$qry=mysql_query("SELECT DISTINCT m.nomor,m.nolama,m.nama,m.alamat,m.cabang,c.nama,m.kode_wilayah,w.nama_wilayah,m.kode_blok,m.dkd,m.gol,m.kondisi_meter,m.jenis_pel,m.pakai_air_bln 
						FROM master As m
						INNER JOIN cabang AS c ON c.cabang=m.cabang
						LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah AND w.kode_cabang=m.cabang
						WHERE (m.kondisi_meter=3 OR m.kondisi_meter=4) AND (nomor='$nmr' OR nolama='$nmr') LIMIT 0,1;")or die(mysql_error());						
						if($row=mysql_fetch_row($qry)){
							$key0='$row[0]';
							$kwm=kondisi_wm($row[11]);
							echo"
							NOMOR	: $row[0] / $row[1]<br/>
							NAMA	: $row[2]<br/>
							ALAMAT	: $row[3]<br/>
							CABANG	: $row[4] - $row[5]<br/>
							WILAYAH	: $row[6] - $row[7]<br/>
							KONDISI[WM]: $row[11] - $kwm<br/>
							<script>document.getElementById('txnomor').value='$row[0]'</script>
							";
						}else{
							echo"<script type=\"text/javascript\">alert('Data tidak ada (atau) Kondisi WM bukan Non Meter!');</script>";
						}
					}
					?>
					</p></td>
				</tr>
			<form name="f2" method="post" action="" onSubmit="return validasi(this);">
				<tr>
					<td>Rata<sup>2</sup> Pemakaian per-bulan</td>					
					<td><input type="text" name="txangka" size="10" maxlength="9" value="<?php if(isset($_POST['cari'])) echo $row[13];?>" onKeyPress="return isNumb(event);" /></td>
				</tr>
				<tr align="right">
					<td>&nbsp;<input type="hidden" name="hnomor" value="<?php echo $row[0];?>"/></td>					
					<td><input type="submit" name="simpan" value="Simpan" class="kelas_tombol" />&nbsp;&nbsp;
					<input type="reset" value="Batal" class="kelas_tombol" />&nbsp;&nbsp;					</td>
				</tr>
			</form>
			</table>
			<?php
			if(isset($_POST['simpan'])){
				$angka=$_POST['txangka'];
				$nmr=$_POST['hnomor'];
				$pkini=gperiode();
				$row2=0;
				if($angka!=''){
					$qry2=mysql_query("UPDATE master AS m SET m.pakai_air_bln=$angka WHERE m.nomor='$nmr';")or die(mysql_error());
					$qry2=mysql_query("UPDATE dsmp0 AS d SET d.angka=$angka WHERE d.nomor='$nmr' AND d.periode=$pkini;")or die(mysql_error());
					//$row2=mysql_fetch_row($qry2);
					if($qry2)echo"<script type=\"text/javascript\">alert('Tersimpan!');</script>";
				}
			}
			?>
			</div>
			<br />						
		</td>
	</tr>
	
<?php
putus();
require_once("foot.php");
?>
