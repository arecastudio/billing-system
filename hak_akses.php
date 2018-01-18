<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("hak_akses",$secret,$operator);

$m_file=0;
$m_informasi_pelanggan=0;
$m_pengisian_pelanggan_baru=0;
$m_isi_pelanggan_kolektif=0;
$m_pemakaian_air_non_meter=0;
$m_data_cabang=0;
$m_data_wilayah=0;
$m_daerah_pembacaan=0;
$m_merk_water_meter=0;
$m_kondisi_water_meter=0;
$m_kode_klaim_rekening=0;
$m_tarif_golongan=0;
$m_tarif_meter=0;
$m_biaya_administrasi=0;
$m_piutang_rekening=0;
$m_proses=0;
$m_isi_koreksi_stand_meter=0;
$m_konfirmasi_dsmp=0;
$m_proses_pembuatan_rek=0;
$m_koreksi_status_angka_meter=0;
$m_ganti_data_pelanggan=0;
$m_rekening=0;
$m_lpp=0;
$m_rekap_lpp_per_umur_piutang=0;
$m_daftar_sisa_rekening=0;
$m_daftar_rekening_ditagih=0;
$m_efektifitas_penagihan_rek_air=0;
$m_export_lpp_dsr_ke_excel=0;
$m_utility=0;
$m_login_user=0;
$m_hak_akses=0;
$m_pejabat_staf_pelaporan=0;
$m_cetak_rekening=0;
$m_transfer_ke_loket_extern=0;
$m_ambil_dari_cabang=0;
$m_isi_tunggakan=0;
$m_loket=0;
$m_faktur=0;

$m_changex=0;
$m_ubah_nama=0;
$m_ubah_gol=0;
$m_ubah_blok=0;
$m_ubah_stat=0;
$m_ubah_kwm=0;
$m_ubah_meter=0;
$m_ubah_data_pel=0;
$m_ubah_no_pel=0;
$m_ubah_data_report=0;

$m_util_hapus_tung=0;
$m_util_pelunasan_non_lpp=0;
$m_util_info_lap_bulan_ti=0;
$m_util_backup_data=0;
$m_util_pembatalan_transaksi=0;
$m_util_rekap_lpp_harian=0;
$m_util_report_koreksi=0;
?>

	<tr>
		<td>
            <!--############################################################################################################-->
        <br />
		  	<table width="926px" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" class="wrapper" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;background:linear-gradient(#c0c0c0,#fff);" background="img/grids.gif">
            	<form id="fr1" name="fr1" method="post" action="" onSubmit="">
                <tr style="font:calibri;font-size:18px;font-weight:bold;color:#fff;background:linear-gradient(#666,#004);">
                  <td><center><font face="Arial,sans-serif" size="4px" style="padding:2px 0;text-shadow:4px -4px 4px red;color:#fff;font-size:19px;"><b>.:: Hak Akses Menu Billing System ::.</b></font></center></td>
                </tr>
                <tr>
                	<!--td width="">Posis/ Jabatan</td-->
                    <td>Posis/ Jabatan &nbsp;
                    	<select name="opthak" id="opthak" >
                          <option value="" selected="selected">-- Pilih --</option>
                       	<?php
                                $sql=mysql_query("SELECT id,nama FROM login_hak where id<>1 ORDER BY id");
                                while($row=mysql_fetch_row($sql)){
                                    echo"<option value=". trim($row[0]).">". trim($row[0])." - ".trim($row[1])."</option>";
                                }
                    	?>
                        </select>
                        &nbsp;&nbsp;
                        <input type="submit" name="load" value="Tampilkan Hak Akses !"  class="kelas_tombol" />                   	</td>
                </tr>
                <!--/form>
                <form id="fr2" name="fr2" method="post" action="" onSubmit=""-->
                <tr>
               		<td>
                    <table border="1" cellpadding="1" cellspacing="1" style="border-collapse:collapse;background:linear-gradient(#fff,#ff9);color:#00f;font-family:calibri;font-size:11px;" >
                    	<tr>
                        	<td valign="top">                      
                            <ul><input type="checkbox" name="c01" id="c01" value="" /><font size="3">File</font>
                            <li><input type="checkbox" name="c02" id="c02" value="" />Informasi Pelanggan</li>
                            <li><input type="checkbox" name="c03" id="c03" value="" />Pengisian Pelanggan Baru</li>
                            <li><input type="checkbox" name="c04" id="c04" value="" />Isi Pelanggan Kolektif</li>
                            <li><input type="checkbox" name="c05" id="c05" value="" />Pemakaian Air Rata<sup>2</sup> [Non Meter]</li>
                            <li><input type="checkbox" name="c06" id="c06" value="" />Data Cabang</li>
                            <li><input type="checkbox" name="c07" id="c07" value="" />Data Wilayah</li>
                            <li><input type="checkbox" name="c08" id="c08" value="" />Daerah Pembacaan [DKD]</li>
                            <li><input type="checkbox" name="c09" id="c09" value="" />Merk Water Meter</li>
                            <li><input type="checkbox" name="c10" id="c10" value="" />Kondisi Water Meter</li>
                            <li><input type="checkbox" name="c11" id="c11" value="" />Kode Klaim Rekening</li>
                            <li><input type="checkbox" name="c12" id="c12" value="" />Tarif Golongan</li>
                            <li><input type="checkbox" name="c13" id="c13" value="" />Tarif Meter</li>
                            <li><input type="checkbox" name="c14" id="c14" value="" />Biaya Administrasi</li>
                            <li><input type="checkbox" name="c15" id="c15" value="" />Piutang Rekening</li>
                            </ul>                            </td>
                            
                            <td valign="top">                      
                            <ul><input type="checkbox" name="c16" id="c16" value="" /><font size="3">Proses</font>
                            <li><input type="checkbox" name="c17" id="c17" value="" />Isi / Koreksi Stand Meter</li>
                            <li><input type="checkbox" name="c18" id="c18" value="" />Konfirmasi DSMP</li>
                            <li><input type="checkbox" name="c19" id="c19" value="" />Proses Pembuatan Rekening</li>
                            <li><input type="checkbox" name="c20" id="c20" value="" />Koreksi Status dan Angka Meter Lalu</li>
                            <!--li><input type="checkbox" name="c21" id="c21" value="" />Ganti Data Pelanggan</li-->

