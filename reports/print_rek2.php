<?php
	session_start();
	require_once("../mydb.php");	
	sambung();
	require_once("../html2pdf/html2pdf.class.php");
	//ini_set('max_execution_time', 300); //300 seconds = 5 minutes	
	ini_set('max_execution_time', 0);//unlimited
	//ini_set('memory_limit', '512M');
	ini_set('memory_limit', '-1');
	
	ini_set('query_cache_type', '1');
	ini_set('query_cache_size', '26214400');
	
	date_default_timezone_set('Asia/Jayapura');
	$tanggal=date('d-M-Y [H:i:s]',time());
	//require_once("../global_functions.php");
	//requier_once("print_class.php");
	//error_reporting(0);
	$orientasi='P';
	$batas=45;
	$nloket=$_SESSION['nama_komputer'];
	if($nloket=="192.168.0.40")$nloket="JPR";
	if($nloket=="192.168.0.12")$nloket="JPR";
	if(isset($_SESSION['batas'])&& $_SESSION['batas']!=""){
		$batas=$_SESSION['batas'];		
	}
	if(isset($_SESSION['orientasi'])&& $_SESSION['orientasi']!=""){
		$orientasi=$_SESSION['orientasi'];
				
	}
	//$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	//$pdf = new HTML2PDF($orientasi,'A4','en', false, 'ISO-8859-15',array(7, 0, 7, 0));
	
	//$pdf = new HTML2PDF($orientasi,'Letter','en', false, 'ISO-8859-15',array(7, 0, 7, 0));
	
	$pdf = new HTML2PDF('L', array(95.0,215.9), 'en', false, 'ISO-8859-15', array(7, 4, 6, 0));
	
	$pdf->setDefaultFont('Arial');
	
	$judul="";$sql="";$theader="";$i=0;$j=0;$nmr=0;$re=0;$cetak0="";$cetak1="";$cetak2="";$tfooter="";$ttd="";

	if(isset($_SESSION['judul']))$judul=$_SESSION['judul'];
	if(isset($_SESSION['eskiel']))$sql=$_SESSION['eskiel'];
	//if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumfield']))$nmr=$_SESSION['jumfield'];
			//$jmldata=$_SESSION['jumdata'];
	if(isset($_SESSION['bilang']))$bilang=$_SESSION['bilang'];
	//if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	//if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function formatMoney($number, $fractional=false) {
	if ($fractional) {
		$number = sprintf('%.2f', $number);
	}
	while (true) {
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number) {
			$number = $replaced;
		} else {
			break;
		}
	}
	return $number;
}

