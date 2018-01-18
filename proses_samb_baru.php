<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$nloket="JPR";
$operator=$_SESSION['nama_user'];
#kunci_halaman("ubah_kwm",$secret,$operator);

#simpan BOF
if(isset($_POST['submit'])){
	#echo "simpan-------------";
	$noreg=$_POST['nomor_reg'];
	$nama=$_POST['txnama'];
	$alamat=$_POST['txalamat'];
	$nohp=$_POST['txnohp'];
	$cabang=$_POST['opt_cabang'];
	$ket=$_POST['txket'];

	$sql="
	INSERT INTO humas_kendali_pelanggan(id,nama,alamat,no_hp,cabang,keterangan,petugas)
	VALUES('$noreg','$nama','$alamat','$nohp','$cabang','$ket','$operator');
	";
	$qry=mysql_query($sql)or die(mysql_error());
	if($qry){
		echo"<script type=\"text/javascript\">alert('Data berhasil disimpan !');</script>";
	}
}
#simpan EOF


?>
<tr>
<td>
<br/>
<table width="600px" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.:: Proses Input Sambungan Baru  ::.</b></font></center></td>
            </tr>
<form method="POST" action="">
<tr>
	<td>Nomor Reg.</td>
	<td><input type="text" id="nomor_reg" name="nomor_reg" size="20" required/></td>
</tr>
<tr>
	<td>Nama</td>
	<td><input type="text" name="txnama" id="txnama" size="20" required/></td>
</tr>
<tr>
	<td valign="top">Alamat</td>
	<td><textarea id="txalamat" nama="txalamat" cols="50" rows="3"></textarea></td>
</tr>
<tr>
        <td>No. HP</td>
        <td><input type="text" name="txnohp" id="txnohp" size="20" required/></td>
</tr>
<tr>
	<td>Wil. Cabang</td>
	<td>
		<select name="opt_cabang" id="opt_cabang">
			<option value="01">Jayapura Selatan</option>
			<option value="02">Jayapura Utara</option>
			<option value="03">Abepura</option>
			<option value="04">Waena</option>
			<option value="05">Sentani</option>
			<option value="06">Genyem</option>
		</select>
	</td>
</tr>
<tr>
	<td valign="top">Keterangan</td>
	<td><textarea id="txket" name="txket" cols="65" rows="3"></textarea></td>
</tr>
<tr style="height:50px;">
	<td colspan="2" style="text-align:center;">
		<input type="submit" name="submit" value="Simpan"/>
		<input type="reset" value="Batal"/>
	</td>
</tr>
</form>
<tr>
<td colspan="2">
<center style="color:blue;font-size:120%;">Input nama pelanggan, alamat dan keterangan jangan mengandung tanda petik satu (') ataupun tanda petik dua (").</center>
</td>
</tr>
</table>

</td>
</tr>
<?php
putus();
require_once('foot.php');
?>