<br/>

                            <ul><font size="3">Pelunasan</font>
                            <li><input type="checkbox" name="c37" id="c37" value="" />Loket</li>
                            <li><input type="checkbox" name="c38" id="c38" value="" />Faktur</li>
                            </ul> 


                            </ul>                            </td>
                            
                            <td valign="top">                      
                            <ul><input type="checkbox" name="c22" id="c22" value="" /><font size="3">Rekening</font>
                            <li><input type="checkbox" name="c23" id="c23" value="" />LPP</li>
                            <li><input type="checkbox" name="c24" id="c24" value="" />Rekap LPP per Umur Piutang</li>
                            <li><input type="checkbox" name="c25" id="c25" value="" />Daftar Sisa Rekening</li>
                            <li><input type="checkbox" name="c26" id="c26" value="" />Daftar Rekening Ditagihkan</li>
                            <li><input type="checkbox" name="c27" id="c27" value="" />Efektifitas Penagihan Rek.</li>
                            <li><input type="checkbox" name="c28" id="c28" value="" />Export LPP & DSR ke Excel</li>
                            </ul>                            </td>
                            
                            <td valign="top">                      
                            <ul><input type="checkbox" name="c29" id="c29" value="" /><font size="3">Utility</font>
                            <li><input type="checkbox" name="c30" id="c30" value="" />Login User</li>
                            <li><input type="checkbox" name="c31" id="c31" value="" />Hak Akses</li>
                            <li><input type="checkbox" name="c32" id="c32" value="" />Pejabat & Staf Pelaporan</li>
                            <li><input type="checkbox" name="c33" id="c33" value="" />Cetak Rekening Online & Non Online</li>
                            <li><input type="checkbox" name="c34" id="c34" value="" />Transfer ke Loket Extern</li>
                            <li><input type="checkbox" name="c35" id="c35" value="" />Ambil dari Cabang [UPP]</li>
                            <li><input type="checkbox" name="c36" id="c36" value="" />Isi Tunggakan</li>

