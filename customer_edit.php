<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();

$operator=$_SESSION['nama_user'];
kunci_halaman("ubah_data_pel",$secret,$operator);

$nmr="";
$nlama="";
$nama="";
$cabang="";
$cnama="";
$wilayah="";
$wnama="";
$blok="";
$bnama="";
$dkd="";
$dnama="";
$alamat="";
$norumah="";
$rt="";
$rw="";
$kode_pos="";
$no_telp="";
$no_hp="";
$no_ktp="";
$no_sim="";
$npwp="";
$golongan="";
$gnama="";
$kwm="";
$merk="";
$mrnama="";
$nometer="";
$meter="";
$mtnama="";
$tpasang="";
$tinput="";
$jpel="";
$jpnama="";
$online="";
$putus="";
?>
 <!--focus kursor -->
<script type="text/javascript" language="javascript">
	 $(function() {
    
	   $("#txnomor").focus();
       
    });
</script>
	<tr>
		<td>		
			<br />
            <table width="800px" border="0" align="center"  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;" background="img/grids.gif">
            	<tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
            	  <td colspan="4"><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.:: Ganti Data Pelanggan ::.</td>
          	  </tr>
            	<tr>
                	<td width="100%">
                    	<table  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background-color:#f0f0f0;">
                        	<tr>
                            	<td width="120px">Nomor/NoLama</td>
                                <form name="f1" method="post" action="">
                                <td><input type="text" id="txnomor" name="txnomor" maxlength="13" size="15" />
                                	&nbsp;<input type="submit" name="submit" value="Tampilkan!" />
                                    &nbsp;&nbsp;<input type="button" name="cr" value="Cari" class="kelas_tombol"  onclick="window.open('cari.php','popUpWindow','height=400,width=800,left=10,top=10,scrollbars=yes,menubar=no'); return false;" />                                </td>
                                </form>
                                <?php
                                if(isset($_POST['submit'])){
									if($_POST['txnomor']!=''){
										$nomor=$_POST['txnomor'];
										echo"<script type=\"text/javascript\">document.getElementById(\"txnomor\").value=\"$nomor\";</script>";
										$sql="
										SELECT m.nomor, m.nolama, m.nama, m.cabang, c.nama, m.kode_wilayah, w.nama_wilayah, m.kode_blok, b.ket_blok, m.dkd, d.jalan, m.alamat, m.norumah, m.rt, m.rw, m.kode_pos, m.no_telp, m.no_hp, m.no_ktp, m.no_sim, m.npwp,
										m.gol, (SELECT DISTINCT tr.keterangan FROM tarif AS tr WHERE tr.gol=m.gol LIMIT 0,1) AS ket, m.kondisi_meter, m.merk, mr.nama, m.nometer, m.ukuran, mt.ukuran, m.tglstart, m.tgl_input, m.jenis_pel, pj.ket_jenis_pel, m.online, IF(m.putus='0','0 (SAMBUNG)',if(m.putus='3','3 (PUTUS)','5 (BONGKAR)')),m.putus
										FROM master AS m
										LEFT OUTER JOIN cabang AS c ON c.cabang=m.cabang
										LEFT OUTER JOIN master_wilayah AS w ON w.kode_wilayah=m.kode_wilayah
										LEFT OUTER JOIN master_blok AS b ON b.kode_blok=m.kode_blok
										LEFT OUTER JOIN dkd AS d ON d.dkd=m.dkd
										LEFT OUTER JOIN merk AS mr ON mr.merk=m.merk
										LEFT OUTER JOIN meter AS mt ON mt.kode=m.ukuran
										LEFT OUTER JOIN pel_jenis AS pj ON pj.kode_jenis_pel=m.jenis_pel
										WHERE (m.nomor='$nomor' OR m.nolama='$nomor')  AND (m.putus='0')
										LIMIT 0,1
										;";										
										$qry=mysql_query($sql)or die(mysql_error());
										if($row=mysql_fetch_row($qry)){
											$nmr=$row[0];
											$nlama=$row[1];
											$nama=$row[2];
											$cabang=$row[3];
											$cnama=$row[4];
											$wilayah=$row[5];
											$wnama=$row[6];
											$blok=$row[7];
											$bnama=$row[8];
											$dkd=$row[9];
											$dnama=$row[10];
											$alamat=$row[11];
											$norumah=$row[12];
											$rt=$row[13];
											$rw=$row[14];
											$kode_pos=$row[15];
											$no_telp=$row[16];
											$no_hp=$row[17];
											$no_ktp=$row[18];
											$no_sim=$row[19];
											$npwp=$row[20];
											$golongan=$row[21];
											$gnama=$row[22];
											$kwm=$row[23];
											$merk=$row[24];
											$mrnama=$row[25];
											$nometer=$row[26];
											$meter=$row[27];
											$mtnama=$row[28];
											$tpasang=$row[29];
											$tinput=$row[30];
											$jpel=$row[31];
											$jpnama=$row[32];
											$online=$row[33];
											$putus=$row[34];
											$stat_putus=$row[35];
										}else{
											echo"<script type=\"text/javascript\">alert('Pelanggan tidak ditemukan dalam Data Pelanggan Aktif!');</script>";
										}
									}
								}
								?>
                                <form name="f2" method="post" action="">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="simpan" value="Simpan" /></td>
                            </tr>
                        </table>                    </td>
                </tr>
                <tr>
                	<td>
                    	<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#ffc;font-family:calibri;font-size:12px;">
                        	
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Nomor</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $nmr;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Nomor</td>
                                <td width="25%">&nbsp;<input type="text" id="txnmr" name="txnmr" maxlength="6" size="6" value="<?php if(isset($_POST['submit'])) echo $nmr;?>" readonly /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No Lama</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $nlama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No Lama</td>
                                <td width="25%">&nbsp;<input type="text" id="txnlama" name="txnlama" readonly maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $nlama;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Nama</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $nama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Nama</td>
                                <td width="25%">&nbsp;<input type="text" id="txnama" name="txnama" readonly maxlength="50" size="30" value="<?php if(isset($_POST['submit'])) echo $nama;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Cabang</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $cabang." - ".$cnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Cabang</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optcabang" id="optcabang" >
                                        <!--option value="" selected="selected"><--?php if(isset($_POST['submit'])){echo $cabang." - ".$cnama;}else{echo"--Pilih--";}?--></option-->
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("select cabang,nama from cabang order by cabang");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optcabang\").value=\"$cabang\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Wilayah</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $wilayah." - ".$wnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Wilayah</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optwilayah" id="optwilayah" >
                                        <!--option value="" selected="selected"><--?php if(isset($_POST['submit'])){echo $cabang." - ".$cnama;}else{echo"--Pilih--";}?--></option-->
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT kode_wilayah,nama_wilayah FROM master_wilayah WHERE kode_wilayah<>'' ORDER BY kode_wilayah");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optwilayah\").value=\"$wilayah\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Blok</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $blok." - ".$bnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Blok</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optblok" id="optblok" >
                                        <!--option value="" selected="selected"><--?php if(isset($_POST['submit'])){echo $cabang." - ".$cnama;}else{echo"--Pilih--";}?--></option-->
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT kode_blok FROM master_blok ORDER BY kode_blok");//ket_blok
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optblok\").value=\"$blok\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">DKD/WPT</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $dkd." - ".$dnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">DKD/WPT</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optdkd" id="optdkd" >
                                        <!--option value="" selected="selected"><--?php if(isset($_POST['submit'])){echo $cabang." - ".$cnama;}else{echo"--Pilih--";}?--></option-->
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT dkd,jalan FROM dkd ORDER BY dkd");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optdkd\").value=\"$dkd\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Alamat</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $alamat;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Alamat</td>
                                <td width="25%">&nbsp;<input type="text" id="txalamat" name="txalamat" maxlength="50" size="40" value="<?php if(isset($_POST['submit'])) echo $alamat;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. Rumah</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $norumah;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. Rumah</td>
                                <td width="25%">&nbsp;<input type="text" id="txnorumah" name="txnorumah" maxlength="5" size="5" value="<?php if(isset($_POST['submit'])) echo $norumah;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">RT</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $rt;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">RT</td>
                                <td width="25%">&nbsp;<input type="text" id="txrt" name="txrt" maxlength="5" size="5" value="<?php if(isset($_POST['submit'])) echo $rt;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">RW</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $rw;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">RW</td>
                                <td width="25%">&nbsp;<input type="text" id="txrw" name="txrw" maxlength="5" size="5" value="<?php if(isset($_POST['submit'])) echo $rw;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Kode POS</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $kode_pos;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Kode POS</td>
                                <td width="25%">&nbsp;<input type="text" id="txkodepos" name="txkodepos" maxlength="5" size="5" value="<?php if(isset($_POST['submit'])) echo $kode_pos;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. Telepon</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $no_telp;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. Telepon</td>
                                <td width="25%">&nbsp;<input type="text" id="txnotelp" name="txnotelp" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $no_telp;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. HP</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $no_hp;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. HP</td>
                                <td width="25%">&nbsp;<input type="text" id="txnohp" name="txnohp" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $no_hp;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. KTP</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $no_ktp;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. KTP</td>
                                <td width="25%">&nbsp;<input type="text" id="txnoktp" name="txnoktp" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $no_ktp;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. SIM</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $no_sim;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. SIM</td>
                                <td width="25%">&nbsp;<input type="text" id="txnosim" name="txnosim" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $no_sim;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">NPWP</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $npwp;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">NPWP</td>
                                <td width="25%">&nbsp;<input type="text" id="txnpwp" name="txnpwp" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $npwp;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Gol</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $golongan." - ".$gnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Gol</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optgol" id="optgol" >                                       
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT DISTINCT gol,keterangan FROM tarif ORDER BY gol");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optgol\").value=\"$golongan\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Kondisi Meter</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $kwm." - ".kondisi_wm($kwm);?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Kondisi Meter</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optkwm" id="optkwm" disabled >
                                    <?php
                                    /*if ($kwm=='2'){
                                        echo"<option value=\"2\">2 - METER SEGEL</option>";
                                    }else{
                                        echo"<option value=\"\" selected=\"selected\">--Pilih--</option>
                                        <option value=\"1\">1 - METER BAIK</option>                                        
                                        <option value=\"3\">3 - METER RUSAK</option>
                                        <option value=\"4\">4 - TANPA METER</option>";
                                    }*/ 

                                    switch ($kwm) {
                                        case '4':
                                            # code...
                                            echo"<option value=\"4\">4 - TANPA METER</option>";
                                            break;
                                        case '3':
                                            echo "<option value=\"3\">3 - METER RUSAK</option>";
                                            break;
                                        case '2':
                                            # code...
                                            echo"<option value=\"2\">2 - METER SEGEL</option>";
                                            break;
                                        default:
                                            # code...
                                            echo "<option value=\"1\">1 - METER BAIK</option>";
                                            break;
                                    }

                                    ?> 
                                    </select>
