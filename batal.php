<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$dapat=0;$cek="";
$nloket="JPR";

if (isset($_POST["proses"])){
	//$tawal='2000-01-01';
	$takhir=date('Y-m-d');
	$slipit="";
	$stbayar=0;
	$dapat=0;
	$nomor=trim($_POST['txnomor']);
	//$periode=getPeriodeLalu();
										
	$sql="
	SELECT m.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,25),m.gol,(SELECT DISTINCT k.keterangan FROM tarif AS k WHERE k.gol=m.gol LIMIT 0,1),
	m.kondisi_meter,m.cabang,c.nama,m.dkd,d.jalan,if(m.putus='0','SAMBUNG [0]','PUTUS [3]')
	FROM master AS m
	INNER JOIN cabang AS c ON c.cabang=m.cabang
	LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd									
	WHERE (nomor='$nomor' OR nolama='$nomor')
	;";	
	$qry=mysql_query($sql)or die(mysql_error());
	if(mysql_num_rows($qry)>0){
		$dapat=1;
		if($row=mysql_fetch_row($qry)){
			$nmr=trim($row[0]);
			$nolama=$row[1];
			$nama=$row[2];
			$alamat=$row[3];
			$gol=$row[4];
			$ket=$row[5];
			$kwm=$row[6];
			$cabang=$row[7];
			$cnama=$row[8];
			$dkd=$row[9];
			$jalan=$row[10];
			$putus=$row[11];
			//$dapat=1;
		}
	}else{
		echo"<script type=\"text/javascript\">alert('Data Tidak Ditemukan!');</script-->";	
	}
}
?>
   
<script type="text/javascript">
	function formatCurrency(num){
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num)) num = "0";
			cents = Math.floor((num*100+0.5)%100);
			num = Math.floor((num*100+0.5)/100).toString();
		if(cents < 10) cents = "0" + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
			return ("Rp. " + num + "," + cents);
	}
	
	function checkChoice(whichbox){
		with (whichbox.form){
			if (whichbox.checked == false){
				htotal.value = eval(htotal.value) - eval(whichbox.value);
				txtotal.value = formatCurrency(parseInt(htotal.value));
			}else{
				htotal.value = eval(htotal.value) + eval(whichbox.value);
				txtotal.value = formatCurrency(parseInt(htotal.value));
			}
			return(txtotal.value);
		}
	}
</script>

	<tr>
		<td>
		<!--############################################################################################################-->
		<br/>
		<table width="1045px" border="0" cellpadding="1" cellspacing="1" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
            	<td colspan="4" align="center">.::Pembatalan Pembayaran Rekening::.</td>
            </tr>
            <tr>
            	<td>Tanggal Bayar</td>
                <td colspan="3" align="left">
                	<input type="text" size="8px" name="txtgl" id="txtgl" readonly class="datepicker8" value="<?php echo date('Y-m-d');?>" />
                </td>
            </tr>
            <!--tr>
            	<td>Jenis</td>
                <td colspan="3">
                    <input type="radio" name="rad" id="r1" value="all" />Semua Pelanggan &nbsp;
                    <input type="radio" name="rad" id="r2" value="person" checked />Per Pelanggan<hr/>
                </td>
            </tr-->
            <tr>
              <td width="130px">Nomor/NoLama</td>
              <td width="500px">
              <!--focus kursor -->
<script type="text/javascript" language="javascript">
	 $(function() {
       // focus on the first text input field in the first field on the page
	   $("#txnomor").focus();
    });
