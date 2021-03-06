
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Billing System PDAM Jayapura</title>
<link rel="stylesheet" type="text/css" href="style1.css"/>
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

</style>
</head>
<body background="img/grids.gif">

<table width="1000" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
						
				<!-- -->
				
<ul id="menu">
 <!--li><a href="index.php">Home</a></li-->
 
  <li><a href="index.php">File</a>
  <ul class="sub-menu">
   <li><a href="custcredit.php">Informasi Pelanggan</a></li>
   <li><a href="customer.php">Pengisian Pelanggan Baru</a></li>
   <li><a href="#">Isi Pelanggan Kolektif</a></li>
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
   <li><a href="#">Log Out</a></li>
  </ul>
 </li>
 
 <li><a href="#">Proses</a>
  <ul class="sub-menu">
   <li><a href="#">Rute Baca</a></li>
   <li><a href="dsmp.php">Isi/Koreksi Stand Meter</a></li>
   <li><a href="confirm.php">Konfirmasi DSMP</a></li>
   <li><a href="#">Pemasukan Tanggal Denda[Online]</a></li>
   <li><a href="#">Pemasukan Tanggal Denda[Non Online]</a></li>
   <li><a href="proses_rek.php">Proses Pembuatan Rek.</a></li>
   <li><a href="#">Claim Rekening Air</a></li>
   <li><a href="ganti_stand.php">Koreksi Angka Meter</a></li>
   <li><a href="#">Ganti Data Pelanggan</a></li>
   <li><a href="#">Cetak Rekening Non Online</a></li>
   <li><a href="#">Pembayaran Non Online</a></li>
   <li><a href="#">Batal Pembayaran Non Online</a></li>
   <li><a href="#">Cetak Rekening Kolektif</a></li>
   <li><a href="#">Pembayaran Kolektif</a></li>
  </ul>
 </li>
 
 <li><a href="#">Rekening</a>
  <ul class="sub-menu">
   <li><a href="lpp.php">LPP</a></li>
   <li><a href="#">LPP Kolektif</a></li>
   <li><a href="#">Rekap Pendapatan Penerimaan</a></li>
   <li><a href="#">Rekap Pembayaran Rekening</a></li>
   <li><a href="#">Rekap Pembayaran / Wilayah</a></li>
   <li><a href="#">Daftar Saldo Rekening</a></li>
   <li><a href="#">DSR per Pelanggan</a></li>
   <li><a href="drd.php">Daftar Rekening Ditagih[DRD]</a></li>
   <li><a href="#">Infor Rekening</a></li>
  </ul>
 </li>
 
 <li><a href="#">Pelanggan</a>
  <ul class="sub-menu">
   <li><a href="#">Pengaduan Pelanggan</a></li>
   <li><a href="#">Pelanggan Terkena Beban</a></li>
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
   <li><a href="#">Aktifkan Pelanggan</a></li>
  </ul>
 </li>
 
 <li><a href="#">Distribusi</a>
  <ul class="sub-menu">
   <li><a href="#">Pemutusan Sementara</a></li>
   <li><a href="#">Pemutusan krn Pelanggaran</a></li>
   <li><a href="#">Pelaksanaan Pemutusan Fisik</a></li>
   <li><a href="#">Sambung Kembali</a></li>
   <li><a href="#">Lap. Pemutusan</a></li>
   <li><a href="#">Lap. Sambung Kembali</a></li>
  </ul>
 </li>
 
 <li><a href="#">Laporan</a>
  <ul class="sub-menu">
   <li><a href="#">Tunggakan Pelanggan</a></li>
   <li><a href="#">Posisi[Opname] Rekening</a></li>
   <li><a href="#">Efisiensi Komparatif</a></li>
   <li><a href="#">Piutang Pelanggan</a></li>
   <li><a href="#">Pemgumuran Piutang</a></li>
   <li><a href="#">Iktisar Rekening Air[LM-4.2.1]</a></li>
   <li><a href="#">Penerimaan Rekening Air[LM-4.2.2]</a></li>
   <li><a href="#">Efisiensi Penagihan[LM-4.2.3]</a></li>
   <li><a href="#">Posisi Sambungan Pelanggan[LM-4.4.1]</a></li>
   <li><a href="#">Pemutusan dan Penyambungan Kembali[LM-4.4.2]</a></li>
   <li><a href="#">Tunggakan Tahunan</a></li>
  </ul>
 </li>
 <li><a href="#">Utility</a>
  <ul class="sub-menu">
   <li><a href="#">Login User</a></li>
   <li><a href="#">Hak Akses</a></li>
   <li><a href="#"><hr></a></li>
   <li><a href="#">Buka Loket Kembali</a></li>
   <li><a href="#">Cetak Rekening[Online dan Non Online]</a></li>
   <li><a href="#">Transfer ke Loket Extern</a></li>
   <li><a href="#">Ambil dari Loket Extern</a></li>
   <li><a href="#">Isi Tunggakan</a></li>
  </ul>
 </li>
 <li><a href="#">Bantuan</a>
  <ul class="sub-menu">
   <li><a href="#">Manual Book</a></li>
   <li><a href="#">About Me</a></li>
  </ul>
 </li>
</ul>

		
		<!---->
		</td>
	</tr>
	
	<?php
	ini_set('max_execution_time', 0);//unlimited
	ini_set('memory_limit', '512M');
		
	ini_set('query_cache_type', '1');
	ini_set('query_cache_size', '26214400');
	?>