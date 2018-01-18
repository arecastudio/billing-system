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
	
	//requier_once("print_class.php");
	//error_reporting(0);
	$orientasi='P';
	$batas=47;
	if(isset($_SESSION['batas'])&& $_SESSION['batas']!=""){
		$batas=$_SESSION['batas'];		
	}
	if(isset($_SESSION['orientasi'])&& $_SESSION['orientasi']!=""){
		$orientasi=$_SESSION['orientasi'];
				
	}
	//$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	$pdf = new HTML2PDF($orientasi,'A4','en', false, 'ISO-8859-15',array(13, 0, 9, 0));
	$pdf->setDefaultFont('Arial');
	
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
	
	$judul="";$sql="";$theader="";$i=0;$j=0;$nmr=0;$re=0;$cetak0="";$cetak1="";$cetak2="";$tfooter="";$ttd="";

	if(isset($_SESSION['judul']))$judul=$_SESSION['judul'];
	if(isset($_SESSION['eskiel']))$sql=$_SESSION['eskiel'];
	if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumfield']))$nmr=$_SESSION['jumfield'];
			//$jmldata=$_SESSION['jumdata'];
	if(isset($_SESSION['alinea']))$alg=$_SESSION['alinea'];
	if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];
	if(isset($_SESSION['baris']))$baris=$_SESSION['baris'];
	if(isset($_SESSION['jumbaris']))$c=$_SESSION['jumbaris'];
	if(isset($_SESSION['rows']))$rows=$_SESSION['rows'];
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$header1="";$footer1="";$t_open="";$t_close="";$cetak8="";$hal=1;
	
	$header1="		
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=80 width=80 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:Arial;font-size:19;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		<p>".$judul."</p>";
		
		
	$footer1="<page_footer>		
		<div style=\"font-size:11px;\">Tgl. cetak: $tanggal</div>
		<div align=\"center\" style=\"font-size:11px;\">
			Halaman: [[page_cu]] / [[page_nb]]
		</div><br>
	</page_footer>";
	
	$t_open="<table align=\"left\" border=\"1\" style=\"border-collapse:collapse;background:#fff;font:Arial;font-size:12px;width:1024px;\">
			".$theader;
	$t_close="";
	
	//==========================================================
	//$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";
	$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font:Arial;font-size:12px;border-spacing:1px;padding:1px;width:1024px;\">".$theader;	
	$y=0;
	
	//$cetak8.=$baris;
	$x=0;
	while($x<=$c){
		$y++;
		$cetak8.=$rows[$x];
		if($y>=33){
			$y=0;
			$cetak8.="</table>$footer1</page>";
			$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font:Arial;font-size:12px;border-spacing:1px;padding:1px;width:1024px;\">".$theader;	
		}
		$x++;
	}
	
	if ($tfooter!="")$cetak8.=$tfooter;
	$cetak8 .="</table>".$footer1;
	$cetak8 .=$ttd;
	$cetak8 .="</page>";
	
	
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
	$_SESSION['rows']="";
	
	putus();
?> 