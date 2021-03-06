<?php
//ob_start();
//session_start(); 
//simpan
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
<meta name="robots" content="noindex,nofollow"/>
<link href="jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui-1.10.4.custom.js"></script>
<script src="jquery.validate.js"></script>
<script type="text/javascript" src="messages_id.js"></script>

	<script type="text/javascript" src="export/tableExport.js"></script>
	<script type="text/javascript" src="export/jquery.base64.js"></script>
	<script type="text/javascript" src="export/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="export/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="export/jspdf/libs/base64.js"></script>

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

.rounded {
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
	width: 980px;
	margin: auto;
	padding: 0;
	list-style: none;
	background: #00f;
	background: -moz-linear-gradient(#444, #333);
	background: linear-gradient(#fff,#ff0);;
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
	color: #000;
	text-transform: uppercase;
	text-decoration: none;
	text-shadow: 0 1px 0 #000;
}
.menu li:hover > a {
	color: #00f;
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
	top: 34px;
	left: 0;
	z-index: 9999;
	background: #00f;
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
}


.kelas_tombol{
	border-radius:4px;
	cursor:pointer;
	font-size: 14px;
	font-family:Arial;
	font-weight:normal;
	border: 1px solid #d02718;padding: 2px 8px;
	text-shadow:1px 1px 0px #810E05;
	box-shadow:inset 1px 1px 0px 0px #f5978e;
	background:linear-gradient(180deg, #f24537 5%, #c62d1f 100%);
	color:#ffffff;
	display:inline-block;
}



<!--````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````-->

</style>
</head>
<!--body background="img/grids1.gif"-->
<!--body style="background:linear-gradient(#28486e,#fff);width:100%;height:100%;"-->
<!--body style="background:linear-gradient(#003,#fff,#003);width:100%;height:100%;"-->
<body style="background:linear-gradient(#003,#fff,#003)no-repeat center center fixed; 
-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;">

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
				
<ul class="menu">
 <!--li><a href="index.php">Home</a></li-->
<?php
//echo $_SESSION['nama_user'];
$sql="
SELECT lm.file, lm.informasi_pelanggan, lm.pengisian_pelanggan_baru, lm.isi_pelanggan_kolektif, lm.pemakaian_air_non_meter, lm.data_cabang, lm.data_wilayah, lm.daerah_pembacaan, lm.merk_water_meter, lm.kondisi_water_meter,lm.kode_klaim_rekening, lm.tarif_golongan, lm.tarif_meter, lm.biaya_administrasi,lm.piutang_rekening
,lm.proses,lm.isi_koreksi_stand_meter,lm.konfirmasi_dsmp,lm.proses_pembuatan_rek,lm.koreksi_status_angka_meter,lm.ganti_data_pelanggan
,lm.rekening,lm.lpp,lm.rekap_lpp_per_umur_piutang,lm.daftar_sisa_rekening,lm.daftar_rekening_ditagih,lm.efektifitas_penagihan_rek_air,lm.export_lpp_dsr_ke_excel
,lm.utility,lm.login_user,lm.hak_akses,lm.pejabat_staf_pelaporan,lm.cetak_rekening,lm.transfer_ke_loket_extern,lm.ambil_dari_cabang,lm.isi_tunggakan,lm.loket,lm.faktur,
lm.changex,
lm.ubah_nama,
lm.ubah_gol,
lm.ubah_blok,
lm.ubah_stat,
lm.ubah_kwm,
lm.ubah_meter,
lm.ubah_data_pel,
lm.ubah_no_pel,
lm.ubah_data_report,

lm.util_hapus_tung,
lm.util_pelunasan_non_lpp,
lm.util_info_lap_bulan_ti,
lm.util_backup_data,
lm.util_pembatalan_transaksi,
lm.util_rekap_lpp_harian

FROM login_menu AS lm
INNER JOIN login_user AS lu ON AES_DECRYPT(lu.id,$secret)=lm.id
WHERE AES_DECRYPT(lu.nama,$secret)='$nama_user'
;";
$query=mysql_query($sql)or die(mysql_error());
if($row=mysql_fetch_row($query)){
	//if($row[0]==1){
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
		if($row[11]==1)echo"<li><a href=\"tarif_gol.php\">Tarif Golongan</a></li>";
		if($row[12]==1)echo"<li><a href=\"tarif.php\">Tarif Meter</a></li>";
		if($row[13]==1)echo"<li><a href=\"\">Biaya Administrasi</a></li>";
		if($row[14]==1)echo"<li><a href=\"\">Piutang Rekening</a></li>";
		//echo"";
		//echo"";
		//echo"";
		echo"</ul>";
		echo"</li>";
	//}
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
<?php 
   echo"<li><a href=\"#\">Proses</a>";
   echo"<ul class=\"sub-menu\">";
   if($row[16]==1)echo"<li><a href=\"dsmp.php\">Isi/Koreksi Stand Meter</a></li>";
    if($row[17]==1)echo"<li><a href=\"cetakdsmp.php\">Cetak DSMP <i style=\"color:red;\">New</i></a></li>";
   if($row[17]==1)echo"<li><a href=\"confirm.php\">Konfirmasi DSMP</a></li>";
   if($row[18]==1)echo"<li><a href=\"proses_rek.php\">Proses Pembuatan Rek.</a></li>";
   if($row[19]==1)echo"<li><a href=\"ganti_stand.php\">Koreksi Status & Angka Meter Lalu</a></li>";
   
     
   if($row[36]==1)echo"<li><a href=\"loket.php\">Pembayaran Rek. Perorangan</a></li>";
   if($row[36]==1)echo"<li><a href=\"batal.php\">Pembatalan Rek. Perorangan</a></li>";
   if($row[37]==1)echo"<li><a href=\"lokol.php\">Pembayaran Rek. Kolektif</a></li>";
   if($row[37]==1)echo"<li><a href=\"lokol_cetak.php\">Pencetakan Rek. Kolektif</a></li>";
   if($row[37]==1)echo"<li><a href=\"lokol_cetak_desember.php\">Pencetakan Rek. Faktur Akhir Tahun</a></li>";
   if($row[37]==1)echo"<li><a href=\"upp_cetak.php\">Pencetakan Rek. Cabang</a></li>";
   if($row[37]==1)echo"<li><a href=\"loket_briva.php\">Input Pelunasan via BRIVA</a></li>";
   
   if($row[29]==1)echo"<li><a href=\"loket_admin.php\">Pelunasan [Admin]</a></li>";   
   
   echo"</ul>";
   echo"</li>";

   echo"<li><a href=\"#\">Rekening</a>";
   echo"<ul class=\"sub-menu\">";
   if($row[22]==1)echo"<li><a href=\"lpp.php\">LPP</a></li>";
   if($row[23]==1)echo"<li><a href=\"lpp-umr-piut.php\">Rekap LPP per Umur Piutang</a></li>";
   if($row[23]==1)echo"<li><a href=\"lpp_rekap_detail.php\">Rekap LPP per Cabang Detail</a></li>";
   if($row[23]==1)echo"<li><a href=\"lpp_rekap_non_detail.php\">Rekap LPP per Cabang Non Detail</a></li>";
   if($row[23]==1)echo"<li><a href=\"lpp_rekap_harian.php\">Rekap LPP Harian <i style=\"color:red;\">New</i></a></li>";
   if($row[22]==1)echo"<li><a href=\"double_bind.php\">Duplikat Pembayaran <i style=\"color:red;\">New</i></a></li>";
   if($row[23]==1)echo"<li><a href=\"dsr-umr-piut.php\">Rekap DSR per Umur Piutang</a></li>";
   if($row[23]==1)echo"<li><a href=\"dsr_rekap_detail.php\">Rekap DSR per Cabang</a></li>";
   if($row[24]==1)echo"<li><a href=\"dsr.php\">Daftar Sisa Rekening</a></li>";
   if($row[23]==1)echo"<li><a href=\"dsropname.php\">DSR <i style=\"color:red;\">(Opname Rekening)</i></a></li>";
   if($row[25]==1)echo"<li><a href=\"drd.php\">Daftar Rekening Ditagih[DRD]</a></li>";
   if($row[25]==1)echo"<li><a href=\"drd_awal.php\">Daftar Rekening Ditagih[DRD] <i style=\"color:red;\">Awal</i></a></li>";
   if($row[22]==1)echo"<li><a href=\"efek.php\">Efektivitas Penagihan <i style=\"color:red;\">perBLOK</i></a></li>";
   if($row[26]==1)echo"<li><a href=\"efektivitas.php\">Efektifitas Penagihan Rek. Air</a></li>";
   if($row[27]==1)echo"<li><a href=\"export_lpp_to_excel.php\">Export LPP & DSR ke Excel</a></li>";
   echo"</ul>";
   echo"</li>";
   
   echo"<li><a href=\"#\">Pelanggan</a>";
   echo"<ul class=\"sub-menu\">";
   if($row[1]==1)echo"<li><a href=\"surat_peringatan.php\">Surat Peringatan</a></li>";
   if($row[1]==1)echo"<li><a href=\"proses_samb_baru.php\">Proses Sambungan Baru</a></li>";
   if($row[1]==1)echo"<li><a href=\"kendali_samb_baru.php\">Kendali Sambungan Baru</a></li>";
   echo"</ul>";
   echo"</li>";
   
   echo"<li><a href=\"#\">Utility</a>";
   echo"<ul class=\"sub-menu\">";
   if($row[29]==1)echo"<li><a href=\"login_user.php\">Login User</a></li>";
   if($row[30]==1)echo"<li><a href=\"hak_akses.php\">Hak Akses</a></li>";
   if($row[31]==1)echo"<li><a href=\"responsibility.php\">Pejabat & Staf Pelaporan</a></li>";
   //if($row[32]==1)echo"<li><a href=\"#\">Cetak Rekening[Online dan Non Online]</a></li>";
   if($row[33]==1)echo"<li><a href=\"transver_to_upp.php\">Transfer ke Loket Extern</a></li>";
   if($row[34]==1)echo"<li><a href=\"singkron.php\">Ambil dari Cabang [UPP]</a></li>";
   if($row[35]==1)echo"<li><a href=\"koreksi_rekening.php\">Koreksi Rekening</a></li>";
   if($row[35]==1)echo"<li><a href=\"koreksi_rekening_kolektif.php\">Koreksi Rekening Kolektif</a></li>";
   if($row[48]==1)echo"<li><a href=\"koreksi_hapus_tunggakan.php\">Hapus Tunggakan</a></li>";
   if($row[49]==1)echo"<li><a href=\"loket_non_lpp.php\">Pelunasan Non-LPP</a></li>";   
   if($row[50]==1)echo"<li><a href=\"lap_bulanan.php\">Info Laporan Bulanan TI</a></li>"; 
   if($row[51]==1)echo"<li><a href=\"bekap.php\">Backup Data Billing</a></li>"; 
   if($row[52]==1)echo"<li><a href=\"batal_admin.php\">Pembatalan Transaksi Rekening</a></li>";  
    if($row[37]==1)echo"<li><a href=\"report_koreksi.php\">Laporan Koreksi Rekening <i style=\"color:red;\">New</i></a></li>";  
     
	
	 
   echo"</ul>";
   echo"</li>";

    echo"<li><a href=\"#\">Change</a>";//changex row 38
    echo"<ul class=\"sub-menu\">";
	//row[20]=lm.ganti_data_pelanggan
   if($row[39]==1)echo"<li><a href=\"ubah_nama.php\">## Balik Nama [Ganti Nama Pelanggan]</a></li>";
   if($row[40]==1)echo"<li><a href=\"ubah_gol.php\">## Ubah Gol. Tarif Pelanggan</a></li>";
   if($row[41]==1)echo"<li><a href=\"ubah_blok.php\">## Ubah Kode Blok Pelanggan</a></li>";
   if($row[42]==1)echo"<li><a href=\"ubah_stat_pel.php\">## Ubah Status Pelanggan</a></li>";
   if($row[42]==1)echo"<li><a href=\"hapus_pel.php\">## Hapus Pelanggan / Pengunduran Diri</a></li>";
   if($row[43]==1)echo"<li><a href=\"ubah_kwm.php\">## Ubah Kondisi Meter Pelanggan (KWM)</a></li>";
   if($row[44]==1)echo"<li><a href=\"ubah_meter.php\">## Ubah Meter (Meterisasi)</a></li>";
   if($row[45]==1)echo"<li><a href=\"customer_edit.php\">## Ganti Data Pelanggan</a></li>";
   if($row[46]==1)echo"<li><a href=\"ubah_nomor.php\">## Ubah Nomor (ID) Pelanggan</a></li>";
   if($row[47]==1)echo"<li><a href=\"report_change2.php\">## Report Perubahan Data</a></li>";
   if($row[47]==1)echo"<li><a href=\"laporan_hapus_pel.php\">## Report Penghapusan Pelanggan</a></li>";
   echo"</ul>";
   echo"</li>";
?>
 
 <li><a href="#">Bantuan</a>
  <ul class="sub-menu">
   <li><a href="manual.php">Manual Book</a></li>
   <li><a href="#">About Me</a></li>
  </ul>
 </li>
 <li><a href="index.php?aksi=tutup">Log Out <small style="color:#f00;font-family:calibri;font-size:12px;">[<?php echo $_SESSION['nama_user'];echo "@".$_SESSION['nama_komputer'];?>]</small></a></li>
</ul>

		<?php
        //echo $_SESSION['nama_user'];
		?>
		<!---->
		</td>
	</tr>
	