<a href="ubah_kwm.php" style="font-style:italic;font-size:80%;color:#d00;">klik di sini untuk ubah KWM</a>

                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optkwm\").value=\"$kwm\";</script>"; ?>                                 </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Merk</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $merk." - ".$mrnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Merk</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optmerk" id="optmerk" disabled >                                       
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT DISTINCT merk,nama FROM merk ORDER BY merk");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optmerk\").value=\"$merk\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">No. Seri W.M.</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $nometer;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">No. Ser W.M.</td>
                                <td width="25%">&nbsp;<input type="text" id="txnometer" disabled name="txnometer" maxlength="15" size="15" value="<?php if(isset($_POST['submit'])) echo $nometer;?>"  /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Diameter Pipa</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $mtnama."\"";?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Diameter Pipa</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optmeter" id="optmeter" disabled >                                       
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT DISTINCT kode,ukuran FROM meter ORDER BY kode");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optmeter\").value=\"$meter\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Tgl Pasang</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $tpasang;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Tgl Pasang</td>
                                <td width="25%">&nbsp;<input type="text" id="txtpasang" name="txtpasang" maxlength="15" size="15" readonly value="<?php if(isset($_POST['submit'])) echo $tpasang;?>" class="datepicker22" /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Tgl Input</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $tinput;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Tgl Ubah</td>
                                <td width="25%">&nbsp;<input type="text" id="txtinput" name="txtinput" maxlength="15" size="15" readonly value="<?php if(isset($_POST['submit'])) echo date('Y-M-d');?>" class="datepicker22" /></td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Jenis Pelanggan</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $jpel." - ".$jpnama;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Jenis Pelanggan</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optjpel" id="optjpel" >                                       
                                        <option value="" selected="selected">--Pilih--</option>
                                        <?php
                                        $sql=mysql_query("SELECT DISTINCT kode_jenis_pel,ket_jenis_pel FROM pel_jenis ORDER BY kode_jenis_pel");
                                        while($row=mysql_fetch_row($sql)){
                                            echo"<option value=". trim($row[0]).">".trim($row[1])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optjpel\").value=\"$jpel\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Online</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $online;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">Online</td>
                                <td width="25%">&nbsp;                                
                                	<select name="optonline" id="optonline" >
                                    	<option value="" selected="selected">--Pilih--</option>
                                        <option value="YA">YA</option>
                                        <option value="TIDAK">TIDAK</option>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optonline\").value=\"$online\";</script>"; ?>                                </td>
                            </tr>
                            <tr>
                            	<td width="10%" align="right" bgcolor="#F0F0F0">Stat.</td>
                                <th width="25%" align="left">&nbsp;<?php if(isset($_POST['submit'])) echo $putus;?></th>
                                <td width="10%" align="right" bgcolor="#F0F0F0">&nbsp;Stat</td>
                                <td width="25%">&nbsp;
                                	<select name="optstat" id="optstat" disabled >
                                    	<option value="" selected="selected">--Pilih--</option>
                                        <option value="0">SAMBUNG</option>
                                        <option value="3">PUTUS</option>
                                        <option value="5">BONGKAR</option>
                                    </select>
                                    <?php if(isset($_POST['submit'])) echo"<script type=\"text/javascript\">document.getElementById(\"optstat\").value=\"$stat_putus\";</script>"; ?>                                </td>
                            </tr>
                            </form>
                        </table>                    </td>
                </tr>
            </table>
	  </td>
	</tr>
	<?php
    if(isset($_POST['simpan'])&&$_POST['txnmr']!=''){
		//echo $nama;
		$nmr=$_POST['txnmr'];
		$nlama=$_POST['txnlama'];
		$nama=$_POST['txnama'];
		$cabang=$_POST['optcabang'];
		//$cnama=$_POST['optwilayah'];
		$wilayah=$_POST['optwilayah'];
		///$wnama=$row[6];
		$blok=$_POST['optblok'];
		//$bnama=$row[8];
		$dkd=$_POST['optdkd'];
		//$dnama=$row[10];
		$alamat=$_POST['txalamat'];
		$norumah=$_POST['txnorumah'];
		$rt=$_POST['txrt'];
		$rw=$_POST['txrw'];
		$kode_pos=$_POST['txkodepos'];
		$no_telp=$_POST['txnotelp'];
		$no_hp=$_POST['txnohp'];
		$no_ktp=$_POST['txnoktp'];
		$no_sim=$_POST['txnosim'];
		$npwp=$_POST['txnpwp'];
		$golongan=$_POST['optgol'];
		//$gnama=$row[22];
		$kwm=$_POST['optkwm'];
		$merk=$_POST['optmerk'];
		//$mrnama=$row[25];
		$nometer=$_POST['txnometer'];
		$meter=$_POST['optmeter'];
		//$mtnama=$row[28];
		$tpasang=$_POST['txtpasang'];
		$tinput=date('Y-m-d');//$_POST['txtinput'];
		$jpel=$_POST['optjpel'];
		//$jpnama=$row[32];
		$online=$_POST['optonline'];
		$stat_putus=$_POST['optstat'];
		
		$sql789="
		UPDATE master
		SET nolama='$nlama', nama='$nama', cabang='$cabang', kode_wilayah='$wilayah', kode_blok='$blok', dkd='$dkd', alamat='$alamat', norumah='$norumah', rt='$rt', rw='$rw', kode_pos='$kode_pos', no_telp='$no_telp', no_hp='$no_hp', no_ktp='$no_ktp', no_sim='$no_sim', npwp='$npwp',
		gol='$golongan', merk='$merk', nometer='$nometer', ukuran='$meter', nu='$tinput', jenis_pel='$jpel', online='$online'
		WHERE nomor='$nmr'
		;";
		
		$sql="
		UPDATE master
		SET nolama='$nlama', nama='$nama', cabang='$cabang', kode_wilayah='$wilayah', kode_blok='$blok', dkd='$dkd', alamat='$alamat', norumah='$norumah', rt='$rt', rw='$rw', kode_pos='$kode_pos', no_telp='$no_telp', no_hp='$no_hp', no_ktp='$no_ktp', no_sim='$no_sim', npwp='$npwp',
		nu='$tinput', jenis_pel='$jpel', online='$online'
		WHERE nomor='$nmr'
		;";
		
		$query=mysql_query($sql)or die(mysql_error());
		if($query)echo"<script type=\"text/javascript\">alert('Data tersimpan!');</script>";
	}	
	?>
    
<?php
//mysql_close();
putus();
require_once("foot.php");
?>
