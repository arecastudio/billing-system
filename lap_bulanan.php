<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
require_once("head.php");

$operator=$_SESSION['nama_user'];
kunci_halaman("util_hapus_tung",$secret,$operator);
?>

<tr>
	<td>
			
		<div class="wrapper">
        <div style="height:auto;overflow:auto">
		<table width="900px" border="1" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
          <tr style="font:calibri;font-size:18px;font-weight:bold;color:#f00;background:linear-gradient(#666,#004);">
              <td colspan="24"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b><marquee behavior="alternate" scrollamount="6" hspace="100">.::  LAPORAN BULANAN TEKNOLOGI INFORMASI ::.</marquee></b></font></center></td>
			<form id="fr1" name="fr1" method="post" action="">
			<tr align="center" >
	      <!--tr style="font:calibri;font-size:18px;font-weight:bold;color:#f00;background:linear-gradient(#666,#004);"-->
          
	        
            <form id="fr1" name="fr1" method="post" action="">
			<tr align="center" height="50">
            
			  <td align="left" height="20" colspan="24">&nbsp;&nbsp;&nbsp;&nbsp;<b>Periode :
			    <select name="optperiode" id="optperiode">
                  	<!--option value="" selected="selected">--Pilih--</option-->
                  	<?php
						$sql=mysql_query("select distinct periode from lap_bulan_ti order by periode");
						while($row=mysql_fetch_row($sql)){
							echo"<option value=". trim($row[0]).">".trim($row[0])."</option>";
						}
					?>
              </select>	&nbsp;&nbsp;&nbsp;&nbsp;		    
			    <input type="submit" name="proses" value="Proses" class="kelas_tombol" /></b></td>
	        <br /></tr>
			</form>
            
           
	                 
      </table>
      </div>
	  <br />

		
		<?php
								if (isset($_POST["proses"])&& $_POST["proses"]=="Proses"){
									//$tawal='2000-01-01';
									//$takhir=date('Y-m-d');
								//	$slipit="";
									//$stbayar=0;
									//$periode=getPeriodeLalu();
									$periode=$_POST["optperiode"];
									//$periode2=$_POST["optperiode2"];
									echo"<script type=\"text/javascript\">document.getElementById(\"optperiode\").value=\"$periode\";</script>";
										
									//}
					
								$sql="select periode,jpr_aktif,jpr_segel,jpr_rusak,jpr_nonmeter,uju_aktif,uju_segel,uju_rusak,uju_nonmeter,abe_aktif,abe_segel,abe_rusak,abe_nonmeter,wna_aktif,wna_segel,wna_rusak,wna_nonmeter,stn_aktif,stn_segel,stn_rusak,stn_nonmeter,gym_aktif,gym_segel,gym_rusak,gym_nonmeter,ubah_nama,ubah_kwm,ubah_gol,meterisasi,pel_hapus,pel_baru,jpr_10,jpr_100,uju_10,uju_100,abe_10,abe_100,wna_10,wna_100,stn_10,stn_100,gym_10,gym_100,format(jml_koreksi_rek,0),format(koreksi_pakai_awal,0),format(koreksi_pakai_akhir,0),format(koreksi_total_awal,0),format(koreksi_total_akhir,0),format(jpr_rusak+jpr_nonmeter,0),format(uju_rusak+uju_nonmeter,0),format(abe_rusak+abe_nonmeter,0),format(wna_rusak+wna_nonmeter,0),format(stn_rusak+stn_nonmeter,0),format(gym_rusak+gym_nonmeter,0),pel_reaktif,format(jpr_1_m3,0),format(jpr_3_m3,0),format(jpr_4_m3,0),format(uju_1_m3,0),format(uju_3_m3,0),format(uju_4_m3,0),format(abe_1_m3,0),format(abe_3_m3,0),format(abe_4_m3,0),format(wna_1_m3,0),format(wna_3_m3,0),format(wna_4_m3,0),format(stn_1_m3,0),format(stn_3_m3,0),format(stn_4_m3,0),format(gym_1_m3,0),format(gym_3_m3,0),format(gym_4_m3,0) from lap_bulan_ti where periode=$periode";
									$query=mysql_query($sql) or die(mysql_error());
									while($row=mysql_fetch_row($query)){
		
		echo"<table background=\"img/grids.gif\" width=\"900px\" align=\"center\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" style=\"box-shadow: 0 0 15px #999;\" class=\"rounded\">
		<tr>
		<td width=\"80%\" align=\"center\">
		<div style=\"height:auto;overflow:auto\">
		<table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"white\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;\">
        <tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td colspan=\"24\" height=\"20\" style=\"background:linear-gradient(#666,#004);font-weight:bold;\"><font face=\"Arial,sans-serif\" size=\"4px\" style=\"padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:12px;\">JUMLAH PEMAKAIAN KONDISI METER SEMUA UPP</font></td>
		    </tr>
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
				<td colspan=\"4\" bgcolor=\"#CC99FF\">JPR</td>
				<td colspan=\"4\" bgcolor=\"#99FFFF\">UJU</td>
				<td colspan=\"4\" bgcolor=\"#9966FF\">ABE</td>
				<td colspan=\"4\" bgcolor=\"#FF66FF\">WNA</td>
				<td colspan=\"4\" bgcolor=\"#FFCCFF\">STN</td>
				<td colspan=\"4\" bgcolor=\"#FFFF66\">GYM</td>
			</tr>
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  <td >2</td>
			  <td >3</td>
			  <td >4</td>
			</tr>
			
			
			";
			
			
					echo"<tr align=\"center\" style=\"background-color:#fff;color:#000;\">";
					echo"<td align=center>".trim($row[1])."</td>";
					echo"<td align=center>".trim($row[2])."</td>";
					echo"<td align=center>".trim($row[3])."</td>";
					echo"<td align=center>".trim($row[4])."</td>";
					echo"<td align=center>".trim($row[5])."</td>";
					echo"<td align=center>".trim($row[6])."</td>";
					echo"<td align=center>".trim($row[7])."</td>";
					echo"<td align=center>".trim($row[8])."</td>";
					echo"<td align=center>".trim($row[9])."</td>";
					echo"<td align=center>".trim($row[10])."</td>";
					echo"<td align=center>".trim($row[11])."</td>";
					echo"<td align=center>".trim($row[12])."</td>";
					echo"<td align=center>".trim($row[13])."</td>";
					echo"<td align=center>".trim($row[14])."</td>";
					echo"<td align=center>".trim($row[15])."</td>";
					echo"<td align=center>".trim($row[16])."</td>";
					echo"<td align=center>".trim($row[17])."</td>";
					echo"<td align=center>".trim($row[18])."</td>";
					echo"<td align=center>".trim($row[19])."</td>";
					echo"<td align=center>".trim($row[20])."</td>";
					echo"<td align=center>".trim($row[21])."</td>";
					echo"<td align=center>".trim($row[22])."</td>";
					echo"<td align=center>".trim($row[23])."</td>";
					echo"<td align=center>".trim($row[24])."</td>";
					echo"</tr>";
					echo"<tr align=\"center\" style=\"background-color:#ccc;color:#000;font-weight:bold;\">";
					echo"<td align=center colspan=\"2\" bgcolor=\"#CC99FF\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[48])."</td>";
					echo"<td align=center colspan=\"2\" bgcolor=\"#99FFFF\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[49])."</td>";
					echo"<td align=center colspan=\"2\" bgcolor=\"#9966FF\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[50])."</td>";
					echo"<td align=center colspan=\"2\" bgcolor=\"#FF66FF\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[51])."</td>";
					echo"<td align=center colspan=\"2\" bgcolor=\"#FFCCFF\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[52])."</td>";
					echo"<td align=center colspan=\"2\" bgcolor=\"#FFFF66\">Jumlah 3+4</td>";
					echo"<td align=center colspan=\"2\">".trim($row[53])."</td>";
					echo"</tr>";					
				
		echo"</table>
		<br />
        
      

		<table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"white\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;\">
        <tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td colspan=\"24\" height=\"20\" style=\"background:linear-gradient(#666,#004);font-weight:bold;\"><font face=\"Arial,sans-serif\" size=\"4px\" style=\"padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:12px;\">JUMLAH PEMAKAIAN M3 SEMUA UPP</font></td>
		    </tr>
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
				<td colspan=\"3\" bgcolor=\"#CC99FF\">JPR</td>
				<td colspan=\"3\" bgcolor=\"#99FFFF\">UJU</td>
				<td colspan=\"3\" bgcolor=\"#9966FF\">ABE</td>
				<td colspan=\"3\" bgcolor=\"#FF66FF\">WNA</td>
				<td colspan=\"3\" bgcolor=\"#FFCCFF\">STN</td>
				<td colspan=\"3\" bgcolor=\"#FFFF66\">GYM</td>
			</tr>
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td >1</td>
			 
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			 
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  
			  <td >3</td>
			  <td >4</td>
			  <td >1</td>
			  
			  <td >3</td>
			  <td >4</td>
			
			  <td >1</td>
			  <td >3</td>
			  <td >4</td>
			</tr>
			
			
			";
			
			
					echo"<tr align=\"center\" style=\"background-color:#fff;color:#000;\">";
					echo"<td align=center>".trim($row[55])."</td>";
					
					echo"<td align=center>".trim($row[56])."</td>";
					echo"<td align=center>".trim($row[57])."</td>";
					echo"<td align=center>".trim($row[58])."</td>";
					
					echo"<td align=center>".trim($row[59])."</td>";
					echo"<td align=center>".trim($row[60])."</td>";
					echo"<td align=center>".trim($row[61])."</td>";
					
					echo"<td align=center>".trim($row[62])."</td>";
					echo"<td align=center>".trim($row[63])."</td>";
					echo"<td align=center>".trim($row[64])."</td>";
					
					echo"<td align=center>".trim($row[65])."</td>";
					echo"<td align=center>".trim($row[66])."</td>";
					echo"<td align=center>".trim($row[67])."</td>";
					
					echo"<td align=center>".trim($row[68])."</td>";
					echo"<td align=center>".trim($row[69])."</td>";
					echo"<td align=center>".trim($row[70])."</td>";
					
					echo"<td align=center>".trim($row[71])."</td>";
					echo"<td align=center>".trim($row[72])."</td>";
					echo"</tr>";
					
						
		
		echo"</table>
        <br />
        
        <table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"white\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;\">
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td colspan=\"24\" height=\"20\" style=\"background:linear-gradient(#666,#004);font-weight:bold;\"><font face=\"Arial,sans-serif\" size=\"4px\" style=\"padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:12px;\">JUMLAH PERUBAHAN PELANGGAN</font></td>
		    </tr>
			<tr align=\"center\" style=\"background-color:#ccC;color:#000;font-weight:bold;\">
				<td>PERUBAHAN NAMA</td>
				<td>PERUBAHAN STATUS</td>
				<td>PERUBAHAN GOL</td>
				<td>METERISASI</td>
				<td>PELANGGAN HAPUS</td>
			    <td>PELANGGAN BARU</td>
				<td>AKTIF KEMBALI</td>
			</tr>
		";
			
					echo"<tr align=\"center\" style=\"background-color:#fff;color:#000;\">";
					echo"<td align=center>".trim($row[25])."</td>";
					echo"<td align=center>".trim($row[26])."</td>";
					echo"<td align=center>".trim($row[27])."</td>";
					echo"<td align=center>".trim($row[28])."</td>";
					echo"<td align=center>".trim($row[29])."</td>";
					echo"<td align=center>".trim($row[30])."</td>";
					echo"<td align=center>".trim($row[54])."</td>";
					echo"</tr>";					
						
			
       echo"</table>
		
		<br/>
           
        <table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"white\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;\">
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td colspan=\"24\" height=\"20\" style=\"background:linear-gradient(#666,#004);font-weight:bold;\"><font face=\"Arial,sans-serif\" size=\"4px\" style=\"padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:12px;\">JUMLAH PEMAKAIAN KECIL DAN BESAR SEMUA UPP</font></td>
		    </tr>
			<tr align=\"center\" style=\"background-color:#ccC;color:#000;font-weight:bold;\">
				<td colspan=\"2\" bgcolor=\"#CC99FF\">JPR</td>
				<td colspan=\"2\" bgcolor=\"#99FFFF\">UJU</td>
				<td colspan=\"2\" bgcolor=\"#9966FF\">ABE</td>
				<td colspan=\"2\" bgcolor=\"#FF66FF\">WNA</td>
				<td colspan=\"2\" bgcolor=\"#FFCCFF\">STN</td>
				<td colspan=\"2\" bgcolor=\"#FFFF66\">GYM</td>
			</tr>
			
			<tr align=\"center\" style=\"background-color:#ccC;color:#000;font-weight:bold;\">
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			  <td>Pakai 10</td>
			  <td>Pakai >100</td>
			</tr>
        ";
		
					echo"<tr align=\"center\" style=\"background-color:#fff;color:#000;\">";
                    echo"<td align=center>".trim($row[31])."</td>";
					echo"<td align=center>".trim($row[32])."</td>";
					echo"<td align=center>".trim($row[33])."</td>";
					echo"<td align=center>".trim($row[34])."</td>";
					echo"<td align=center>".trim($row[35])."</td>";
					echo"<td align=center>".trim($row[36])."</td>";
					echo"<td align=center>".trim($row[37])."</td>";
					echo"<td align=center>".trim($row[38])."</td>";
					echo"<td align=center>".trim($row[39])."</td>";
					echo"<td align=center>".trim($row[40])."</td>";
					echo"<td align=center>".trim($row[41])."</td>";
					echo"<td align=center>".trim($row[42])."</td>";
                    echo"</tr>";				
				
				
			
       echo"</table>
        <br/>
                
        <table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" bgcolor=\"white\" style=\"border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;\">
			<tr align=\"center\" style=\"background-color:#FFC;color:#000;font-weight:bold;\">
			  <td colspan=\"24\" height=\"20\" style=\"background:linear-gradient(#666,#004);font-weight:bold;\"><font face=\"Arial,sans-serif\" size=\"4px\" style=\"padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:12px;\">JUMLAH KOREKSI REKENING</font></td>
		    </tr>
			<tr align=\"center\" style=\"background-color:#ccC;color:#000;font-weight:bold;\">
				<td >JML KOREKSI REK</td>
				<td >KOREKSI AWAL</td>
				<td >KOREKSI AKHIR</td>
				<td >TOTAL KOREKSI AWAL</td>
				<td >TOTAL KOREKSI AKHIR</td>
		    </tr>
			";
			
		
					echo"<tr align=\"center\" style=\"background-color:#fff;color:#000;\">";
					echo"<td align=center>".trim($row[43])."</td>";
					echo"<td align=center>".trim($row[44])."</td>";
					echo"<td align=center>".trim($row[45])."</td>";
					echo"<td align=center>".trim($row[46])."</td>";
					echo"<td align=center>".trim($row[47])."</td>";
					
					echo"</tr>";					
				//}
				//echo"<tr><td colspan=24>$sql</td></tr>";
							}
				}
					?>						
        </table>
		<!--######################################################################-->
		
	  </div>
	
	
	<!--/td>
</tr-->

<?php
putus();
//require_once("foot.php");
?>
