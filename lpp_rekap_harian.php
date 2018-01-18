<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
$operator=$_SESSION['nama_user'];
kunci_halaman("util_rekap_lpp_harian",$secret,$operator);

?>
<!--head>
<meta http-equiv="refresh" content="5">
</head-->


	<tr>
		<td><br />
		<!--############################################################################################################-->
		
				
		<table width="920px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <form id="fr1" name="fr1" method="post" action="" onSubmit="">
            <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
              <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.::  Rekap LPP Harian Semua Loket ::.</b></font></center></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
                <!--########################################################################################-->                
              <td><input type="checkbox" name="chtgl" checked="checked">Tgl. Trans.</td>
              <td>
					<input type="text" size="11" maxlength="10" name="txtawal" id="txtawal" class="datepicker" value="<?php echo date('Y-m-d');?>"  />
					&nbsp;<i>s/d</i>&nbsp;
					<input type="text" size="11" maxlength="10" name="txtakhir" id="txtakhir" class="datepicker" value="<?php echo date('Y-m-d');?>" />
					[YYYY-MM-DD]			  </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right">.</td>
           	  <td>&nbsp;</td>
            </tr>
            
			<tr>
				<td><!--input type="radio" name="r1" id="rallupp"  value="all"/-->
				&nbsp;
                <input type="hidden" id="dik" name="dik" />                </td>
				<td colspan="2"></td>
				<td align="right">
					<input type="submit" name="proses" value="Proses" class="kelas_tombol" />
                   
                                      
                  	<!--input type="button" name="batal" value="Batal"  class="kelas_tombol" onclick="" /-->				</td>
			</tr>
          </form>
		  </table>
		  <br />
		  
		  <table width="1224px" align="center" border="0" cellpadding="2" cellspacing="2" style="box-shadow: 0 0 15px #999;" background="img/grids.gif" class="rounded">
			<tr>
				<td width="100%" align="center">
					<div style="height:300px;overflow:auto">
						<table width="100%" border="1" cellpadding="1" cellspacing="1" align="center" bgcolor="white" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;" >
							
							<?php

								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									$tawal=$_POST["txtawal"];
									$takhir=$_POST["txtakhir"];
									$slipit="";
									$stbayar=0;
									//$periode=getPeriodeLalu();
											if(isset($_POST['chtgl'])){
										if(($key1=$_POST['txtawal'])!=''){
											$tawal=$key1;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtawal\").value=\"$key1\";</script>";
										}
										if(($key2=$_POST['txtakhir'])!=''){
											$takhir=$key2;
											echo"<script type=\"text/javascript\">document.getElementById(\"txtakhir\").value=\"$key2\";</script>";

										}
									}								
										

										$sql2="
										SELECT distinct z.tbayar,count(u.nomor) as uju,count(a.nomor) as abe,count(w.nomor) as wna,count(s.nomor) as stn,count(j.nomor) as jpr,count(d.nomor) as bpd,count(i.nomor) as brv,count(p.nomor)as pos,count(f.nomor)as fkt,count(l.nomor)as pol,count(t.nomor)as tni,sum(ur.uangair + ur.adm + ur.meterai + ur.meter + ur.denda)as ruju,sum(ar.uangair + ar.adm + ar.meterai + ar.meter + ar.denda)as rabe,sum(wr.uangair + wr.adm + wr.meterai + wr.meter + wr.denda)as wwna,sum(sr.uangair + sr.adm + sr.meterai + sr.meter + sr.denda)as sstn,sum(jr.uangair + jr.adm + jr.meterai + jr.meter + jr.denda)as jjpr,sum(dr.uangair + dr.adm + dr.meterai + dr.meter + dr.denda)as dbpd,sum(ir.uangair + ir.adm + ir.meterai + ir.meter + ir.denda)as ibrv,sum(pr.uangair + pr.adm + pr.meterai + pr.meter + pr.denda)as ppos,sum(fr.uangair + fr.adm + fr.meterai + fr.meter + fr.denda)as ffkt,sum(lr.uangair + lr.adm + lr.meterai + lr.meter + lr.denda)as lpol,sum(tr.uangair + tr.adm + tr.meterai + tr.meter + tr.denda)as ttni,sum(r.uangair + r.adm + r.meterai + r.meter + r.denda)as rtotal,
										count(n.nomor)as bni,
										sum(nr.uangair + nr.adm + nr.meterai + nr.meter + nr.denda)as tbni
										from transaksi as z
										INNER JOIN rekening1 as r on r.nomor=z.nomor and r.periode=z.periode and r.status_bayar=1
										LEFT OUTER JOIN transaksi as u ON u.nomor=z.nomor and u.periode=z.periode and u.loket='uju' and (u.tbayar between '$tawal' and '$takhir')  and u.batal=0
										LEFT OUTER JOIN transaksi as a ON a.nomor=z.nomor and a.periode=z.periode and a.loket='abe' and (a.tbayar between '$tawal' and '$takhir') and a.batal=0
										LEFT OUTER JOIN transaksi as w ON w.nomor=z.nomor and w.periode=z.periode and w.loket='wna' and (w.tbayar between '$tawal' and '$takhir') and w.batal=0
										LEFT OUTER JOIN transaksi as s ON s.nomor=z.nomor and s.periode=z.periode and s.loket='stn' and (s.tbayar between '$tawal' and '$takhir') and s.batal=0
										LEFT OUTER JOIN transaksi as j ON j.nomor=z.nomor and j.periode=z.periode and j.loket='jpr' and (j.tbayar between '$tawal' and '$takhir') and j.batal=0
										LEFT OUTER JOIN transaksi as d ON d.nomor=z.nomor and d.periode=z.periode and d.loket='bpd' and (d.tbayar between '$tawal' and '$takhir') and d.batal=0
										LEFT OUTER JOIN transaksi as i ON i.nomor=z.nomor and i.periode=z.periode and i.loket='brv' and (i.tbayar between '$tawal' and '$takhir') and i.batal=0
										LEFT OUTER JOIN transaksi as p ON p.nomor=z.nomor and p.periode=z.periode and p.loket='pos' and (p.tbayar between '$tawal' and '$takhir') and p.batal=0
										LEFT OUTER JOIN transaksi as f ON f.nomor=z.nomor and f.periode=z.periode and f.loket='fkt' and (f.tbayar between '$tawal' and '$takhir') and f.batal=0
										LEFT OUTER JOIN transaksi as l ON l.nomor=z.nomor and l.periode=z.periode and l.loket='pol' and (l.tbayar between '$tawal' and '$takhir') and l.batal=0
										LEFT OUTER JOIN transaksi as t ON t.nomor=z.nomor and t.periode=z.periode and t.loket='tni' and (t.tbayar between '$tawal' and '$takhir') and t.batal=0
										LEFT OUTER JOIN transaksi as n ON n.nomor=z.nomor and n.periode=z.periode and n.loket='bni' and (n.tbayar between '$tawal' and '$takhir') and n.batal=0
										LEFT OUTER JOIN rekening1 as ur ON ur.nomor=z.nomor and ur.periode=z.periode and z.loket='uju' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as ar ON ar.nomor=z.nomor and ar.periode=z.periode and z.loket='abe' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as wr ON wr.nomor=z.nomor and wr.periode=z.periode and z.loket='wna' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as sr ON sr.nomor=z.nomor and sr.periode=z.periode and z.loket='stn' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as jr ON jr.nomor=z.nomor and jr.periode=z.periode and z.loket='jpr' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as dr ON dr.nomor=z.nomor and dr.periode=z.periode and z.loket='bpd' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as ir ON ir.nomor=z.nomor and ir.periode=z.periode and z.loket='brv' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as pr ON pr.nomor=z.nomor and pr.periode=z.periode and z.loket='pos' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as fr ON fr.nomor=z.nomor and fr.periode=z.periode and z.loket='fkt' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as lr ON lr.nomor=z.nomor and lr.periode=z.periode and z.loket='pol' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as tr ON tr.nomor=z.nomor and tr.periode=z.periode and z.loket='tni' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										LEFT OUTER JOIN rekening1 as nr ON nr.nomor=z.nomor and nr.periode=z.periode and z.loket='bni' and (z.tbayar between '$tawal' and '$takhir')  and z.batal=0
										where z.batal=0 and (z.tbayar between '$tawal' and '$takhir') GROUP BY z.tbayar
										
										
										";																		
										$qry=mysql_query($sql2)or die("err: ".mysql_error());
										 
										echo "
										<tr align=\"center\" style=\"background:linear-gradient(#fff,#ccc);color:#000;font-weight:bold;\">
											<td>No.</td>
											<td>Tgl</td>
											<td>UJU<br>(Lmbr)</td>
											<td>Rp</td>
											<td>ABE<br>(Lmbr)</td>
											<td>Rp</td>
											<td>WNA<br>(Lmbr)</td>
											<td>Rp</td>
											<td>STN<br>(Lmbr)</td>
											<td>Rp</td>
											<td>JPR<br>(Lmbr)</td>
											<td>Rp</td>
											<td>BPD<br>(Lmbr)</td>
											<td>Rp</td>
											<!--td>BRI<br>(Lmbr)</td>
											<td>Rp</td-->
											<td>POS<br>(Lmbr)</td>
											<td>Rp</td>
											<td>BNI<br/>Lmbr</td>
											<td>Rp</td>
											<td>FKT<br>(Lmbr)</td>
											<td>Rp</td>
											<td>POL<br>(Lmbr)</td>
											<td>Rp</td>
											<td>TNI<br>(Lmbr)</td>
											<td>Rp</td>
											<td>TOTAL<br>(Lmbr)</td>
											<td>Rp</td>
											
											
										</tr>
										";
										
										$i=0;
										$total=0;
										$U1=0;
										$A2=0;
										$W3=0;
										$S4=0;
										$J5=0;
										$B6=0;
										$B7=0;
										$P8=0;
										$F9=0;
										$P10=0;
										$T11=0;
										$T12=0;
										$U11=0;
										$A22=0;
										$W33=0;
										$S44=0;
										$J55=0;
										$B66=0;
										//$B77=0;
										$P88=0;
										$F99=0;
										$P100=0;
										$T111=0;
										$T122=0;
										$N1=0;
										$N2=0;
										while($row=mysql_fetch_row($qry)){
											$i++;
											
											$total=$row[5]+$row[1]+$row[2]+$row[3]+$row[4]+$row[6]+$row[7]+$row[8]+$row[9]+$row[10]+$row[11]+$row[24];

											$UJU=$row[1];$U11=$U11+$UJU;
											$ABE=$row[2];$A22=$A22+$ABE;
											$WNA=$row[3];$W33=$W33+$WNA;
											$STN=$row[4];$S44=$S44+$STN;
											$JPR=$row[5];$J55=$J55+$JPR;
											$BPD=$row[6];$B66=$B66+$BPD;
											$BRV=$row[7];//$B77=$B77+$BRV;
											$POS=$row[8];$P88=$P88+$POS;
											$FKT=$row[9];$F99=$F99+$FKT;
											$POL=$row[10];$P100=$P100+$POL;
											$TNI=$row[11];$T111=$T111+$TNI;
											$RUJU=$row[12];$U1=$U1+$RUJU;
											$RABE=$row[13];$A2=$A2+$RABE;
											$RWNA=$row[14];$W3=$W3+$RWNA;
											$RSTN=$row[15];$S4=$S4+$RSTN;
											$RJPR=$row[16];$J5=$J5+$RJPR;
											$RBPD=$row[17];$B6=$B6+$RBPD;
											//$RBRV=$row[18];$B7=$B7+$RBRV;
											$RPOS=$row[19];$P8=$P8+$RPOS;
											$RFKT=$row[20];$F9=$F9+$RFKT;
											$RPOL=$row[21];$P10=$P10+$RPOL;
											$RTNI=$row[22];$T11=$T11+$RTNI;
											$RTOTAL=$row[23];$T12=$T12+$RTOTAL;$T122=$T122+$total;
											$BNI=$row[24];$N1=$N1+$BNI;
											$RBNI=$row[25];$N2=$N2+$RBNI;
											
																		
											
											echo"
											<tr>
												<td align=center>$i</td>
												<td align=center>$row[0]</td>
												<td align=center>$UJU</td>
												<td align=right>".formatMoney($RUJU)."</td>
												<td align=center>$ABE</td>
												<td align=right>".formatMoney($RABE)."</td>
												<td align=center>$WNA</td>
												<td align=right>".formatMoney($RWNA)."</td>
												<td align=center>$STN</td>
												<td align=right>".formatMoney($RSTN)."</td>
												<td align=center>$JPR</td>
												<td align=right>".formatMoney($RJPR)."</td>
												<td align=center>$BPD</td>
												<td align=right>".formatMoney($RBPD)."</td>
												<!--td align=center>$BRV</td>
												<td align=right>".formatMoney($RBRV)."</td-->
												<td align=center>$POS</td>
												<td align=right>".formatMoney($RPOS)."</td>
												<td align=center>$BNI</td>
												<td align=right>".formatMoney($RBNI)."</td>
												<td align=center>$FKT</td>
												<td align=right>".formatMoney($RFKT)."</td>
												<td align=center>$POL</td>
												<td align=right>".formatMoney($RPOL)."</td>
												<td align=center>$TNI</td>
												<td align=right>".formatMoney($RTNI)."</td>
												<td align=center>$total</td>
												<td align=right>".formatMoney($RTOTAL)."</td>
												
												</tr>
												";
												
												
												
												}
												
												
												
												echo"
											<tr bgcolor=\"#CCCCCC\" style=\"font:sans-serif;font-size:12px;font-weight:bold;\">
												<td colspan=\"2\" align=center>TOTAL</td>
												
												<td align=center>".formatMoney($U11)."</td>
												<td align=right>".formatMoney($U1)."</td>
												<td align=center>".formatMoney($A22)."</td>
												<td align=right>".formatMoney($A2)."</td>
												<td align=center>".formatMoney($W33)."</td>
												<td align=right>".formatMoney($W3)."</td>
												<td align=center>".formatMoney($S44)."</td>
												<td align=right>".formatMoney($S4)."</td>
												<td align=center>".formatMoney($J55)."</td>
												<td align=right>".formatMoney($J5)."</td>
												<td align=center>".formatMoney($B66)."</td>
												<td align=right>".formatMoney($B6)."</td>
												<!--td align=center>".formatMoney($B77)."</td-->
												<!--td align=right>".formatMoney($B7)."</td-->
												<td align=center>".formatMoney($P88)."</td>
												<td align=right>".formatMoney($P8)."</td>
												<td align=center>".formatMoney($N1)."</td>
												<td align=right>".formatMoney($N2)."</td>
												<td align=center>".formatMoney($F99)."</td>
												<td align=right>".formatMoney($F9)."</td>
												<td align=center>".formatMoney($P100)."</td>
												<td align=right>".formatMoney($P10)."</td>
												<td align=center>".formatMoney($T111)."</td>
												<td align=right>".formatMoney($T11)."</td>
												<td align=center>".formatMoney($T122)."</td>
												<td align=right>".formatMoney($T12)."</td>
												
												</tr>
												";
												}
												?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
			<td align="left" style="font:Verdana, Arial, Helvetica, sans-serif;font-size:9px;">
				<?php
               if(isset($_POST["rjrep"])&& $_POST["rjrep"]=="rjrekap"){
					$tujuan="reports/print_report_lpp_rekap.php";
				}else{
					$tujuan="reports/print_report_lpp.php";
				}
				?>
                <a href="<!?php echo $tujuan; ?>" target="_blank" style="font-size:16px;color:#FF0000;font-weight:bold;">-= Cetak Report =-</a>
				<!--<input type="checkbox" name="chcustprint" value="customprint" />Custom -=>-->
		
			</td>
		</tr>
		</table>

		 
		  <!--############################################################################################################-->
	  </td>
	</tr>
	
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
