<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

//$_SESSION['nama_komputer']
$nloket="FKT";

$dapat=0;$cek="";

if (isset($_POST["proses"])&& $_POST["proses"]=="Tampilkan!"){
	//$tawal='2000-01-01';
	$takhir=date('Y-m-d');
	$slipit="";
	$stbayar=0;
	$dapat=0;
	//$nomor=trim($_POST['txnomor']);
	//$prd=$_POST['optprd'];
	//$periode=getPeriodeLalu();
										
	/*$sql="
	SELECT m.nomor,m.nolama,m.nama,m.alamat,m.gol,(SELECT DISTINCT k.keterangan FROM tarif AS k WHERE k.gol=m.gol LIMIT 0,1),
	m.kondisi_meter,m.cabang,c.nama,m.dkd,d.jalan,if(m.putus='0','SAMBUNG [0]','PUTUS [3]')
	FROM master AS m
	INNER JOIN cabang AS c ON c.cabang=m.cabang
	LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd									
	WHERE (nomor='$nomor' OR nolama='$nomor')
	;";*/
	
		
	$sql="
	SELECT cabang, nama, kacab, nip
	FROM cabang
	";
	
	$qry=mysql_query($sql)or die(mysql_error());
	if(mysql_num_rows($qry)>0){
		$dapat=1;
		if($row=mysql_fetch_row($qry)){
			/*$nmr=trim($row[0]);
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
			$putus=$row[11];*/
			
			//$dapat=1;
			$_SESSION['eskiel']="";
			/*
			$kokol=trim($row[0]);
			$ket=trim($row[1]);
			$alamat=trim($row[2]);
			$cabang=trim($row[3]);
			$cnama=trim($row[4]);
			$wil=trim($row[5]);
			$blok=trim($row[6]);
			$dkd=trim($row[7]);
			$res=trim($row[8]);
			$tlp=trim($row[9]);
			$jalan=trim($row[10]);
			*/
			$_SESSION["judul"]="<div style=\"font-weight:bold;font-size:15px;text-align:center;\">FAKTUR</div>
			<table cellpadding=0 cellspacing=0 border=0 width=800>
				<tr>
					<td align=\"left\">Kepada Yth.</td>
					<td colspan=\"3\" align=\"left\">&nbsp;</td>
				</tr>
				<tr>
					<td align=\"right\" width=110>Bpk/Ibu/Instansi:</td>
					<td width=400>keteranga</td>
					<td align=\"right\">Nomor:</td>
					<td>PDAM/FAKTUR/".date('Y/m/d')."</td>
				</tr>
				<tr>
					<td align=\"right\">&nbsp;</td>
					<td>alamat</td>
					<td align=\"right\">Bulan:</td>
					<td></td>
				</tr>
			</table>
			";
			
		}
	}else{
		echo"<script type=\"text/javascript\">alert(\"Data tidak ditemukan!\");</script>";
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
            	<td colspan="4" align="center"><marquee behavior="alternate" scrollamount="2" hspace="280">.::Pencetakan Rekening per Cabang [UPP]::.</marquee></td>
            </tr>
            <tr>
              <td width="130px">Cabang</td>
              <td width="500px">
				<select name="optcabang" id="optcabang" >
					<!--option value="11" selected="selected">Semua UPP</option-->
					<?php
						$sql=mysql_query("select cabang,nama from cabang WHERE cabang<>'00' order by cabang DESC");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
						}
					?>
                </select> 
              </td>
              <td width="130px">Periode Rek.</td>
              <td>
				<select name="optperiode2" id="optperiode2">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from rekening1 order by periode desc");
						//$sql=mysql_query("select distinct max(periode) from rekening1;");
						//$sql=mysql_query("select (201408-0) as prd;");
						while($row=mysql_fetch_row($sql)){
							//$i=0;							
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
                </select>
			  </td>              
            </tr>
            
			<tr height="35px">
				<td>
					<input type="submit" name="proses" value="Tampilkan!" class="kelas_tombol" />
                </td>
                <td>
                  	<input type="radio" name="rcek" id="all" value="checked" />Check All &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="rcek" id="none" value="" checked /> Un-Check All
               	</td>
                <td style="font-size:18px;font-family:calibri;font-weight:bold;">Tanggal</td>
                <td style="font-size:18px;font-family:calibri;font-weight:bold;"><?php echo date('Y-M-d');?></td>
			</tr>
          <!--/form-->
		  </table>
		  
          <!--form id="f2" name="f2" action="" method="post"-->
		  <table width="1054px" align="center" border="0" cellpadding="2" cellspacing="1" class="rounded" background="img/grids.gif">			
            <tr>
				<td width="100%" align="center" colspan="3">
					<div style="height:430px;overflow:auto">						
                        <table width="100%" border="0" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffd;font-family:calibri;font-size:12px;" >
							<tr style=\"color:#000;background:linear-gradient(#fff,#888);\">
								<th>No.</th>
								<th>Ctk.</th>
                                
                                <th>Nomor</th>
                                <th>NoLama</th>
                                <th align="left">Nama</th>
								
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
									$cbg=$_POST['optcabang'];
									$prd=$_POST['optperiode2'];
									//$nomor=$_POST['txnomor'];
									//$nomor=trim($_POST['txnomor']);
									//$prd=$_POST['optprd'];
									$cek=$_POST["rcek"];
									//$periode=getPeriodeLalu();
									
									//echo"<script type=\"text/javascript\">document.getElementById(\"optprd\").value=\"$prd\";</script-->";
									if($cek!=""){
										echo"<script type=\"text/javascript\">document.getElementById(\"all\").checked=\"checked\";</script>";
									}else{
										echo"<script type=\"text/javascript\">document.getElementById(\"none\").checked=\"checked\";</script>";
									}
									//echo $prd;
									//echo"";
									$i=0;$wrn="#ccc";
									$total=0;
									$sql="
									SELECT r.periode,r.standlalu,r.standkini,r.pakai,r.uangair,r.adm,r.meter,r.denda,r.meterai,(r.uangair + r.adm + r.meter + r.meterai + r.denda),r.nomor,m.nolama,m.nama
									FROM rekening1 AS r
									INNER JOIN master AS m ON m.nomor=r.nomor									
									WHERE r.status_bayar=0 AND m.cabang='$cbg' AND r.periode='$prd' AND m.putus=0
									ORDER BY r.periode ASC,r.nomor ASC ;"; //ORDER BY r.nomor ASC,r.periode ASC
									
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
											<td width=\"40\" align=\"center\">$i</td>
											<td align=\"center\"><input type=\"checkbox\" name=\"chk_"."$i\" id=chk_\"$rows[0]\" $cek value=\"$rows[9]\"  onClick=\"checkChoice(this);txbilang.value=terbilang(htotal.value);\" ></td>
											
											<input type=\"hidden\" name=\"nmr$i\" id=\"nmr$i\" value=\"$rows[10]\" >
											<input type=\"hidden\" name=\"prd$i\" id=\"prd$i\" value=\"$rows[0]\" />
											
											<td align=\"center\">".trim($rows[10])."</td>
											<td align=\"center\">".trim($rows[11])."</td>
											<td align=\"left\">".trim($rows[12])."</td>
											
											
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
										
										echo"<input type=\"hidden\" name=\"txhnomor$i\" id=\"txhnomor$i\" value=\"$rows[10]\" />";
										
										echo"<input type=\"hidden\" name=\"txjdata\" id=\"txjdata\" value=\"$i\" />";
									}																	
								}
							?>
						</table>
					</div>
				</td>
			</tr>
            <tr style="color:#707;font-family:calibri;font-size:14px;font-weight:bold;">            
            	<td colspan="2" align="right" style="color:black;"><b>Jenis Cetakan</b></td>
                <td>
                	<input type="radio" name="rjenis" id="rrek" value="rrek" checked />Rekening &nbsp;&nbsp;
                    <!--input type="radio" name="rjenis" id="rdaf" value="rdaf" />Daftar &nbsp;&nbsp;
                    <input type="radio" name="rjenis" id="rkwi" value="rkwi" />Kwitansi -->
                </td>
            </tr>
			<tr height="25px">
                <td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:12px;" rowspan="2">
                    
                    <?php
                    if( isset($_POST["lunaskan"]) && $_POST["rjenis"]=="rdaf"){
                        $tujuan="print_daftar";
                    }elseif(isset($_POST["lunaskan"]) && $_POST["rjenis"]=="rkwi"){
                        $tujuan="print_report";
                    }else{
						//if(isset($_POST["lunaskan"])){
							$tujuan="print_rek";
						//}
					}
                    ?>
                    <input type="submit" name="lunaskan" value="Cetak!" class="kelas_tombol" onClick="window.open('reports/<?php echo $tujuan;?>.php','popUpWindow','height=450,width=800,left=200,top=10,scrollbars=yes,menubar=no'); return true;" />
                </td>
                <td align="left" style="font-weight:bold;">Jumlah Total</td>
                <td width="700px" align="left">    
                    <input name="txtotal" id="txtotal" type="text" size="22" readonly style="font-size:18px;font-weight:bold;text-align:right;color:#fff;background:linear-gradient(#f00,#000);" value="0" />
                    <input type="hidden" name="htotal" id="htotal" value="0" />
                    <b style="color:red;text-decoration:blink;">Pastikan uang telah diterima dan sesuai dengan jumlah sebelum melakukan pelunasan!!</b>
                </td>
			</tr>
            <tr>
            	<td>Terbilang</td>
                <td>
                	<input name="txbilang" id="txbilang" type="text" size="95" readonly style="font-size:15px;font-weight:bold;text-align:left;color:#a00;background:#fff;" />
                </td>
            </tr>
		</table>
		</form>
        