<li><input type="checkbox" name="c49" id="c49" value="" />Hapus Tunggakan</li>
<li><input type="checkbox" name="c50" id="c50" value="" />Pelunasan Non-LPP</li>
<li><input type="checkbox" name="c51" id="c51" value="" />Info Lap. Bulanan TI</li>
<li><input type="checkbox" name="c52" id="c52" value="" />Backup Data</li>
<li><input type="checkbox" name="c53" id="c53" value="" />Pembatalan Transaksi</li>
<li><input type="checkbox" name="c54" id="c54" value="" />Rekap LPP Harian</li>
<li><input type="checkbox" name="c55" id="c55" value="" />Report Koreksi</li>

                            </ul>
                    	</tr>
<tr>
<td valign="top">
<ul><input type="checkbox" name="c39" id="c39" value="" /><font size="3">Change</font>
<li><input type="checkbox" name="c40" id="c40" value="" />Balik Nama</li>
<li><input type="checkbox" name="c41" id="c41" value="" />Ubah Gol. Tarif</li>
<li><input type="checkbox" name="c42" id="c42" value="" />Ubah Kode Blok</li>
<li><input type="checkbox" name="c43" id="c43" value="" />Ubah Status Pel.</li>
<li><input type="checkbox" name="c44" id="c44" value="" />Ubah KWM</li>
<li><input type="checkbox" name="c45" id="c45" value="" />Ubah Meterisasi</li>
<li><input type="checkbox" name="c46" id="c46" value="" />Ganti Data Pel.</li>
<li><input type="checkbox" name="c47" id="c47" value="" />Ubah No. Pelanggan</li>
<li><input type="checkbox" name="c48" id="c48" value="" />Report Perubahan Data</li>
</ul>
</td>
</tr>
                    </table>					</td>
                </tr>
                <tr>
                	<td>
                    	<input type="submit" name="save" value="Simpan" class="kelas_tombol" />
                        <input type="reset" value="Reset" class="kelas_tombol" />                    </td>
                </tr>
                </form>
            </table>            
		  <!--############################################################################################################-->
          <?php
          	if(isset($_POST['save']) && $_POST['save']=='Simpan'){
				//echo"<script language=\"javascript\">alert('hahahaha');</script-->";
				$hak=$_POST['opthak'];
				
				if(isset($_POST['c01']))$m_file=1;
				if(isset($_POST['c02']))$m_informasi_pelanggan=1;
				if(isset($_POST['c03']))$m_pengisian_pelanggan_baru=1;
				if(isset($_POST['c04']))$m_isi_pelanggan_kolektif=1;
				if(isset($_POST['c05']))$m_pemakaian_air_non_meter=1;
				if(isset($_POST['c06']))$m_data_cabang=1;
				if(isset($_POST['c07']))$m_data_wilayah=1;
				if(isset($_POST['c08']))$m_daerah_pembacaan=1;
				if(isset($_POST['c09']))$m_merk_water_meter=1;
				if(isset($_POST['c10']))$m_kondisi_water_meter=1;
				if(isset($_POST['c11']))$m_kode_klaim_rekening=1;
				if(isset($_POST['c12']))$m_tarif_golongan=1;
				if(isset($_POST['c13']))$m_tarif_meter=1;
				if(isset($_POST['c14']))$m_biaya_administrasi=1;
				if(isset($_POST['c15']))$m_piutang_rekening=1;
				if(isset($_POST['c16']))$m_proses=1;
				if(isset($_POST['c17']))$m_isi_koreksi_stand_meter=1;
				if(isset($_POST['c18']))$m_konfirmasi_dsmp=1;
				if(isset($_POST['c19']))$m_proses_pembuatan_rek=1;
				if(isset($_POST['c20']))$m_koreksi_status_angka_meter=1;
				if(isset($_POST['c21']))$m_ganti_data_pelanggan=1;
				if(isset($_POST['c22']))$m_rekening=1;
				if(isset($_POST['c23']))$m_lpp=1;
				if(isset($_POST['c24']))$m_rekap_lpp_per_umur_piutang=1;
				if(isset($_POST['c25']))$m_daftar_sisa_rekening=1;
				if(isset($_POST['c26']))$m_daftar_rekening_ditagih=1;
				if(isset($_POST['c27']))$m_efektifitas_penagihan_rek_air=1;
				if(isset($_POST['c28']))$m_export_lpp_dsr_ke_excel=1;
				if(isset($_POST['c29']))$m_utility=1;
				if(isset($_POST['c30']))$m_login_user=1;
				if(isset($_POST['c31']))$m_hak_akses=1;
				if(isset($_POST['c32']))$m_pejabat_staf_pelaporan=1;
				if(isset($_POST['c33']))$m_cetak_rekening=1;
				if(isset($_POST['c34']))$m_transfer_ke_loket_extern=1;
				if(isset($_POST['c35']))$m_ambil_dari_cabang=1;
				if(isset($_POST['c36']))$m_isi_tunggakan=1;
				
				if(isset($_POST['c37']))$m_loket=1;
				if(isset($_POST['c38']))$m_faktur=1;
				//if(isset($_POST['c39']))$m_faktur=1;
				
				if(isset($_POST['c39']))$m_changex=1;
                                if(isset($_POST['c40']))$m_ubah_nama=1;
                                if(isset($_POST['c41']))$m_ubah_gol=1;
                                if(isset($_POST['c42']))$m_ubah_blok=1;
                                if(isset($_POST['c43']))$m_ubah_stat=1;
                                if(isset($_POST['c44']))$m_ubah_kwm=1;
                                if(isset($_POST['c45']))$m_ubah_meter=1;
                                if(isset($_POST['c46']))$m_ubah_data_pel=1;
                                if(isset($_POST['c47']))$m_ubah_no_pel=1;
                                if(isset($_POST['c48']))$m_ubah_data_report=1;

				if(isset($_POST['c49']))$m_util_hapus_tung=1;
				if(isset($_POST['c50']))$m_util_pelunasan_non_lpp=1;
				if(isset($_POST['c51']))$m_util_info_lap_bulan_ti=1;
				if(isset($_POST['c52']))$m_util_backup_data=1;
				if(isset($_POST['c53']))$m_util_pembatalan_transaksi=1;
				if(isset($_POST['c54']))$m_util_rekap_lpp_harian=1;	
				if(isset($_POST['c55']))$m_util_report_koreksi=1;	
				
				//mysql_query("INSERT IGNORE INTO login_menu(file,proses,rekening,utility)value(1,1,1,1);")or die(mysql_error());
				
				$sql="UPDATE login_menu SET file=$m_file, informasi_pelanggan=$m_informasi_pelanggan, pengisian_pelanggan_baru=$m_pengisian_pelanggan_baru, isi_pelanggan_kolektif=$m_isi_pelanggan_kolektif, pemakaian_air_non_meter=$m_pemakaian_air_non_meter, data_cabang=$m_data_cabang,
				data_wilayah=$m_data_wilayah, daerah_pembacaan=$m_daerah_pembacaan, merk_water_meter=$m_merk_water_meter, kondisi_water_meter=$m_kondisi_water_meter, kode_klaim_rekening=$m_kode_klaim_rekening, tarif_golongan=$m_tarif_golongan, tarif_meter=$m_tarif_meter, biaya_administrasi=$m_biaya_administrasi,
				piutang_rekening=$m_piutang_rekening, proses=$m_proses, isi_koreksi_stand_meter=$m_isi_koreksi_stand_meter, konfirmasi_dsmp=$m_konfirmasi_dsmp, proses_pembuatan_rek=$m_proses_pembuatan_rek, koreksi_status_angka_meter=$m_koreksi_status_angka_meter, ganti_data_pelanggan=$m_ganti_data_pelanggan,
				rekening=$m_rekening, lpp=$m_lpp, rekap_lpp_per_umur_piutang=$m_rekap_lpp_per_umur_piutang, daftar_sisa_rekening=$m_daftar_sisa_rekening, daftar_rekening_ditagih=$m_daftar_rekening_ditagih, efektifitas_penagihan_rek_air=$m_efektifitas_penagihan_rek_air, export_lpp_dsr_ke_excel=$m_export_lpp_dsr_ke_excel,
				utility=$m_utility, login_user=$m_login_user, hak_akses=$m_hak_akses, pejabat_staf_pelaporan=$m_pejabat_staf_pelaporan, cetak_rekening=$m_cetak_rekening, transfer_ke_loket_extern=$m_transfer_ke_loket_extern, ambil_dari_cabang=$m_ambil_dari_cabang, isi_tunggakan=$m_isi_tunggakan,loket=$m_loket,faktur=$m_faktur,			

changex=$m_changex,
ubah_nama=$m_ubah_nama,
ubah_gol=$m_ubah_gol,
ubah_blok=$m_ubah_blok,
ubah_stat=$m_ubah_stat,
ubah_kwm=$m_ubah_kwm,
ubah_meter=$m_ubah_meter,
ubah_data_pel=$m_ubah_data_pel,
ubah_no_pel=$m_ubah_no_pel,
ubah_data_report=$m_ubah_data_report,

util_hapus_tung=$m_util_hapus_tung,
util_pelunasan_non_lpp=$m_util_pelunasan_non_lpp,
util_info_lap_bulan_ti=$m_util_info_lap_bulan_ti,
util_backup_data=$m_util_backup_data=$m_util_backup_data,
util_pembatalan_transaksi=$m_util_pembatalan_transaksi,
util_rekap_lpp_harian=$m_util_rekap_lpp_harian,
util_report_koreksi=$m_util_report_koreksi

				WHERE id=$hak;";
				$qry=mysql_query($sql)or die(mysql_error());
				
		  	}else if(isset($_POST['load']) && $_POST['opthak']!=""){
				//if(isset($_POST['opthak'])){
					$hak=$_POST['opthak'];
					
					echo"<script type=\"text/javascript\">document.getElementById('opthak').value=\"$hak\";</script>";
					
					$sql="SELECT file, informasi_pelanggan, pengisian_pelanggan_baru, isi_pelanggan_kolektif, pemakaian_air_non_meter, data_cabang, data_wilayah, daerah_pembacaan, merk_water_meter, kondisi_water_meter, kode_klaim_rekening, tarif_golongan, tarif_meter, biaya_administrasi, piutang_rekening, proses, isi_koreksi_stand_meter, konfirmasi_dsmp, proses_pembuatan_rek, koreksi_status_angka_meter, ganti_data_pelanggan, rekening, lpp, rekap_lpp_per_umur_piutang, daftar_sisa_rekening, daftar_rekening_ditagih, efektifitas_penagihan_rek_air, export_lpp_dsr_ke_excel, utility, login_user, hak_akses, pejabat_staf_pelaporan, cetak_rekening, transfer_ke_loket_extern, ambil_dari_cabang, isi_tunggakan,loket,faktur, changex,ubah_nama,ubah_gol,ubah_blok,ubah_stat,ubah_kwm,ubah_meter,ubah_data_pel,ubah_no_pel,ubah_data_report,util_hapus_tung,util_pelunasan_non_lpp,util_info_lap_bulan_ti,util_backup_data,util_pembatalan_transaksi,util_rekap_lpp_harian,util_report_koreksi FROM login_menu WHERE id=$hak;";
					$qry=mysql_query($sql)or die(mysql_error());
					if($row=mysql_fetch_row($qry)){
						$m_file=$row[0];
						$m_informasi_pelanggan=$row[1];
						$m_pengisian_pelanggan_baru=$row[2];
						$m_isi_pelanggan_kolektif=$row[3];
						$m_pemakaian_air_non_meter=$row[4];
						$m_data_cabang=$row[5];
						$m_data_wilayah=$row[6];
						$m_daerah_pembacaan=$row[7];
						$m_merk_water_meter=$row[8];
						$m_kondisi_water_meter=$row[9];
						$m_kode_klaim_rekening=$row[10];
						$m_tarif_golongan=$row[11];
						$m_tarif_meter=$row[12];
						$m_biaya_administrasi=$row[13];
						$m_piutang_rekening=$row[14];
						$m_proses=$row[15];
						$m_isi_koreksi_stand_meter=$row[16];
						$m_konfirmasi_dsmp=$row[17];
						$m_proses_pembuatan_rek=$row[18];
						$m_koreksi_status_angka_meter=$row[19];
						$m_ganti_data_pelanggan=$row[20];
						$m_rekening=$row[21];
						$m_lpp=$row[22];
						$m_rekap_lpp_per_umur_piutang=$row[23];
						$m_daftar_sisa_rekening=$row[24];
						$m_daftar_rekening_ditagih=$row[25];
						$m_efektifitas_penagihan_rek_air=$row[26];
						$m_export_lpp_dsr_ke_excel=$row[27];
						$m_utility=$row[28];
						$m_login_user=$row[29];
						$m_hak_akses=$row[30];
						$m_pejabat_staf_pelaporan=$row[31];
						$m_cetak_rekening=$row[32];
						$m_transfer_ke_loket_extern=$row[33];
						$m_ambil_dari_cabang=$row[34];
						$m_isi_tunggakan=$row[35];
						$m_loket=$row[36];
						$m_faktur=$row[37];

$m_changex=$row[38];
$m_ubah_nama=$row[39];
$m_ubah_gol=$row[40];
$m_ubah_blok=$row[41];
$m_ubah_stat=$row[42];
$m_ubah_kwm=$row[43];
$m_ubah_meter=$row[44];
$m_ubah_data_pel=$row[45];
$m_ubah_no_pel=$row[46];
$m_ubah_data_report=$row[47];

$m_util_hapus_tung=$row[48];
$m_util_pelunasan_non_lpp=$row[49];
$m_util_info_lap_bulan_ti=$row[50];
$m_util_backup_data=$row[51];
$m_util_pembatalan_transaksi=$row[52];
$m_util_rekap_lpp_harian=$row[53];
$m_util_report_koreksi=$row[54];

					}
				//}
					if($m_file==1)echo"<script type=\"text/javascript\">document.getElementById('c01').checked=\"checked\";</script>";
					if($m_informasi_pelanggan==1)echo"<script type=\"text/javascript\">document.getElementById('c02').checked=\"checked\";</script>";
					if($m_pengisian_pelanggan_baru==1)echo"<script type=\"text/javascript\">document.getElementById('c03').checked=\"checked\";</script>";					
					if($m_isi_pelanggan_kolektif==1)echo"<script type=\"text/javascript\">document.getElementById('c04').checked=\"checked\";</script>";
					if($m_pemakaian_air_non_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c05').checked=\"checked\";</script>";
					if($m_data_cabang==1)echo"<script type=\"text/javascript\">document.getElementById('c06').checked=\"checked\";</script>";
					if($m_data_wilayah==1)echo"<script type=\"text/javascript\">document.getElementById('c07').checked=\"checked\";</script>";
					if($m_daerah_pembacaan==1)echo"<script type=\"text/javascript\">document.getElementById('c08').checked=\"checked\";</script>";
					if($m_merk_water_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c09').checked=\"checked\";</script>";
					if($m_kondisi_water_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c10').checked=\"checked\";</script>";
					if($m_kode_klaim_rekening==1)echo"<script type=\"text/javascript\">document.getElementById('c11').checked=\"checked\";</script>";
					if($m_tarif_golongan==1)echo"<script type=\"text/javascript\">document.getElementById('c12').checked=\"checked\";</script>";
					if($m_tarif_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c13').checked=\"checked\";</script>";
					if($m_biaya_administrasi==1)echo"<script type=\"text/javascript\">document.getElementById('c14').checked=\"checked\";</script>";
					if($m_piutang_rekening==1)echo"<script type=\"text/javascript\">document.getElementById('c15').checked=\"checked\";</script>";
					
					if($m_proses==1)echo"<script type=\"text/javascript\">document.getElementById('c16').checked=\"checked\";</script>";
					if($m_isi_koreksi_stand_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c17').checked=\"checked\";</script>";
					if($m_konfirmasi_dsmp==1)echo"<script type=\"text/javascript\">document.getElementById('c18').checked=\"checked\";</script>";
					if($m_proses_pembuatan_rek==1)echo"<script type=\"text/javascript\">document.getElementById('c19').checked=\"checked\";</script>";
					if($m_koreksi_status_angka_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c20').checked=\"checked\";</script>";
					if($m_ganti_data_pelanggan==1)echo"<script type=\"text/javascript\">document.getElementById('c21').checked=\"checked\";</script>";
					
					if($m_rekening==1)echo"<script type=\"text/javascript\">document.getElementById('c22').checked=\"checked\";</script>";
					if($m_lpp==1)echo"<script type=\"text/javascript\">document.getElementById('c23').checked=\"checked\";</script>";
					if($m_rekap_lpp_per_umur_piutang==1)echo"<script type=\"text/javascript\">document.getElementById('c24').checked=\"checked\";</script>";
					if($m_daftar_sisa_rekening==1)echo"<script type=\"text/javascript\">document.getElementById('c25').checked=\"checked\";</script>";
					if($m_daftar_rekening_ditagih==1)echo"<script type=\"text/javascript\">document.getElementById('c26').checked=\"checked\";</script>";
					if($m_efektifitas_penagihan_rek_air==1)echo"<script type=\"text/javascript\">document.getElementById('c27').checked=\"checked\";</script>";
					if($m_export_lpp_dsr_ke_excel==1)echo"<script type=\"text/javascript\">document.getElementById('c28').checked=\"checked\";</script>";
					
					if($m_utility==1)echo"<script type=\"text/javascript\">document.getElementById('c29').checked=\"checked\";</script>";
					if($m_login_user==1)echo"<script type=\"text/javascript\">document.getElementById('c30').checked=\"checked\";</script>";
					if($m_hak_akses==1)echo"<script type=\"text/javascript\">document.getElementById('c31').checked=\"checked\";</script>";
					if($m_pejabat_staf_pelaporan==1)echo"<script type=\"text/javascript\">document.getElementById('c32').checked=\"checked\";</script>";
					if($m_cetak_rekening==1)echo"<script type=\"text/javascript\">document.getElementById('c33').checked=\"checked\";</script>";
					if($m_transfer_ke_loket_extern==1)echo"<script type=\"text/javascript\">document.getElementById('c34').checked=\"checked\";</script>";
					if($m_ambil_dari_cabang==1)echo"<script type=\"text/javascript\">document.getElementById('c35').checked=\"checked\";</script>";
					if($m_isi_tunggakan==1)echo"<script type=\"text/javascript\">document.getElementById('c36').checked=\"checked\";</script>";
					if($m_loket==1)echo"<script type=\"text/javascript\">document.getElementById('c37').checked=\"checked\";</script>";
					if($m_faktur==1)echo"<script type=\"text/javascript\">document.getElementById('c38').checked=\"checked\";</script>";

if($m_changex==1)echo"<script type=\"text/javascript\">document.getElementById('c39').checked=\"checked\";</script>";
if($m_ubah_nama==1)echo"<script type=\"text/javascript\">document.getElementById('c40').checked=\"checked\";</script>";
if($m_ubah_gol==1)echo"<script type=\"text/javascript\">document.getElementById('c41').checked=\"checked\";</script>";
if($m_ubah_blok==1)echo"<script type=\"text/javascript\">document.getElementById('c42').checked=\"checked\";</script>";
if($m_ubah_stat==1)echo"<script type=\"text/javascript\">document.getElementById('c43').checked=\"checked\";</script>";
if($m_ubah_kwm==1)echo"<script type=\"text/javascript\">document.getElementById('c44').checked=\"checked\";</script>";
if($m_ubah_meter==1)echo"<script type=\"text/javascript\">document.getElementById('c45').checked=\"checked\";</script>";
if($m_ubah_data_pel==1)echo"<script type=\"text/javascript\">document.getElementById('c46').checked=\"checked\";</script>";
if($m_ubah_no_pel==1)echo"<script type=\"text/javascript\">document.getElementById('c47').checked=\"checked\";</script>";
if($m_ubah_data_report==1)echo"<script type=\"text/javascript\">document.getElementById('c48').checked=\"checked\";</script>";

if($m_util_hapus_tung==1)echo"<script type=\"text/javascript\">document.getElementById('c49').checked=\"checked\";</script>";
if($m_util_pelunasan_non_lpp==1)echo"<script type=\"text/javascript\">document.getElementById('c50').checked=\"checked\";</script>";
if($m_util_info_lap_bulan_ti==1)echo"<script type=\"text/javascript\">document.getElementById('c51').checked=\"checked\";</script>";
if($m_util_backup_data==1)echo"<script type=\"text/javascript\">document.getElementById('c52').checked=\"checked\";</script>";
if($m_util_pembatalan_transaksi==1)echo"<script type=\"text/javascript\">document.getElementById('c53').checked=\"checked\";</script>";
if($m_util_rekap_lpp_harian==1)echo"<script type=\"text/javascript\">document.getElementById('c54').checked=\"checked\";</script>";
if($m_util_report_koreksi==1)echo"<script type=\"text/javascript\">document.getElementById('c55').checked=\"checked\";</script>";

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
