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
	
	//requier_once("print_class.php");
	//error_reporting(0);
	
	$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	$pdf->setDefaultFont('Arial');
	
	$judul="";$sql="";$theader="";$i=0;$j=0;$nmr=0;$re=0;$cetak0="";$cetak1="";$cetak2="";$tfooter="";$ttd="";

	if(isset($_SESSION['judul']))$judul=$_SESSION['judul'];
	if(isset($_SESSION['eskiel']))$sql=$_SESSION['eskiel'];
	if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumfield']))$nmr=$_SESSION['jumfield'];
			//$jmldata=$_SESSION['jumdata'];
	if(isset($_SESSION['alinea']))$alg=$_SESSION['alinea'];
	if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];

	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$header1="";$footer1="";$t_open="";$t_close="";$cetak8="";$hal=1;
	
	$header1="		
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=80 width=80 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:arial;font-size:19;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		<p>".$judul."</p>";
		
		
	$footer1="<page_footer>
		<table align=\"center\" class=\"page_footer\">
			<tr>
				<td style=\"width: 100%; text-align: right\">
					Halaman: [[page_cu]] / [[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>";
	
	$t_open="<table align=\"center\" border=\"1\" style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:10px;;width:850px;\">
			".$theader;
	$t_close="";
	
	//==========================================================
	$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";
	$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"center\" border=\"1\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:9px;border-spacing:1px;padding:1px;;width:850px;\">".$theader;	
	
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
		}else if($re > 55){
			$hal++;
			$cetak8 .= "</table>".$footer1."</page><page><div align=\"right\"></div>".$header1."<table align=\"center\" border=\"1\"  style=\"border-collapse:collapse;background:#fff;font-family:calibri;font-size:9px;border-spacing:1px;padding:1px;;width:850px;\">".$theader;
			$re=0;
			//++$hal;
		}
		$cetak8 .="<tr><td align=\"center\">".$j."</td>";
		for($i=0;$i<$nmr;$i++){
			$cetak8 .="<td align=\"$alg[$i]\">".trim($row[$i])."</td>";
		}
		$cetak8 .="</tr>";					
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
	$_SESSION['alinea']="";
	$_SESSION['tfooter']="";*/
	
	putus();
?> 