</script> 
              
              	<input type="text" size="13" name="txnomor"  id="txnomor" maxlength="15"  onkeypress="return isNumb(event);" /><input type="button" name="cari" value="Cari!" class="kelas_tombol" onClick="window.open('cari.php','popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no'); return false;" />                
              </td>
              <td width="130px">Kondisi Meter</td>
              <td><?php if(isset($_POST["proses"]) && $dapat==1){echo $kwm." - ".kondisi_wm($kwm);}?></td>              
            </tr>
            <tr>
            	<td style="font-size:18px;font-family:calibri;font-weight:bold;">Pelanggan</td>
                <td style="font-size:18px;font-family:calibri;font-weight:bold;"><?php if(isset($_POST["proses"])  && $dapat==1){echo $nmr."/".$nolama." - ".$nama;}?></td>
                <td>Cabang</td>
              	<td><?php if(isset($_POST["proses"]) && $dapat==1){echo $cabang." - ".$cnama;}?></td>
            </tr>
            <tr>
            	<td>Alamat</td>
                <td><?php if(isset($_POST["proses"]) && $dapat==1){echo $alamat;}?></td>
                <td>DKD</td>
              	<td><?php if(isset($_POST["proses"]) && $dapat==1){echo $dkd." - ".$jalan;}?></td>
            </tr>
            <tr>
            	<td>Golongan</td>
                <td><?php if(isset($_POST["proses"]) && $dapat==1){echo $gol." - ".$ket;}?></td>
                <td>Stat Sambungan</td>
              	<td><?php if(isset($_POST["proses"]) && $dapat==1){echo $putus;}?></td>
            </tr>
			<tr height="35px">
				<td>
					<input type="submit" name="proses" value="Tampilkan!" class="kelas_tombol" />
                    <!--input type="button" name="batal" value="(*)" class="kelas_tombol" onClick="window.location.href='batal.php';" /-->
                </td>
                <td>
                  	<input type="radio" name="rcek" id="all" value="checked" />Check All &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="rcek" id="none" value="" checked /> Un-Check All
               	</td>
                <td colspan="2">&nbsp;</td>
			</tr>
          <!--/form-->
		  </table>
		  
          <!--form id="f2" name="f2" action="" method="post"-->
		  <table width="1154px" align="center" border="0" cellpadding="2" cellspacing="1" class="rounded" background="img/grids.gif">			
            <tr>
				<td width="100%" align="center" colspan="3">
					<div style="height:300px;overflow:auto">						
                        <table width="100%" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffd;font-family:calibri;font-size:12px;" >
							<tr style=\"color:#000;background:linear-gradient(#fff,#888);\">
								<th>No.</th>
								<th>Batal</th>
                                
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Loket</th>
                                <th>Jam</th>                                
                                                                
								<th>Periode</th>
								<th>St. Lalu</th>
								<th>St. Kini</th>
								<th>Pakai</th>
								<th>Uang Air</th>
								<th>Adm</th>
								<th>Meter</th>
								<th>Denda</th>
								<th>Meterai</th>
								<th>Jumlah</th>
							</tr>                            
                            
							<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Tampilkan!" && $dapat==1){
									//$tawal='2000-01-01';
									$takhir=date('Y-m-d');
									$slipit="";
									$stbayar=0;
									//$nomor=$_POST['txnomor'];
									$nomor=trim($_POST['txnomor']);
									$cek=$_POST["rcek"];
									//$jenis=$_POST["rad"];
									//$periode=getPeriodeLalu();
									echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nomor\";</script>";
									echo"<script type=\"text/javascript\">document.getElementById(\"txtgl\").value=\"".trim($_POST['txtgl'])."\";</script>";
									
									if($cek!=""){
										echo"<script type=\"text/javascript\">document.getElementById(\"all\").checked=\"checked\";</script>";
									}else{
										echo"<script type=\"text/javascript\">document.getElementById(\"none\").checked=\"checked\";</script>";
									}
																		
									//echo"";
									$i=0;$wrn="#ccc";
									$total=0;
									$sql="
									SELECT DISTINCT r.periode,r.standlalu,r.standkini,r.pakai,r.uangair,r.adm,r.meter,r.denda,r.meterai,(r.uangair + r.adm + r.meter + r.meterai + r.denda),r.nomor,m.nolama,SUBSTR(m.nama,1,25),SUBSTR(m.alamat,1,25),t.jbayar,t.loket
									FROM rekening1 AS r
									LEFT OUTER JOIN master AS m ON m.nomor=r.nomor
									LEFT OUTER JOIN transaksi AS t ON t.nomor=r.nomor AND t.periode=r.periode AND t.batal=0
									WHERE r.nomor='$nmr' AND r.status_bayar=1 AND r.tbayar='".trim($_POST['txtgl'])."'
									ORDER BY r.nomor ASC,r.periode ASC,t.jbayar ASC
									;";
									echo"<input type=\"hidden\" name=\"txhnomor\" id=\"txhnomor\" value=\"$nmr\" />";
									$qry=mysql_query($sql)or die(mysql_error());
									while($rows=mysql_fetch_row($qry)){
										$i++;
										if($i%2==0){
											$wrn="#ccf";
										}else{
											$wrn="#ffc";
										}
										echo"
										<tr bgcolor=\"$wrn\">
											<td width=\"40\" align=\"center\">$i</td><input type=\"hidden\" name=\"h$rows[0]\" id=\"h$rows[0]\" value=\"$rows[0]\" /> <input type=\"hidden\" name=\"v$rows[0]\" id=\"v$rows[0]\" value=\"$rows[10]\" />
											<td align=\"center\">
												<input type=\"checkbox\" name=\"$rows[0]\" id=chk_\"$rows[0]\" $cek value=\"$rows[9]\"  onClick=\"checkChoice(this);\" >												
											</td>											
											
											<td align=\"center\" style=\"color:#00f;font-weight:bold;\">$rows[10] / $rows[11]</td>
											<td align=\"left\" style=\"color:#00f;font-weight:bold;\">$rows[12]</td>
											<td align=\"left\">$rows[13]</td>
											<td align=\"center\">$rows[15]</td>
											<td align=\"center\">$rows[14]</td>
											
											<td align=\"center\" style=\"color:#00f;font-weight:bold;\">".$rows[0]."</td>
											<td align=\"right\">".formatMoney($rows[1])."</td>
											<td align=\"right\">".formatMoney($rows[2])."</td>
											<td align=\"right\">".formatMoney($rows[3])."</td>
											<td align=\"right\">".formatMoney($rows[4])."</td>
											<td align=\"right\">".formatMoney($rows[5])."</td>
											<td align=\"right\">".formatMoney($rows[6])."</td>
											<td align=\"right\">".formatMoney($rows[7])."</td>
											<td align=\"right\">".formatMoney($rows[8])."</td>
											<td align=\"right\" style=\"color:#00f;font-weight:bold;\">".formatMoney($rows[9])."</td>
										</tr>
										";
										$total+=$rows[9];
									}																	
								}
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr height="25px">
                <td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:12px;" rowspan="2">
                    
                    <?php
                    if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
                        $tujuan="reports/print_report_lpp_rekap.php";
                    }else{
                        $tujuan="reports/print_report.php";
                    }
                    ?>
                    <input type="submit" name="batalkan" value="Batalkan!" class="kelas_tombol" />
                </td>
                <td align="left" style="font-weight:bold;">Jumlah Total</td>
                <td width="700px" align="left">    
                    <input name="txtotal" id="txtotal" type="text" size="22" readonly style="font-size:18px;font-weight:bold;text-align:right;color:#fff;background:linear-gradient(#f00,#000);" value="0" />
                    <input type="hidden" name="htotal" id="htotal" value="0" />
                    
                </td>
			</tr>
            <tr>
            	<td>Terbilang</td>
                <td>
                	<input name="txbilang" id="txbilang" type="text" size="95" readonly style="font-size:15px;font-weight:bold;text-align:left;color:#a00;background:#fff;font-variant:small-caps;" />
                </td>
            </tr>
		</table>
		</form>
        
