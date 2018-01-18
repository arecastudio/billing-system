<?php
	session_start();
	require_once("../mydb.php");
	//require_once("../global_functions.php");
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
	
	setlocale(LC_MONETARY,"en_US");
	
	//requier_once("print_class.php");
	//error_reporting(0);
	$orientasi='P';
	$batas=22;
	if(isset($_SESSION['batas'])&& $_SESSION['batas']!=""){
		$batas=$_SESSION['batas'];		
	}
	if(isset($_SESSION['orientasi'])&& $_SESSION['orientasi']!=""){
		$orientasi=$_SESSION['orientasi'];
				
	}
	//$pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(5, 0, 5, 0));
	$pdf = new HTML2PDF($orientasi,'A4','en', false, 'ISO-8859-15',array(13, 0, 9, 0));
	$pdf->setDefaultFont('Times');
	
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

	if(isset($_SESSION['arr_jml']))$arr_jml=$_SESSION['arr_jml'];
	if(isset($_SESSION['arr0']))$arr0=$_SESSION['arr0'];
	if(isset($_SESSION['arr1']))$arr1=$_SESSION['arr1'];
	if(isset($_SESSION['arr2']))$arr2=$_SESSION['arr2'];
	if(isset($_SESSION['arr3']))$arr3=$_SESSION['arr3'];
	if(isset($_SESSION['arr4']))$arr4=$_SESSION['arr4'];
	if(isset($_SESSION['arr5']))$arr5=$_SESSION['arr5'];
	if(isset($_SESSION['arr6']))$arr6=$_SESSION['arr6'];
	if(isset($_SESSION['arr7']))$arr7=$_SESSION['arr7'];
	if(isset($_SESSION['arr8']))$arr8=$_SESSION['arr8'];
	if(isset($_SESSION['arr9']))$arr9=$_SESSION['arr9'];
	if(isset($_SESSION['arr10']))$arr10=$_SESSION['arr10'];
	if(isset($_SESSION['arr11']))$arr11=$_SESSION['arr11'];
	if(isset($_SESSION['arr12']))$arr12=$_SESSION['arr12'];

	if(isset($_SESSION['judul']))$judul=$_SESSION['judul'];
	//if(isset($_SESSION['eskiel']))$sql=$_SESSION['eskiel'];
	if(isset($_SESSION['theader']))$theader=$_SESSION['theader'];
	if(isset($_SESSION['jumfield']))$nmr=$_SESSION['jumfield'];
			//$jmldata=$_SESSION['jumdata'];
	if(isset($_SESSION['alinea']))$alg=$_SESSION['alinea'];
	if(isset($_SESSION['tfooter']))$tfooter=$_SESSION['tfooter'];
	if(isset($_SESSION['ttd']))$ttd=$_SESSION['ttd'];

	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$header1="";$footer1="";$t_open="";$t_close="";$cetak8="";$hal=1;
	
	$header1="		
		<table cellpadding=0 cellspacing=0 border=0><tr><td><img heigh=80 width=80 src=\"pdam-1.jpg\"></td><td align=center width=600 style=\"font:Times;font-size:19;align:center\">PERUSAHAAN DAERAH AIR MINUM<br>JAYAPURA</td></tr></table><hr>
		<p>".$judul."</p>";
		
		
	$footer1="<page_footer>		
		<div style=\"font-size:11px;\">Tgl. cetak: $tanggal</div>
		<div align=\"center\" style=\"font-size:11px;\">
			Halaman: [[page_cu]] / [[page_nb]]
		</div><br>
	</page_footer>";
	
	$t_open="<table align=\"left\" border=\"1\" style=\"border-collapse:collapse;background:#fff;font:Times;font-size:10px;width:1024px;\">
			".$theader;
	$t_close="";
	
	//==========================================================
	//$qry=mysql_query($sql) or die(mysql_error());
	//$nmr=mysql_num_fields($sql);
	//if($qry){
	$re=0;$cetak8="";
	$pakai=0;$uangair=0;$adm=0;$meter=0;$denda=0;$meterai=0;$total=0;
	$t_pakai=0;$t_uangair=0;$t_adm=0;$t_meter=0;$t_denda=0;$t_meterai=0;$t_total=0;
	$cetak8 .= "<page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font:Times;font-size:10px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;	
	$i=0;$nopel="";$j=0;$k=0;$sbg=0;
	while($j<$arr_jml){
		$re++;
		if($nopel<>trim($arr0[$i])&&$nopel<>""){
			$cetak8 .="<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;\">";
			//$cetak8 .="<th>&nbsp;</th>";
			$cetak8 .="<th>Sub Total</th>";
			$cetak8 .="<th>".formatMoney($pakai)."</th>";
			$cetak8 .="<th>".formatMoney($uangair)."</th>";
			$cetak8 .="<th>".formatMoney($adm)."</th>";
			$cetak8 .="<th>".formatMoney($meter)."</th>";
			$cetak8 .="<th>".formatMoney($denda)."</th>";
			$cetak8 .="<th>".formatMoney($meterai)."</th>";
			$cetak8 .="<th>".formatMoney($total)."</th>";
			$cetak8 .="</tr>";
			$t_pakai+=$pakai;$t_uangair+=$uangair;$t_adm+=$adm;$t_meter+=$meter;$t_denda+=$denda;$t_meterai+=$meterai;$t_total+=$total;
			$pakai=0;$uangair=0;$adm=0;$meter=0;$denda=0;$meterai=0;$total=0;
			$cetak8.="</table></td></tr>";
			$sbg=0;
			$re++;
		}
		
		//$re++;
		//if($re==0||$re>60)$re=1;
		//echo $re." ";
		
		if($re > 37){
			$hal++;
			//if(substr($cetak8,strlen($cetak8)-18,18)!="</table></td></tr>")
			if($sbg==1)$cetak8.="</table></td></tr>";
			$cetak8 .= "</table>".$footer1."</page><page><div align=\"right\"></div>".$header1."<table align=\"left\" border=\"1\"  style=\"border-style:dotted;border-collapse:collapse;background:#fff;font:Times;font-size:10px;border-spacing:2px;padding:2px;width:1024px;\">".$theader;
			$re=0;
			//++$hal;
			if($sbg==1){
				$cetak8.="<tr><td></td><td colspan=\"5\"><table border=\"0\" style=\"background:#fff;font:Times;font-size:10px;\">";
					
					
					$cetak8 .="<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;\">";
						//$cetak8 .="<th>&nbsp;</th>";
						$cetak8 .="<th width=\"60\">Periode</th>";
						$cetak8 .="<th width=\"70\">Pakai</th>";
						$cetak8 .="<th width=\"120\">Uang Air</th>";
						$cetak8 .="<th width=\"70\">Adm.</th>";
						$cetak8 .="<th width=\"70\">Meter</th>";
						$cetak8 .="<th width=\"70\">Denda</th>";
						$cetak8 .="<th width=\"70\">Meterai</th>";
						$cetak8 .="<th width=\"120\">Total</th>";
					$cetak8 .="</tr>";
					//$cetak8 .="<td></td>";
					//
			}
		}
		
			
		
		$j++;
		if($nopel<>trim($arr0[$i])){		
		$k++;
		
						
		//if($nopel<>trim($arr0[$i])){
		$cetak8 .="<tr>";
		$cetak8 .="<td align=\"center\" rowspan=\"2\">".$k."</td>";
		$cetak8 .="<td align=\"center\">$arr0[$i]</td>";
		$cetak8 .="<td align=\"center\">$arr1[$i]</td>";
		$cetak8 .="<td>$arr2[$i]</td>";
		$cetak8 .="<td>$arr3[$i]</td>";
		$cetak8 .="<td align=\"center\">$arr4[$i]</td>";
		$cetak8 .="</tr>";
		//}
		
		//if($nopel<>trim($arr0[$i])){
		$cetak8 .="<tr>";
			//$cetak8 .="<td>&nbsp;</td>";
			$cetak8 .="<td colspan=\"5\">";
				$cetak8 .="<table border=\"0\" style=\"background:#fff;font:Times;font-size:10px;\">";
		//}
					//if($nopel<>trim($arr0[$i])){
					$cetak8 .="<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;\">";
						$cetak8 .="<th width=\"60\">Periode</th>";
						$cetak8 .="<th width=\"70\">Pakai</th>";
						$cetak8 .="<th width=\"120\">Uang Air</th>";
						$cetak8 .="<th width=\"70\">Adm.</th>";
						$cetak8 .="<th width=\"70\">Meter</th>";
						$cetak8 .="<th width=\"70\">Denda</th>";
						$cetak8 .="<th width=\"70\">Meterai</th>";
						$cetak8 .="<th width=\"120\">Total</th>";
					$cetak8 .="</tr>";
					//}
					$re++;
		}
					if($arr6[$i]<0)$arr6[$i]=0;
					$pakai+=$arr6[$i];
					$uangair+=$arr7[$i];
					$adm+=$arr8[$i];
					$meter+=$arr9[$i];
					$denda+=$arr10[$i];
					$meterai+=$arr11[$i];
					$total+=$arr12[$i];
										
					$cetak8 .="<tr>";
						$cetak8 .="<td align=\"center\">$arr5[$i]</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr6[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr7[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr8[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr9[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr10[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr11[$i])."</td>";
						$cetak8 .="<td align=\"right\">".formatMoney($arr12[$i])."</td>";
					$cetak8 .="</tr>";
					$sbg=1;
				//$cetak8 .="</table>";
			//$cetak8 .="</td>";
		//$cetak8 .="</tr>";
		//if($nopel<>trim($arr0[$i]))$cetak8.="</table></td></tr>";
		
		$nopel=$arr0[$i];
		$i++;			
	}
	//if($nopel<>trim($arr0[$i-1])&&$nopel<>"")
	$cetak8 .="<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;\">";
	//$cetak8 .="<th>&nbsp;</th>";
	$cetak8 .="<th>Sub Total</th>";
	$cetak8 .="<th>".formatMoney($pakai)."</th>";
	$cetak8 .="<th>".formatMoney($uangair)."</th>";
	$cetak8 .="<th>".formatMoney($adm)."</th>";
	$cetak8 .="<th>".formatMoney($meter)."</th>";
	$cetak8 .="<th>".formatMoney($denda)."</th>";
	$cetak8 .="<th>".formatMoney($meterai)."</th>";
	$cetak8 .="<th>".formatMoney($total)."</th>";
	$cetak8 .="</tr>";
	
	$cetak8 .="<tr align=\"center\" style=\"background-color:#f0f0f0;color:#000;\">";
	$cetak8 .="<th>Grand<br>T o t a l</th>";
	$cetak8 .="<th>".formatMoney($t_pakai)."</th>";
	$cetak8 .="<th>".formatMoney($t_uangair)."</th>";
	$cetak8 .="<th>".formatMoney($t_adm)."</th>";
	$cetak8 .="<th>".formatMoney($t_meter)."</th>";
	$cetak8 .="<th>".formatMoney($t_denda)."</th>";
	$cetak8 .="<th>".formatMoney($t_meterai)."</th>";
	$cetak8 .="<th>".formatMoney($t_total)."</th>";
	$cetak8 .="</tr>";
	
	$pakai=0;$uangair=0;$adm=0;$meter=0;$denda=0;$meterai=0;$total=0;
	$t_pakai=0;$t_uangair=0;$t_adm=0;$t_meter=0;$t_denda=0;$t_meterai=0;$t_total=0;
	
	$cetak8.="</table></td></tr>";
	
	
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
	
	putus();
?> 