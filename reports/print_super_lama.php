<?php
	session_start();
	require_once("../mydb.php");
	//require_once("file:///D|/xampp/htdocs/billing/global_functions.php");
	//sambung();
	require_once("../html2pdf/html2pdf.class.php");
	//ini_set('max_execution_time', 300); //300 seconds = 5 minutes	
	ini_set('max_execution_time', 0);//unlimited
	//ini_set('memory_limit', '512M');
	ini_set('memory_limit', '-1');
	
	ini_set('query_cache_type', '1');
	ini_set('query_cache_size', '26214400');
	
	date_default_timezone_set('Asia/Jayapura');
	$tanggal=date('d-M-Y [H:i:s]',time());
	
	setlocale(LC_MONETARY,"en_US");
	
	//requier_once("print_class.php");
	//error_reporting(0);
	
	//$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(12, 0, 7, 0));
	$pdf->setDefaultFont('Arial');
	
	$judul="";$sql="";$theader="";$i=0;$j=0;$nmr=0;$re=0;$cetak0="";$cetak1="";$cetak2="";$tfooter="";$ttd="";
	
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
	
	if(isset($_SESSION['nomor']))$nomor=$_SESSION['nomor'];
	if(isset($_SESSION['nama']))$nama=$_SESSION['nama'];
	if(isset($_SESSION['alamat']))$alamat=$_SESSION['alamat'];
	if(isset($_SESSION['total']))$total=$_SESSION['total'];
	
	if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumdata']))$jdata=$_SESSION['jumdata'];
	if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];
	if(isset($_SESSION['ttd_nama']))$ttd_nama=$_SESSION['ttd_nama'];
	if(isset($_SESSION['ttd_jabatan']))$ttd_jab=$_SESSION['ttd_jabatan'];

	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$header1="";$footer1="";$t_open="";$t_close="";$cetak8="";$hal=1;
	
	$header1="		
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=80 width=80 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:arial;font-size:19;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		";
		
		
	$footer1="<page_footer>		
		<div style=\"font-size:11px;\">Tgl. cetak: $tanggal</div>
		<div align=\"left\" style=\"font-size:11px;\">
			Oleh: ".$_SESSION['nama_user']."
		</div><br><br><br><br>
	</page_footer>";
		
	//==========================================================
	//$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";$jab="";$lks="";
	$pakai=0;$uangair=0;$adm=0;$meter=0;$denda=0;$meterai=0;//$total=0;
	$t_pakai=0;$t_uangair=0;$t_adm=0;$t_meter=0;$t_denda=0;$t_meterai=0;$t_total=0;
	$i=0;$nopel="";$j=0;$k=0;$sbg=0;
	
	if($ttd=="YOHAN WANGGAI, SE"){
		$jab="Manager Humas";
		$lks="
		<br>
		Dari data tersebut diatas, kami mohon untuk segera diselesaikan / konfirmasi ke  <b>Kantor</b><br>
		<b>Perusahaan Daerah Air Minum Jl. Baru Kelapa Dua Entrop  Bagian HUMAS</b> setiap hari kerja,<br>
		apabila dalam jangka waktu 7 (tujuh) hari setelah tanggal pengiriman surat ini belum juga diselesaikan,<br>
		maka dengan sangat terpaksa kami mengambil	tindakan pemutusan sambungan / penyegelan tanpa <br>pemberitahuan.
		<br><br>
		
		Demikian harapan kami untuk dapat dimaklumi, atas perhatiannya kami sampaikan terima<br>
		kasih
		";
	}else{
		$jab="Kepala UPP Jayapura";
		$lks="
		<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dari data tersebut diatas, kami mohon untuk segera diselesaikan / konfirmasi ke  <b>Kantor</b><br>
		<b>Perusahaan Daerah Air Minum (PDAM Upp.Jayapura) Jl. Baru Kelapa Dua Entrop (Seksi<br>Pelayanan Langganan)</b>
		setiap hari kerja, apabila dalam jangka waktu 7 (tujuh) hari setelah tanggal<br>
		pengiriman surat ini belum juga diselesaikan, maka dengan sangat terpaksa kami mengambil<br>
		tindakan pemutusan sambungan / penyegelan tanpa pemberitahuan.<br><br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian harapan kami untuk dapat dimaklumi, atas perhatiannya kami sampaikan terima<br>
		kasih
		
		";
	}
	
	while($i<$jdata){		
		$cetak8 .= "<page>".$header1;	
		$cetak8 .="<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"100%\" style=\"font-family:calibri;font-size:13px;\">";
		//$cetak8 .="<tr>";
		$cetak8 .="<tr><td width=\"70\">Nomor</td><td>:</td><td width=\"270\">&nbsp;&nbsp;&nbsp;&nbsp;/PDAM/&nbsp;&nbsp;&nbsp;&nbsp;/SP/".date('Y/m/d')."</td><td width=\"100\">Kepada Yth.</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$cetak8 .="<tr><td>Sifat</td><td>:</td><td>Penting</td><td>Bapak/Ibu/Sdr/i</td><td>:</td><td>$nama[$i]</td></tr>";
		$cetak8 .="<tr><td>Perihal</td><td>:</td><td>Tunggakan Rekening Air</td><td>No. Sambungan</td><td>:</td><td>$nomor[$i]</td></tr>";
		$cetak8 .="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Alamat</td><td>:</td><td>$alamat[$i]</td></tr>";
		$cetak8 .="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>di - T e m p a t</td></tr>";
		$cetak8 .="<tr><td colspan=\"2\"></td><td colspan=\"4\" style=\"text-align:justify;\">
		<br><br>
		<p style=\"line-height:2.0;\">Dengan Hormat,<br>
		Berdasarkan hasil evaluasi catatan pembukuan kami, bahwa Bapak / Ibu mempunyai tunggakan <br>
		rekening air sampai dengan saat ini sebesar <b>Rp. $total[$i],-</b> belum termasuk denda keterlambatan <br>
		dan administrasi lainnya.<br>
		".$lks."		
		</p>
		<br><br>
		</td>
		</tr>";
		
		$cetak8 .="<tr><td colspan=\"4\">&nbsp;</td><td colspan=\"2\" style=\"text-align:center;\">
		Jayapura,  ".date('d M Y')."<br><br><br>
		An. Direksi PDAM JAYAPURA<br>
		".$ttd_jab."<br><br><br><br>
		<u>".$ttd_nama."</u><br><br><br><br><br><br><br><br>
		</td></tr>";
		
		$cetak8 .="<tr><td>Catatan</td><td>:</td><td colspan=\"4\">&nbsp;</td></tr>";
		$cetak8 .="<tr><td colspan=\"6\">Mohon Surat Pemberitahuan ini dibawa.</td></tr>";
		
		//$cetak8 .="</tr>";
		$cetak8 .="</table>";
		//if ($tfooter!="")$cetak8.=$tfooter;
		$cetak8 .=$footer1;
		//$cetak8 .=$ttd;
		$cetak8 .="</page>";
		$i++;
	}

			
	
	
	
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
	//$_SESSION['ttd']="";
	
	//putus();
?> 