<?php
//===========================SIMPAN=DATA===================================
if (isset($_POST["lunaskan"])){	
	//$arr_prd="";
	$i=0;$j=0;$sisip="";$insert="";
	//$kokol=trim($_POST['txnomor']);
	$jdata=trim($_POST['txjdata']);
	//$nomor=trim($_POST['txhnomor']);	
	//$prd=$_POST['optprd'];
	/*$sql="SELECT DISTINCT r.nomor,r.periode,(r.uangair + r.adm + r.meter + r.meterai + r.denda),m.nolama FROM rekening1 AS r INNER JOIN master AS m ON m.nomor=r.nomor WHERE (r.nomor='$nomor') AND r.status_bayar=0;";
	$query=mysql_query($sql)or die(mysql_error());
	while($row=mysql_fetch_row($query)){
		$prd=trim($row[1]);
		$total=trim($row[2]);
		$nmr1=trim($row[0]);		
		if(isset($_POST[$prd])){
			mysql_query("UPDATE rekening1 SET status_bayar=1,tbayar='".date('Y-m-d')."',loket='".$_SESSION['nama_komputer']."' WHERE nomor=$nomor AND periode=$prd;")or die(mysql_error());
			$insert="
			INSERT INTO transaksi(nomor,periode,total,tbayar,jbayar,loket,operator,batal)
			VALUES('$nomor',$prd,$total,'".date('Y-m-d')."','".date('H:i:s')."','".$nloket."','".$_SESSION['nama_user']."',0)
			ON DUPLICATE KEY UPDATE transaksi.tbayar='".date('Y-m-d')."',transaksi.jbayar='".date('H:i:s')."',transaksi.loket='".$nloket."',transaksi.operator='".$_SESSION['nama_user']."',transaksi.batal=0
			;";			
			mysql_query($insert)or die(mysql_error());			
			$arr_prd[]=$prd;
			$i++;
		}
	}
	for($j=0;$j<$i;$j++){
		if($sisip!="")$sisip.=" OR ";
		$sisip.="r.periode=".$arr_prd[$j];
	}*/
	//echo $sisip;
	
	for($i=1;$i<=$jdata;$i++){
		if(isset($_POST["chk_".$i])){
			if($sisip!="")$sisip.=" OR ";
			$sisip.="(r.nomor='".$_POST["nmr".$i]."' AND r.periode=".$_POST["prd".$i].")";
		}
	}
	
	//echo $sisip;
	
	$sql_rek11="
	SELECT DISTINCT m.nomor,m.nolama,SUBSTR(m.nama,1,30),SUBSTR(m.alamat,1,22),m.gol,(SELECT DISTINCT c.keterangan FROM tarif AS c WHERE c.gol=m.gol LIMIT 0,1) AS ket,r.standlalu,r.standkini,r.pakai,FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),FORMAT(r.denda,0),FORMAT(r.meterai,0),(r.uangair + r.adm + r.meter + r.meterai + r.denda),r.periode,r.status_bayar,r.tbayar,r.tbayar
	,k.kode_kolektif,k.ket_kolektif,k.alamat_kolektif
	FROM rekening1 AS r	
	INNER JOIN master AS m ON m.nomor=r.nomor
	INNER JOIN pel_kolektif_d AS p ON p.nomor=m.nomor
	INNER JOIN pel_kolektif AS k ON k.kode_kolektif=p.kode_kolektif
	WHERE p.kode_kolektif='$kokol' AND $sisip AND r.status_bayar=0	
	ORDER BY r.periode ASC,r.nomor ASC
	;";
	
	$sql_rek="
	SELECT DISTINCT m.nomor,m.nolama,SUBSTR(m.nama,1,30),SUBSTR(m.alamat,1,22),m.gol,(SELECT DISTINCT c.keterangan FROM tarif AS c WHERE c.gol=m.gol LIMIT 0,1) AS ket,r.standlalu,r.standkini,r.pakai,FORMAT(r.uangair,0),FORMAT(r.adm,0),FORMAT(r.meter,0),FORMAT(r.denda,0),FORMAT(r.meterai,0),(r.uangair + r.adm + r.meter + r.meterai + r.denda),r.periode,r.status_bayar,r.tbayar,r.tbayar
	FROM rekening1 AS r	
	INNER JOIN master AS m ON m.nomor=r.nomor	
	WHERE $sisip AND r.status_bayar=0 AND m.putus=0
	ORDER BY r.periode ASC,r.nomor ASC
	;";
		
	//echo $sql_rek;
	
	$_SESSION['eskiel']=$sql_rek;
	$_SESSION['jumfield']=$i;
	$_SESSION["alinea"]=array("center","center","left","left","left","left","center","right","right","right","right","right","right","right","right","right","right","right","right","right","right");
	
	$_SESSION["bilang"]=$_POST["txbilang"];
	$_SESSION['jtotal']=$_POST["txtotal"];
	
	$_SESSION["jumfield"]=8;
	$_SESSION['orientasi']='P';
	$_SESSION['batas']=25;
	$_SESSION["theader"]="
	<tr align=\"center\" style=\"color:#000;font-weight:bold;\">
		<td>No.</td>
		<td>Nomor</td>
		<td>NoLama</td>
		<td width=150>Nama</td>
		<td>Gol</td>		
		<td>Periode</td>
		<td>Pakai</td>
		<td width=60>Uang<br>Air</td>
		<td>Adm</td>
		<td>Meter</td>
		<td>Denda</td>
		<td>Meterai</td>
		<td width=70>Total</td>
	</tr>
	";
	
	echo"<a style=\"color:#ff0;\" href=\"reports/print_rek.php\" target=\"_blank\">-= Cetak Ulang Rekening =-</a>";
	
	//header("location:reports/print_rek.php");
	echo"<script type=\"text/javascript\">window.open('reports/".$tujuan.".php','popUpWindow','height=9500,width=2550px,left=10,top=10,scrollbars=yes,menubar=no',top=100,left=500);</script>";
	//echo"<script type=\"text/javascript\">window.print('reports/print_rek.php');</script-->";
}
//=========================================================================
?>
        
		  <br />
		  <?php
          	if($cek!=""){
			  	echo"<script type=\"text/javascript\">document.getElementById(\"htotal\").value=\"$total\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txtotal\").value=\"Rp. ".formatMoney($total).",00\";</script>";
				echo"<script type=\"text/javascript\">document.getElementById(\"txbilang\").value=\"".konversi($total)."Rupiah\";</script>";
								
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