function konversi($x){  
	$x = abs($x);
	$angka = array ("","Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";  
	if($x < 12){
		$temp = " ".$angka[$x];
	}else if($x<20){
		$temp = konversi($x - 10)." Belas";
	}else if ($x<100){
		$temp = konversi($x/10)." Puluh". konversi($x%10);
	}else if($x<200){
		$temp = " Seratus".konversi($x-100);
	}else if($x<1000){
		$temp = konversi($x/100)." Ratus".konversi($x%100);   
	}else if($x<2000){
		$temp = " Seribu".konversi($x-1000);
	}else if($x<1000000){
		$temp = konversi($x/1000)." Ribu".konversi($x%1000);   
	}else if($x<1000000000){
		$temp = konversi($x/1000000)." Juta".konversi($x%1000000);
	}else if($x<1000000000000){
		$temp = konversi($x/1000000000)." Milyar".konversi($x%1000000000);
	}  
	return $temp;
}	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$header1="";$footer1="";$t_open="";$t_close="";$cetak8="";$hal=1;
	
	$header1="		
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=60 width=60 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:arial;font-size:13;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		<div style=\"text-align:center;font-weight:bold;font-family:calibri;font-size:12px;\">TANDA TERIMA PEMBAYARAN REKENING AIR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copy Rekening</div>";
		
		
	$footer1="<page_footer>		
		<div style=\"font-size:11px;\">Tgl. cetak: $tanggal</div>
		<div align=\"center\" style=\"font-size:11px;\">
			Halaman: [[page_cu]] / [[page_nb]]
		</div>
	</page_footer>";
	
	$t_open="<table align=\"left\" border=\"1\" style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:10px;width:1024px;\">
			".$theader;
	$t_close="";
	
	//==========================================================
	$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";
	//$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;
	//$cetak8 .= "<page>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">";
	
	while($row=mysql_fetch_row($qry)){
		$cetak8 .= "<page>".$header1;
		$cetak8.="<table align=\"left\" border=\"0\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:calibri;font-size:11px;border-spacing:2px;padding:2px;width:1024px;\">";
		//$cetak8.="";
		$cetak8.="<tr>";		
		$cetak8.="<td >Nama</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td width=\"220\" style=\"font-size:11px;font-weight:bold;\">$row[2]</td>";
		$cetak8.="<td>Rekening Bulan</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td width=\"100\" style=\"font-size:13px;font-weight:bold;\">$row[15]</td>";
		$cetak8.="<td>Nama</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[2]</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Nomor Pelanggan</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:18px;font-weight:bold;\">$row[0] / $row[1]</td>";
		$cetak8.="<td>Tanggal Cetak</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>".date('Y-M-d')."</td>";
		$cetak8.="<td>Nomor Pelanggan</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:13px;font-weight:bold;\">$row[0] / $row[1]</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Alamat</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[3]</td>";
		$cetak8.="<td>Jam Cetak</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>".date('H:i:s')."</td>";
		$cetak8.="<td>Alamat</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[3]</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>Harga Air</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[9]</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Golongan Tarif</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[4] - $row[5]</td>";
		$cetak8.="<td>Administrasi</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[10]</td>";
		$cetak8.="<td>Golongan Tarif</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[4]</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>Dana Meter</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[11]</td>";
		$cetak8.="<td>Rekening Bulan</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:16px;\">$row[15]</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Meter Awal</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:13px;\">$row[6]</td>";
		$cetak8.="<td>Meterai</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[13]</td>";
		$cetak8.="<td>Tanggal Cetak</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>".date('Y-M-d')."</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Meter Akhir</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:13px;\">$row[7]</td>";
		$cetak8.="<td>Denda</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[12]</td>";
		$cetak8.="<td><b>Jam Cetak</b></td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td><b>".date('H:i:s')."</b></td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Jumlah Pemakaian</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:13px;\">$row[8] M<sup>3</sup></td>";
		$cetak8.="<td style=\"font-weight:bold;\">Total Rp.</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td style=\"font-size:14px;\"><b>".formatMoney($row[14])."</b></td>";
		$cetak8.="<td>Jumlah Pemakaian</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>$row[8] M<sup>3</sup></td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>Jumlah Tagihan (Rp)</td>";
		$cetak8.="<td>:&nbsp;</td>";
		$cetak8.="<td style=\"font-size:14px;font-weight:bold;\" ><b>".formatMoney($row[14])."</b></td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		//$cetak8.="<td>Jumlah Pemakaian</td>";
		//$cetak8.="<td>:</td>";
		//$cetak8.="<td>$row[8]</td>";
		//$cetak8.="<td style=\"font-weight:bold;\">Total Rp.</td>";
		//$cetak8.="<td>:</td>";
		//$cetak8.="<td><b>$row[14]</b></td>";
		$cetak8.="<td colspan=\"6\" align=\"center\" style=\"background:#eee;\"><b><i>".konversi($row[14])."Rupiah</i></b></td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";		
		$cetak8.="</tr>";
		
		
		$cetak8.="<tr>";		
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td colspan=\"3\">Terimakasih sudah membayar kewajiban anda<br>Bukti Pembayaran ini SAH jika suah dibubuhi Cap PDAM</td>";
		//$cetak8.="<td>&nbsp;</td>";
		//$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td colspan=\"3\" align=\"center\"><u>HINDARI HIV / AIDS</u></td>";
		//$cetak8.="<td>&nbsp;</td>";
		//$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>Loket Bayar</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>".$nloket."</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="<tr>";		
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>Petugas Loket</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td>".$_SESSION['nama_user']."</td>";		
		$cetak8.="</tr>";
		
		
		$cetak8.="<tr>";		
		$cetak8.="<td>Loket Bayar</td>";
		$cetak8.="<td>:</td>";
		$cetak8.="<td colspan=\"4\">".$nloket."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Petugas Loket : ".$_SESSION['nama_user']."</td>";
		//$cetak8.="<td>Petugas Loket</td>";
		//$cetak8.="<td>:</td>";
		//$cetak8.="<td>".$_SESSION['nama_user']."</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";
		$cetak8.="<td>&nbsp;</td>";		
		$cetak8.="</tr>";
		
		$cetak8.="</table>";
		//$cetak8 .= "</page><page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;					
		$cetak8 .= "</page>";
	}
	//if ($tfooter!="")$cetak8.=$tfooter;
	//$cetak8 .="</table>".$footer1;
	//$cetak8 .=$ttd;
	//$cetak8 .="</page>";
	
	
	//if($re<60)$cetak8 = "</table></page>";$re=0;
	//=========================================================
	
	/*$cetak8 .="<page><page_footer>
		<table align=\"center\" class=\"page_footer\">
			<tr>
				<td style=\"width: 100%; text-align: right\">
					Hal [[page_cu]]/[[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer></page>";*/

	
	$pdf->WriteHTML($cetak8);	
	$pdf->Output("cetak_laporan.pdf","I");
	//echo $cetak8;
	
	
	
	/*$_SESSION['judul']="";
	$_SESSION['eskiel']="";
	$_SESSION['theader']="";
	$_SESSION['jumfield']=0;
	//$_SESSION['jumdata'];
	$_SESSION['alinea']="";*/
	
	$_SESSION['tfooter']="";
	$_SESSION['orientasi']="";
	$_SESSION['batas']="";
	$_SESSION['ttd']="";
	
	putus();
?> 