<?php
//===========================SIMPAN=DATA===================================
if (isset($_POST["batalkan"])){	
	//$arr_prd="";
	$i=0;$j=0;$sisip="";
	$nomor=trim($_POST['txhnomor']);
									
	//$sql="SELECT DISTINCT r.nomor,r.periode,(r.uangair + r.adm + r.meter + r.meterai + r.denda),m.nolama FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor WHERE $selip r.status_bayar=1 AND r.tbayar='".$_POST['txtgl']."';";
	$sql="SELECT DISTINCT r.nomor,r.periode,(r.uangair + r.adm + r.meter + r.meterai + r.denda) FROM rekening1 AS r WHERE r.status_bayar=1 AND r.tbayar='".$_POST['txtgl']."' AND r.nomor='$nomor';";
	$query=mysql_query($sql)or die(mysql_error());
	while($row=mysql_fetch_row($query)){
		$prd=trim($row[1]);
		$total=trim($row[2]);
		$nmr1=trim($row[0]);		
		if(isset($_POST[$prd])){
			mysql_query("UPDATE rekening1 SET status_bayar=0,tbayar='0000-00-00',loket='',denda=0 WHERE nomor='$nomor' AND periode=$prd AND tbayar='".$_POST['txtgl']."';")or die(mysql_error());
			mysql_query("DELETE FROM transaksi WHERE nomor='$nomor' AND periode=$prd AND tbayar='".$_POST['txtgl']."' AND batal=0;")or die(mysql_error());
			//mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor',$prd,$total,'".date('Y-m-d')."','".date('H:i:s')."','".$_SESSION['nama_komputer']."','".$_SESSION['nama_user']."',1);")or die(mysql_error());			
			mysql_query("INSERT IGNORE INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)VALUES('$nomor',$prd,$total,'".date('Y-m-d')."','".date('H:i:s')."','".$nloket."','".$_SESSION['nama_user']."',1);")or die(mysql_error());			
			//mysql_query("UPDATE transaksi SET batal=1,tbayar='".date('Y-m-d')."',jbayar='".date('H:i:s')."',loket='".$_SESSION['nama_komputer']."',operator='".$_SESSION['nama_user']."' WHERE $selip periode=$prd AND tbayar='".$_POST['txtgl']."' AND batal=0;")or die(mysql_error());
			
			//$arr_prd[]=$prd;
			$i++;
			//echo"<script type=\"text/javascript\">alert('Data Tidak Ditemukan!');</script-->";
		}
	}
	/*for($j=0;$j<$i;$j++){
		if($sisip!="")$sisip.=" OR ";
		$sisip.="r.periode=".$arr_prd[$j];
	}*/
	//echo $sisip;
	/*$sql_rek="
	SELECT DISTINCT m.nomor,m.nolama,SUBSTR(m.nama,1,30),SUBSTR(m.alamat,1,22),m.gol,(SELECT DISTINCT c.keterangan FROM tarif AS c WHERE c.gol=m.gol LIMIT 0,1) AS ket,r.standlalu,r.standkini,r.pakai,FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),FORMAT(r.denda,0),FORMAT(r.meterai,0),(r.uangair + r.adm + r.meter + r.meterai + r.denda),r.periode,r.status_bayar,r.tbayar,t.jbayar
	FROM master AS m
	INNER JOIN rekening1 AS r ON r.nomor=m.nomor AND r.status_bayar=1
	LEFT OUTER JOIN transaksi AS t ON t.nomor=m.nomor AND t.batal=0 AND t.periode=r.periode
	WHERE r.nomor='$nmr1' AND r.tbayar='".date('Y-m-d')."' AND ($sisip)
	ORDER BY m.nomor
	;";*/
	
	//echo $sql_rek;
	
	//$_SESSION['eskiel']=$sql_rek;
	//$_SESSION['jumfield']=$i;
	//$_SESSION['bilang']=konversi($total)."rupiah";
	
	//echo"<a style=\"color:#ff0;\" href=\"reports/print_rek.php\" target=\"_blank\">-= Cetak Ulang Rekening =-</a>";
	
	//header("location:reports/print_rek.php");
	//echo"<script type=\"text/javascript\">window.open('reports/print_rek.php','popUpWindow','height=9500,width=2550px,left=10,top=10,scrollbars=yes,menubar=no',top=100,left=500);</script-->";
	//echo"<script type=\"text/javascript\">window.print('reports/print_rek.php');</script-->";
}
//=========================================================================
?>
        
		  <br />
		  <?php
          	if($cek!=""){
			  	echo"<script type=\"text/javascript\">document.getElementById(\"htotal\").value=\"$total\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txtotal\").value=\"Rp. ".formatMoney($total).",00\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txbilang\").value=\"".konversi($total)."rupiah\";</script>";
			}else{
				echo"<script type=\"text/javascript\">document.getElementById(\"htotal\").value=\"0\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txtotal\").value=\"0\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txbilang\").value=\"\";</script>";
			}
		  ?>
		  <!--############################################################################################################-->
	  </td>
	</tr>
    
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
