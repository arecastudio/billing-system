

<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
//====================================================



function cekisi($objs){
	if(strlen(trim($objs))==0){
		return "-";
	}else{
		return $objs;
	}
}

function lnumber(){
	$sql=mysql_query("select max(nomor) as lnum from master");
	while($row=mysql_fetch_row($sql)){
		$luckynumber= intval($row[0])+1;
		$luckynumber=strval($luckynumber);
		if(strlen($luckynumber)==5){$luckynumber ="0".$luckynumber;}
		if(strlen($luckynumber)==4){$luckynumber ="00".$luckynumber;}
		if(strlen($luckynumber)==3){$luckynumber ="000".$luckynumber;}
		if(strlen($luckynumber)==2){$luckynumber ="0000".$luckynumber;}
		if(strlen($luckynumber)==1){$luckynumber ="00000".$luckynumber;}
		if(strlen($luckynumber)==0){$luckynumber ="000000";}
		//echo "Lucky Number: ".$luckynumber;
		return $luckynumber;
	}
}

if (isset($_POST['Simpan'])){
	$nomor=strip_tags($_POST['txnomor']);
	$nolama=strip_tags($_POST['txnolama']);
	$nama=strip_tags($_POST['txnama']);
	$cabang=strip_tags($_POST['optcabang']);
	$wilayah=strip_tags($_POST['optwilayah']);
	$blok=strip_tags($_POST['optblok']);
	$dkd=strip_tags($_POST['optdkd']);
	$alamat=strip_tags($_POST['txalamat']);
	$norumah=strip_tags($_POST['txnorumah']);
	$rt=strip_tags($_POST['txrt']);
	$rw=strip_tags($_POST['txrw']);
	$kpos=strip_tags($_POST['txkpos']);
	$notelp=strip_tags($_POST['txnotelp']);
	$nohp=strip_tags($_POST['txnohp']);
	$noktp=strip_tags($_POST['txnoktp']);
	$nosim=strip_tags($_POST['txnosim']);
	$npwp=strip_tags($_POST['txnpwp']);
	$goltarif=strip_tags($_POST['optgoltarif']);
	$stlalu=strip_tags($_POST['txstlalu']);
	$stkini=strip_tags($_POST['txstkini']);
	$kondisiwm=strip_tags($_POST['optkondisiwm']);
	$merkwm=strip_tags($_POST['optmerkwm']);
	$noseriwm=strip_tags($_POST['txnoseriwm']);
	$diapipa=strip_tags($_POST['optdiapipa']);
	$tpasang=strip_tags($_POST['txtpasang']);
	$tinput=strip_tags($_POST['txtinput']);
	$jnspel=strip_tags($_POST['optjnspel']);
	$online=strip_tags($_POST['optonline']);
	
	//$query=sprintf("insert into master(nomor,nolama,nama)values('$s','$a','$s')",mysql_escape_string($nomor),mysql_escape_string($nolama),mysql_escape_string($nama));
	$sql=mysql_query("select * from master where nomor='".$nomor."' or nolama='".$nolama."'");//validasi data
	if ($row=mysql_fetch_row($sql)){
		//echo"INFO: Data dengan nomor dimaksud, sudah ada!<br />";
		echo"<script language='javascript'>alert('Data dengan nomor dimaksud, sudah ada!');</script>";
		//echo mysql_error();
		//die;
	}else{
		$query="insert into master(NOMOR, NOLAMA, NAMA, ALAMAT, NORUMAH,pakai_air_bln, kode_pos, cabang, kode_cabang, kode_wilayah, kode_blok, DKD, wpt, rt, rw, no_telp, no_hp, no_ktp, no_sim, npwp, GOL, PUTUS, TGLSTART,tgl_input, UKURAN, MERK, NOMETER, kondisi_meter, jenis_pel, online) value('$nomor','$nolama','$nama','$alamat','$norumah',0,'$kpos','$cabang','$cabang','$wilayah','$blok','$dkd','-','$rt','$rw','$notelp','$nohp','$noktp','$nosim','$npwp','$goltarif','0','$tpasang','$tinput','$diapipa','$merkwm','$noseriwm','$kondisiwm','$jnspel','$online')";
		$sql=mysql_query($query);
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


//===================================================
require_once("head.php");
?>
 <!--focus kursor -->
<script type="text/javascript" language="javascript">
	 $(function() {
       // focus on the first text input field in the first field on the page
	   $("#txnolama").focus();
    });
</script> 
<script type="text/javascript">
function setFocus(vnama){
	document.getElementById(vnama).focus();
}

function setalamat(){
	//var alamat=document.getElementById('optdkd').value;
	document.getElementById('txalamat').value=document.getElementById('optdkd').value;
}

//**********************************************************************************************
$(document).ready(function() {
	$('#form1').validate({
		rules: {
			txnomor : {
			//digits: true,
			minlength:6,
			maxlength:6
			},
			txnolama: {
			//indonesianDate:true
			minlength:9,
			maxlength:9
			}
		}
	});
	
	//================
	/*$("#optcabang").change(function(){
		var cabang = $("#optcabang").val();
		$.ajax({
			url: "ambilwil.php",
			data: "cabang1="+cabang,
			cache: false,
			success: function(msg){
				//jika data sukses diambil dari server kita tampilkan
				//di <select id=kota>
				$("#optwilayah").html(msg);
			}
		});
	  });
	  $("#optwilayah").change(function(){
		var wil = $("#optwilayah").val();
		$.ajax({
			url: "ambilblok.php",
			data: "wil2="+wil,
			cache: false,
			success: function(msg){
				$("#optblok").html(msg);
			}
		});
	  });*/
	  
	//================
	
});
</script>

<tr><td><br />
<table width="800" align="center" cellpadding="0" cellpadding="0" border="0">
	<tr>
		<td>
		<!--h3 align="center" class="demoHeaders0">Data Pelanggan Baru</h3-->
		
		<div class="wrapper">
		<form id="frcust" method="post" action="" class="cmxform1">
		<table border="0" align="center" cellpadding="0" cellspacing="2" class="wrapper" bgcolor="#ffffff" width="500px" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px">
		
			<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
			  <td colspan="3"><center><font face="Arial,sans-serif" size="3px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:18px;"><b>Data Pelanggan Baru</b></font></center></td>
		  </tr>
			<tr>
				<td width="130">Nomor Sambungan</td>
				<td>:</td>
				<td>
					<input type="text" size="7" maxlength="6" name="txnomor" id="txnomor" required value="<?php echo lnumber(); ?>" /> &nbsp; Nomor Lama &nbsp; : &nbsp;
					<input type="text" size="15" maxlength="12" name="txnolama" id="txnolama" required />
					<!--input type="button" value="Cari" onClick="" /-->				</td>
			</tr>
			<tr>
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td><input type="text" size="46" maxlength="50" name="txnama" required onkeypress="" /></td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td>:</td>
				<td>
					<select name="optcabang" id="optcabang" required>
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select cabang,nama from cabang where cabang<>'00'");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Wilayah</td>
				<td>:</td>
				<td>
					<select name="optwilayah" id="optwilayah">
						<!--option>--Pilih Wilayah--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("SELECT kode_cabang,kode_wilayah,nama_wilayah FROM master_wilayah where kode_wilayah<>'' ORDER BY kode_wilayah");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_wilayah]\">$p[kode_wilayah] - $p[nama_wilayah]</option>\n";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Blok</td>
				<td>:</td>
				<td>
					<!--select name="optblok" required>
						<option value="" selected="selected">--Pilih--</option>
						<!--?php
						$sql=mysql_query("select kode_blok,ket_blok from master_blok");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select-->
					<select name="optblok" id="optblok">
						<!--option>--Pilih Blok--</option-->
						<?php
						//mengambil nama-nama wilayah yang ada di database
						$wilayah = mysql_query("select * from master_blok order by kode_blok");
						while($p=mysql_fetch_array($wilayah)){
						echo "<option value=\"$p[kode_blok]\">$p[kode_blok] - $p[ket_blok]</option>\n";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>DKD</td>
				<td>:</td>
				<td>
					<select id="optdkd" name="optdkd" onchange="setalamat();" required>
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select dkd,jalan from dkd");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>	
					</select>				</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td><input type="text" size="46" maxlength="50" name="txalamat" required /></td>
			</tr>
			<tr>
				<td>No. Rumah</td>
				<td>:</td>
				<td>
					<input type="text" size="6" maxlength="5" name="txnorumah" />&nbsp;
					RT&nbsp;:&nbsp;<input type="text" size="6" maxlength="5" name="txrt" />
					RW&nbsp;:&nbsp;<input type="text" size="6" maxlength="5" name="txrw" />				</td>
			</tr>
			<tr>
				<td>Kode POS</td>
				<td>:</td>
				<td><input type="text" size="6" maxlength="5" name="txkpos" /></td>
			</tr>
			<tr>
				<td>No. Telp</td>
				<td>:</td>
				<td><input type="text" size="15" maxlength="12" name="txnotelp" />&nbsp;
				No. HP&nbsp;:&nbsp;<input type="text" size="15" maxlength="12" name="txnohp" />				</td>
			</tr>
			<tr>
				<td>No. KTP</td>
				<td>:</td>
				<td><input type="text" size="15" maxlength="20" name="txnoktp" />&nbsp;
				No. SIM&nbsp;:&nbsp;<input type="text" size="15" maxlength="20" name="txnosim" />				</td>
			</tr>
			<tr>
				<td>N.P.W.P</td>
				<td>:</td>
				<td><input type="text" size="25" maxlength="20" name="txnpwp" /></td>
			</tr>
			<tr>
				<td>Gol. Tarif</td>
				<td>:</td>
				<td>
					<select name="optgoltarif" required>
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select distinct gol,keterangan from tarif");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Stand Lalu</td>
				<td>:</td>
				<td><input type="text" size="6" maxlength="10" name="txstlalu" value="0" required />&nbsp;
				Stand Kini&nbsp;:&nbsp;<input type="text" size="6" maxlength="10" name="txstkini" value="0" required />				</td>
			</tr>
			<tr>
				<td>Kondisi W.M.</td>
				<td>:</td>
				<td>
					<select name="optkondisiwm" required>
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select kode_kondisi,ket_kondisi from meter_kondisi");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Merk Water Meter</td>
				<td>:</td>
				<td>
					<select name="optmerkwm">
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select merk,nama from merk");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>No. Seri W.M</td>
				<td>:</td>
				<td><input type="text" size="25" maxlength="20" name="txnoseriwm" /></td>
			</tr>
			<tr>
				<td>Diameter Pipa</td>
				<td>:</td>
				<td>
					<select name="optdiapipa">
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select kode,ukuran from meter");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Tanggal Pasang</td>
				<td>:</td>
				<td><input type="text" size="15" maxlength="20" name="txtpasang" class="datepicker" required  />				</td>
			</tr>
			<tr>
				<td>Tanggal Input</td>
				<td>:</td>
				<td><input type="text" size="15" maxlength="20" readonly name="txtinput" class="datepicker333" value="<?php echo date('Y-m-d');?>" required  />				</td>
			</tr>
			<tr>
				<td>Jenis Pelanggan</td>
				<td>:</td>
				<td>
					<select name="optjnspel" required>
						<!--option value="" selected="selected">--Pilih--</option-->
						<?php
						$sql=mysql_query("select kode_jenis_pel,ket_jenis_pel from pel_jenis");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])." - ".trim($row[1])."</option>";
						}
						?>
					</select>				</td>
			</tr>
			<tr>
				<td>Online</td>
				<td>:</td>
				<td>
					<select name="optonline" required >
						<!--option value="" selected="selected">--Pilih--</option-->
						<option value="YA">YA</option>
						<option value="TIDAK">TIDAK</option>
					</select>				</td>
			</tr>			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">
					<input type="submit" name="Simpan" value="Simpan" class="kelas_tombol" />&nbsp;
					<input type="reset" value="Batal" class="kelas_tombol" />&nbsp;&nbsp;				</td>
			</tr>
		</table>
		</form>	
		
		</div>
		</td>
	</tr>
</table>



</td>
</tr>

<?php
putus();
require_once("foot.php");
?>
