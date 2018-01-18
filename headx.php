<?php
//ob_start();
//session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Billing Perusahaan Daerah Air Minum Jayapura - Papua</title>
<!--link rel="stylesheet" type="text/css" href="style1.css"/-->
<link rel="shortcut icon" href="favicon1.ico" type="image/x-icon"/>

<link href="jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui-1.10.4.custom.js"></script>
<script src="jquery.validate.js"></script>
<script type="text/javascript" src="messages_id.js"></script>
<script>
$(function() {
$( ".datepicker" ).datepicker({
   changeMonth: true,
   changeYear: true,
   //showOn:"button"
  });
  
  $( ".datepicker" ).datepicker({ altFormat: 'yy-mm-dd' });
  $( ".datepicker" ).change(function() {
  	$( ".datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd" );
  });
  
  $( ".button" ).button();	 
  
});
</script>

<style>
body {
	/*background: #f0f0f0;*/
	font-size: 0.8em;
}

.entrian{
		font: 60.5% "Trebuchet MS", sans-serif;
		//margin: 2px;
	}
	
.demoHeaders {
		margin-top: 2em;
	}

.error {
	background-color: #FFD9D9;
	border: 1px solid #F00;
	color:red;
}

.wrapper1 {
font: 60.5% "Trebuchet MS", sans-serif;
-moz-box-shadow: 0 0 15px #999;
-webkit-box-shadow: 0 0 15px #999;
-o-box-shadow: 0 0 15px #999;
box-shadow: 0 0 15px #999;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
-o-border-radius: 15px;
border-radius: 15px;
-moz-border: 3px solid #009900;
-webkit-border: 3px solid #009900;
-o-border: 3px solid #009900;
border: 3px solid #009900;
}

<!--````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````-->
.utama {
	width: 50%;
	margin: 50px 25%;
}
.bersih  {
	clear: both;
}
h1, p {
	text-align: justify;
}
a, a:hover, a:link, a:active {
	color: #000;
	display: block;
	text-decoration: none;
}

