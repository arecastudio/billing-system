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
	$nloket="JPR";
	if(isset($_SESSION['batas'])&& $_SESSION['batas']!=""){
		$batas=$_SESSION['batas'];		
	}
	if(isset($_SESSION['orientasi'])&& $_SESSION['orientasi']!=""){
		$orientasi=$_SESSION['orientasi'];
				
	}
	//$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	//$pdf = new HTML2PDF($orientasi,'A4','en', false, 'ISO-8859-15',array(7, 0, 7, 0));
	
	//$pdf = new HTML2PDF($orientasi,'Letter','en', false, 'ISO-8859-15',array(7, 0, 7, 0));
	
	//$pdf = new HTML2PDF('L', array(95.0,215.9), 'en', false, 'ISO-8859-15', array(7, 4, 6, 0));
	$pdf = new HTML2PDF($orientasi,'A4','en', false, 'ISO-8859-15',array(7, 0, 3, 0));
	$pdf->setDefaultFont('Arial');
	
	$judul="";$sql="";$theader="";$i=0;$j=0;$nmr=0;$re=0;$cetak0="";$cetak1="";$cetak2="";$tfooter="";$ttd="";

	if(isset($_SESSION['judul']))$judul=$_SESSION['judul'];
	if(isset($_SESSION['eskiel']))$sql=$_SESSION['eskiel'];
	if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumfield']))$nmr=$_SESSION['jumfield'];
			//$jmldata=$_SESSION['jumdata'];
	if(isset($_SESSION['alinea']))$alg=$_SESSION['alinea'];
	if(isset($_SESSION['bilang']))$bilang=$_SESSION['bilang'];
	//if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	//if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];
	if(isset($_SESSION['jtotal']))$jtotal=$_SESSION['jtotal'];
	if(isset($_SESSION['bilang']))$bilang=$_SESSION['bilang'];
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
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=80 width=80 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:arial;font-size:19;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		$judul	
		";
		
		
	$footer1="<page_footer>		
		<div style=\"font-size:11px;\">Tgl. cetak: $tanggal</div>
		<div align=\"center\" style=\"font-size:11px;\">
			Halaman: [[page_cu]] / [[page_nb]]
		</div>
	</page_footer>";
	
	$t_open="<table align=\"left\" border=\"1\" style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:13px;width:1024px;\">
			".$theader;
	$t_close="";
	
	//==========================================================
	$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";
	//$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;
	//$cetak8 .= "<page>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">";
	
	$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">".$theader."<br>" ;	
	
	while($row=mysql_fetch_row($qry)){
		$j++;
		$re++;
		//if($re==0||$re>60)$re=1;
		//echo $re." ";
		if($re<=1){
			//$cetak8 .= "<page>";
			//$cetak8 .= "<page><table align=\"center\" width=\"800\" border=\"1\"  style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:10px;\">";
			//$cetak8 .= $theader;
			//re= jml batas record halaman bawah
		}else if($re > $batas){
			$hal++;
			$cetak8 .= "</table>".$footer1."</page><page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font-family:arial;font-size:12px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;
			$re=0;
			//++$hal;
		}
		$cetak8 .="<tr><td align=\"center\">".$j."</td>";
		$cetak8 .="<td align=\"left\">".trim($row[0])."</td>";
		$cetak8 .="<td align=\"left\">".trim($row[1])."</td>";
		$cetak8 .="<td align=\"left\">".trim($row[2])."</td>";
		$cetak8 .="<td align=\"center\">".trim($row[4])."</td>";
		$cetak8 .="<td align=\"center\">".trim($row[15])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[8])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[9])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[10])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[11])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[12])."</td>";
		$cetak8 .="<td align=\"right\">".trim($row[13])."</td>";
		$cetak8 .="<td align=\"right\">".formatMoney(trim($row[14]))."</td>";		
		$cetak8 .="</tr>";
		
	}
	$cetak8 .="<tr><td colspan=\"10\" align=\"right\">Jumlah Yang Harus Dibayar&nbsp;</td><td colspan=\"3\" align=\"right\"><strong>".$jtotal."</strong></td></tr>";
	$cetak8 .="<tr><td colspan=\"2\" align=\"right\">Terbilang&nbsp;</td><td colspan=\"11\" align=\"center\"><i><strong>".$bilang."</strong></i></td></tr>";
		
	if ($tfooter!="")$cetak8.=$tfooter;
	$cetak8 .="</table>".$footer1;
	
	$cetak8 .="<br>
	<table width=800 cellpadding=0 cellspacing=0 style=\"font-size:13px;\">
		<tr>
			<td width=400>
				Telah dibayar lunas dengan:<br>
				<ol>
					<li>SPM No.........................Tgl....................</li>
					<li>Tunai/Loket....................Tgl....................</li>
				</ol>
				<br>
				<u>Catatan:</u>
				Pembayaran melalui SPM, KPKN Pemindahbuktian ke<br>
				Rek. Bank Papua 100-01.08.02724-6<br>
				Rek. Bank Mandiri 154-00-9300180-2
			</td>
			<td width=400 align=center>
				Jayapura, ".date('d-M-Y')."<br>
				Mengetahui,<br>
				Direksi PDAM Jayapura<br><br><br><br><br>
				<u>Abdul M. Petonengan, SE</u><br>
				Direktur
				
			</td>
		</tr>
	</table>
	";
	
	$cetak8 .=$ttd;
	$cetak8 .="</page>";
		
	
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