.menu {
	width: 780px;
	margin: auto;
	padding: 0;
	list-style: none;
	background: #00F;
	background: -moz-linear-gradient(#444, #333);
	background: linear-gradient(#ff0, #fff);
	border-radius: 10px;
	box-shadow: 0 2px 1px #9c9c9c;
	transition: 1s ease-in-out;
	-moz-transition: 1s ease-in-out;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:15px;
}
.menu li {
	float: left;
	padding: 0;
	position: relative;
}
.menu a {
	float: left;
	padding: 10px 20px 7px 20px;
	color: #999;
	text-transform: uppercase;
	text-decoration: none;
	text-shadow: 0 1px 0 #F00;
	
}
.menu li:hover > a {
	color: #00F;
}
.menu li:hover > ul {
	display: block;
}
.menu:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
}


.menu ul {
	list-style: none;
	margin: 0;
	padding: 0;
	display: none;
	position: absolute;
	top: 35px;
	left: 0;
	z-index: 9999;
	background: #00F;
	background: -moz-linear-gradient(#444, #333);
	background: linear-gradient(#ff0, #fff);
	border-radius: 10px;
	box-shadow: 0 2px 1px #9c9c9c;
}
.menu ul li {
	float: none;
	margin: 0;
	padding: 0;
	display: block;
	box-shadow: 0 1px 0 #111, 0 2px 0 #777;
}
.menu ul a {
	padding: 10px;
	height: auto;
	display: block;
	white-space: nowrap;
	float: none;
	text-transform: none;
}



.menu ul a:hover {
	background: #0186ba;
	background: -moz-linear-gradient(#04acec, #0186ba);
	background: linear-gradient(#04acec, #0186ba);
}
.menu ul li:first-child a {
	border-radius: 5px 5px 0 0;
}
.menu ul li:first-child a:after {
	content: " ";
	position: absolute;
	left: 30px;
	top: -8px;
	width: 0;
	height: 0;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: 8px solid #333;
}
.menu ul li:first-child a:hover:after {
	border-bottom-color: #04acec;
}
.menu ul li:last-child {
	box-shadow: none;
}
.menu ul li:last-child a {
	border-radius: 0 0 5px 5px;
}/*
.container {
 	width: 100%;
 	height: 100%;
 	/*text-align: center;/* IE fix to center the page */
 	/*background: url(bg.jpg) repeat-x 0 0;*/
	/*background: linear-gradient(#09f, #ccf);
	position: relative;
}*/
<!--````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````-->

</style>
</head>
	<body style="background: url(bg.jpg) repeat-x 0 0;;width:100%;height:100%;">
	<?php
		
	ini_set('max_execution_time', 0);//unlimited
	ini_set('memory_limit', '512M');
		
	ini_set('query_cache_type', '1');
	ini_set('query_cache_size', '26214400');
	
	date_default_timezone_set('Asia/Jayapura');
	
	if(!isset($_SESSION['login'])||$_SESSION['login']!='buka'){
		$_SESSION['login']="tutup";
		header("location: index.php");
	}else if(isset($_SESSION['login'])&& $_SESSION['login']='buka'){
		$nama_user=$_SESSION['nama_user'];
	}
	?>

<table width="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
						
				<!-- -->
				
<ul class="menu" >
 <!--li><a href="index.php">Home</a></li-->
<?php
//echo $_SESSION['nama_user'];
$sql="
SELECT lm.file, lm.informasi_pelanggan, lm.pengisian_pelanggan_baru, lm.isi_pelanggan_kolektif, lm.pemakaian_air_non_meter, lm.data_cabang, lm.data_wilayah, lm.daerah_pembacaan, lm.merk_water_meter, lm.kondisi_water_meter,lm.kode_klaim_rekening, lm.tarif_golongan, lm.tarif_meter, lm.biaya_administrasi,lm.piutang_rekening
FROM login_menu AS lm
INNER JOIN login_user AS lu ON lu.id=lm.id
WHERE lu.nama='$nama_user'
;";
$query=mysql_query($sql)or die(mysql_error());
if($row=mysql_fetch_row($query)){
	if($row[0]==1){
		echo"<li><a href=\"index0.php\">File</a>";
		echo"<ul class=\"sub-menu\">";		
		if($row[1]==1)echo"<li><a href=\"custcredit.php\">Informasi Pelanggan</a></li>";
		if($row[2]==1)echo"<li><a href=\"customer.php\">Pengisian Pelanggan Baru</a></li>";
		if($row[3]==1)echo"<li><a href=\"pel_kolektif.php\">Isi Pelanggan Kolektif</a></li>";
		if($row[4]==1)echo"<li><a href=\"averageusage.php\">Pemakaian Air[Non Meter]</a></li>";
		if($row[5]==1)echo"<li><a href=\"branch.php\">Data Cabang</a></li>";
		if($row[6]==1)echo"<li><a href=\"area.php\">Data Wilayah</a></li>";
		if($row[7]==1)echo"<li><a href=\"readarea.php\">Daerah Pembacaan[DKD]</a></li>";
		if($row[8]==1)echo"<li><a href=\"merkwm.php\">Merk Water Meter</a></li>";
		if($row[9]==1)echo"<li><a href=\"kondisiwm.php\">Kondisi Water Meter</a></li>";
		if($row[10]==1)echo"<li><a href=\"claim.php\">Kode Klaim Rekening</a></li>";
		if($row[11]==1)echo"<li><a href=\"tarif.php\">Tarif Golongan</a></li>";
		if($row[12]==1)echo"<li><a href=\"\">Tarif Meter</a></li>";
		if($row[13]==1)echo"<li><a href=\"\">Biaya Administrasi</a></li>";
		if($row[14]==1)echo"<li><a href=\"\">Piutang Rekening</a></li>";
		//echo"";
		//echo"";
		//echo"";
		echo"</ul>";
		echo"</li>";
	}
}
?> 
  <!--li><a href="index0.php">File</a>
  <ul class="sub-menu">
   <li><a href="custcredit.php">Informasi Pelanggan</a></li>
   <li><a href="customer.php">Pengisian Pelanggan Baru</a></li>
   <li><a href="pel_kolektif.php">Isi Pelanggan Kolektif</a></li>
   <li><a href="averageusage.php">Pemakaian Air[Non Meter]</a></li>
   <li><a href="branch.php">Data Cabang</a></li>
   <li><a href="area.php">Data Wilayah</a></li>
   <li><a href="readarea.php">Daerah Pembacaan[DKD]</a></li>
   <li><a href="merkwm.php">Merk Water Meter</a></li>
   <li><a href="kondisiwm.php">Kondisi Water Meter</a></li>
   <li><a href="claim.php">Kode Klaim Rekening</a></li>
   <li><a href="tarif.php">Tarif Golongan</a></li>
   <li><a href="#">Tarif Meter</a></li>
   <li><a href="#">Biaya Administrasi</a></li>
   <li><a href="#">Piutang Rekening</a></li>
  </ul>
 </li-->
 
 <li><a href="#">Proses</a>
  <ul class="sub-menu">
   <!--li><a href="#">Rute Baca</a></li-->
   <li><a href="dsmp.php">Isi/Koreksi Stand Meter</a></li>
   <li><a href="confirm.php">Konfirmasi DSMP</a></li>
   <!--li><a href="#">Pemasukan Tanggal Denda[Online]</a></li>
   <li><a href="#">Pemasukan Tanggal Denda[Non Online]</a></li-->
   <li><a href="proses_rek.php">Proses Pembuatan Rek.</a></li>
   <!--li><a href="#">Claim Rekening Air</a></li-->
   <li><a href="ganti_stand.php">Koreksi Angka Meter</a></li>
   <li><a href="customer_edit.php">Ganti Data Pelanggan</a></li>
   <!--li><a href="#">Cetak Rekening Non Online</a></li>
   <li><a href="#">Pembayaran Non Online</a></li>
   <li><a href="#">Batal Pembayaran Non Online</a></li>
   <li><a href="kolektif_cetak.php">Cetak Rekening Kolektif</a></li>
   <li><a href="kolektif_bayar.php">Pembayaran Kolektif</a></li-->
  </ul>
 </li>
 
 <li><a href="#">Rekening</a>
  <ul class="sub-menu">
   <li><a href="lpp.php">LPP</a></li>
   <!--li><a href="#">LPP Kolektif</a></li-->
   <!--li><a href="lpp-rekap.php">Rekap LPP [Umum]</a></li-->
   <li><a href="lpp-umr-piut.php">Rekap LPP per Umur Piutang</a></li>
   <li><a href="dsr-umr-piut.php">Rekap DSR per Umur Piutang</a></li>
   <li><a href="dsr.php">Daftar Sisa Rekening</a></li>
   <!--li><a href="#">Rekap Pembayaran / Wilayah</a></li>   
   <li><a href="#">DSR per Pelanggan</a></li-->
   <li><a href="drd.php">Daftar Rekening Ditagih[DRD]</a></li>
   <!--li><a href="#">Infor Rekening</a></li-->
   <li><a href="efektivitas.php">Efektifitas Penagihan Rek. Air</a></li>
   <li><a href="export_lpp_to_excel.php">Export LPP & DSR ke Excel</a></li>
  </ul>
 </li>
 
 <li><!--a href="#">Pelanggan</a-->
  <ul class="sub-menu">
   <li><a href="#">Pengaduan Pelanggan</a></li>
   <!--li><a href="#">Pelanggan Terkena Beban</a></li>
   <li><a href="#">Lap. Pelanggan Terkena Beban</a></li>
   <li><a href="#">Pilih Pelanggan TPS</a></li>
   <li><a href="#">Surat Peringatan</a></li>
   <li><a href="#">Lap. Claim Rekening</a></li>
   <li><a href="#">Lap. Ganti Golongan</a></li>
   <li><a href="#">Lap. Ganti Nama</a></li>
   <li><a href="#">Lap. Ganti Meter[Water Meter]</a></li>
   <li><a href="#">Daftar Pemakaian Air</a></li>
   <li><a href="#">Daftar Stand Meter Langganan[DSML]</a></li>
   <li><a href="#">Tutup Pelanggan</a></li>
   <li><a href="#">Aktifkan Pelanggan</a></li-->
  </ul>
 </li>
 
 <li><a href="#">Distribusi</a>
  <ul class="sub-menu">
   <li><a href="#">Pemutusan Sementara</a></li>
   <!--li><a href="#">Pemutusan krn Pelanggaran</a></li>
   <li><a href="#">Pelaksanaan Pemutusan Fisik</a></li>
   <li><a href="#">Sambung Kembali</a></li>
   <li><a href="#">Lap. Pemutusan</a></li>
   <li><a href="#">Lap. Sambung Kembali</a></li-->
  </ul>
 </li>
 
 <li><!--a href="#">Laporan</a-->
  <ul class="sub-menu">
   <!--li><a href="#">Tunggakan Pelanggan</a></li>
   <li><a href="#">Posisi[Opname] Rekening</a></li>
   <li><a href="#">Efisiensi Komparatif</a></li>
   <li><a href="#">Piutang Pelanggan</a></li>
   <li><a href="#">Pemgumuran Piutang</a></li>
   <li><a href="#">Iktisar Rekening Air[LM-4.2.1]</a></li>
   <li><a href="#">Penerimaan Rekening Air[LM-4.2.2]</a></li>
   <li><a href="#">Efisiensi Penagihan[LM-4.2.3]</a></li>
   <li><a href="#">Posisi Sambungan Pelanggan[LM-4.4.1]</a></li>
   <li><a href="#">Pemutusan dan Penyambungan Kembali[LM-4.4.2]</a></li>
   <li><a href="#">Tunggakan Tahunan</a></li-->
  </ul>
 </li>
 <li><a href="#">Utility</a>
  <ul class="sub-menu">
   <li><a href="#">Login User</a></li>
   <li><a href="#">Hak Akses</a></li>
   <!--li><a href="#">Buka Loket Kembali</a></li-->
   <li><a href="#">Cetak Rekening[Online dan Non Online]</a></li>
   <li><a href="#">Transfer ke Loket Extern</a></li>
   <li><a href="#">Ambil dari Loket Extern</a></li>
   <li><a href="koreksi_rekening.php">Isi Tunggakan</a></li>
  </ul>
 </li>
 <li><a href="#">Bantuan</a>
  <ul class="sub-menu">
   <li><a href="#">Manual Book</a></li>
   <li><a href="#">About Me</a></li>
  </ul>
 </li>
 <li><a href="index.php?aksi=tutup">Log Out</a></li>
</ul>

		<?php
        //echo $_SESSION['nama_user'];
		?>
		<!---->
		</td>
	</tr>
	
