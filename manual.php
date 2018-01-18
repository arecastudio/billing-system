<?php
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$nloket="JPR";
$operator=$_SESSION['nama_user'];
kunci_halaman("login_user",$secret,$operator);

require_once('head.php');
?>
<tr><td style="padding:20px;">
<center>
<textarea cols="120" rows="30" readonly>
Selamat datang Admin,
Halaman ini merupakan rangkuman panduan singkat penggunaan aplikasi Billing System sebagai modul dasar
bagi anda (user) yang diberi hak akses Admin untuk melakukan proses Data Manipulating terhadap System.
Panduan ini hanya memuat metode yang sering kali digunakan sebagai pekerjaan rutin bulanan (bersifat anual)
oleh user top level dalam hal menunjang kinerja Billing System secara keseluruhan.

PERINGATAN==============================================!
Untuk menghindari human error pada pada tahap ini,
sebelum melakukan proses apapun pada database Billing System
Sebaiknya dilakukan backup data terlebih dahulu. Fitur ini (backup data)
hanya dapat diakses oleh user dengan privileges Admin. Yang menunya terdapat
pada branch menu Utility pada aplikasi Billing System.
========================================================!


*)Prosedur Pengiriman Database Billing System dengan Metode Data Compress dan Shell Execute (backdoor).
Metode ini digunakan dalam proses pengiriman database ke sub-server pada masing-masing cabang (UPP). Pertama-tama
database harus diexport terlebih dahulu, kemudian di-compress dalam bentuk archive (*.ZIP) lalu kemudian dilakukan
proses pengiriman dan import pada sub-server yang dilakukan secara remote.

Tujuan mengapa data harus di-compress terlebih dahulu adalah karena mengingat speed transfer rate yang rendah dari
jaringan Telkom (provider) yang sangat kecil tidak mampu untuk men-transfer database berukuran 1MB (estimasi) dalam waktu singkat. Yang apabila dipaksakan akan menyebabkan koneksi terputus. Berikut ini adalah langkah-langkah dalam penerapan metode ini.

-Sisi Server (pusat)
Tahap pertama adalah melakukan export database yang hendak dikirim ke sub-server cabang. Pada contoh kali ini, diumpamakan user hendak mengirim rekening1 dan hasil pembacaan meter untuk periode bulan Nopember 2017, maka untuk pengiriman data DSMP harus disertakan juga pembacaan bulan Oktober 2017. Perintah pada MySQL adalah sebagai berikut - dengan penjelasan di dalam tanda kurung.

CATATAN KHUSUS: Dalam menjalankan perintah ini, gunakan hak akses user system dengan nama pdam. Jangan gunakan root, agar menghindari kesalahan-kesalahan perintah terhadap system linux.

#mysql -u root -p billing (masuk ke lingkungan mysql dengan hak akses root, isikan password)
#drop table if exists temp_master;drop table if exists temp_rekening1;drop table if exists temp_dsmp_new;
#create table if not exists temp_master like master;create table if not exists temp_rekening1 like rekening1;create table if not exists temp_dsmp_new like dsmp_new;
#insert into temp_master select * from master;
#insert into temp_dsmp_new select * from dsmp_new where periode in(201710,201711);
#insert into temp_rekening1 select * from rekening1 where periode=201711;
#exit;(keluar dari lingkungan mysql)

Selanjutnya, lakukan export data dari ke-tiga table temp_ tadi menjadi file yang siap untuk dikirim ke cabang. Dalam hal ini, user tidak perlu masuk ke dalam lingkungan MySQL, tapi perintah dapat langsung dilakukan dari luar. Contoh export data ini dilakukan ke dalam folder Documents (pada server Linux). Berikut ini adalah perintahnya:

#mysqldump -u root -p billing temp_master temp_rekening1 temp_dsmp_new>~/Documents/temp-data-transfer-201711.sql
Setelah proses export ini selesai, selanjutnya lakukan compress file agar ukuran dapat ditekan hingga 88%, perintahnya adalah sebagai berikut:
#cd ~/Documents (masuk ke direktori Documents)
#zip temp-data-transfer-201711.zip temp-data-transfer-201711.sql (tunggu hingga proses selesai)
#rm temp-data-transfer-201711.sql

Sekarang file temp-data-transfer-201711.sql telah ter-compress ke dalam format *.ZIP dengan ukuran lebih kecil dan siap untuk dikirim ke sub-server cabang.

Untuk mengirim file, sambungkan ke direktori sub-server terlebih dahulu. Pada contoh berikut ini, user hendak mengirim data ke cabang Jayapura Utara (UJU). Pertama-tama, buka files explorer, lalu pada menu Network pada sisi kiri bawah - klik sub-menu Connect to Server. Tunggu hingga muncul confirm box, masukkan alamat IP cabang UJU beserta subdirectory yang berisi shell, sebagai berikut:
smb://192.168.1.50/billing/exec
Tekan tombil Connect, tunggu hingga direktori remote terbuka. Kemudian copy-paste file temp-data-transfer-201711.zip yang berada pada direktori (local) Documents tadi ke dalam direktori (remote) exec yang telah terbuka. Tunggu hingga proses transfer file temp-data-transfer-201711.zip ke sub-server cabang UJU selesai.

CATATAN-TAMBAHAN!-----------------------------------------------------------------------------------
Untuk direktori remote masing-masing cabang, berikut ini adalah alama aksesnya:
UJU -> smb://192.168.1.50/billing/exec
ABE -> smb://192.168.2.60/billing/exec
WNA -> smb://192.168.5.80/xampp/htdocs/billing/exec
STN -> smb://192.168.4.70/xampp/htdocs/billing/exec
-----------------------------------------------------------------------------------------------------

Setelah selesai mengirim data ke semua cabang, berikutnya dilakukan proses extract data secara remote melalui shell yang telah ditanam pada masing-masing web server dicabang. Pada contoh berikut, user akan mengakses file shell pada cabang UJU, caranya dengan memasukan alamat pada web-browser seperti berikut:
http://192.168.1.50/billing/exec/
Setelah masuk dalam tampilan shell script, masukkan nama file *.ZIP tadi pada field (textbox) ke-dua yang tertera hint "nama_file.zip [akan otomatis ter-unzip ke direktori ext]". Dalam contoh ini, masukkan nama file yang tadi ditransfer, yaitu temp-data-transfer-201711.zip. Tekan tombol (hitam) Eksekusi SQL untuk memulai proses un-zip file tadi. Tunggu hingga proses selesai, dimana hasil extract file telah masuk ke dalam direktori ext, dengan nama temp-data-transfer-201711.sql.

p berikut adalah menghapus nama tabel yang mungkin masih tersisa pada sub-server, caranya adalah dengan memasukkan perintah SQL berikut pada field/textbox berukuran besar (yang pertama), sebagai berikut:
mysql -u root billing -e "DROP TABLE IF EXISTS temp_master; DROP TABLE IF EXISTS temp_rekening1; DROP TABLE IF EXISTS temp_dsmp_new;"
Kemudian tekan tombol (hitam) Eksekusi SQL untuk memproses, tunggu beberapa detik hingga proses selesai.

Selanjutnya masukkan perintah SQL (masih pada textboxt yang sama) untuk mengimpor table dari file yang telah di-extract sebelumnya. Perintahnya adalah sebagai berikut:
mysql -u root billing<ext/temp-data-transfer-201711.sql
Kemudian tekan tombol (hitam) Eksekusi SQL untuk memproses, tunggu beberapa detik hingga proses selesai.

Sampai di sini, user telah berhasil mengimpor ke-tiga tabel tadi ke dalam database sub-server (cabang) secara remote. Namun, isi tabel tersebut belum terimplementasi pada billing system karena masih bersimpat temporer, tertampung dalam tabel temp_. Untuk mengimplementasikan ke tabel-tabel utama, lakukan beberapa langkah-langkah berikut.

Buka terminal kembali, pada distro Ubuntu Linux dapat dilakukan dengan menekan tombol ALT+T secara berasamaan. Setelah muncul jendela terminal. Masukkan perintah berikut ini:
#mysql -u pdam -h 192.168.1.50 billing -e "DROP TABLE master; RENAME TABLE temp_master TO master; INSERT INTO rekening1 SELECT * FROM temp_rekening1; UPDATE dsmp_new AS d INNER JOIN temp_dsmp_new AS t ON t.nomor=d.nomor AND t.periode=d.periode SET d.angka=t.angka WHERE d.periode IN (201710,201711);"

tunggu hingga proses eksekusi SQL selesai. Lalu masuk ke Billing System kemudian cek jumlah DRD tersebut, dalam hal ini adalah periode 201709. Jika jumlah pada cabang UJU sama dengan di pusat maka proses transfer dan import data telah selesai. Lakukan hal yang sama untuk transfer dan import data ke cabang-cabang lainnya dengan mengubah IP sesuai alamat sub-server cabang.

Klik --proses--isi koreksi stand meter --> AGAR PERUBAHAN DATA DSMP TERPROSES

EOF


</textarea> </center>

<hr style="color:red;"/>

<center>
<h5>Broadcast Informasi</h5>
<form method="post" action="">
<textarea name="ta_info" id="ta_info" cols="100" rows="3" required></textarea>
<br/>
<select name="sl_ip" id="sl_ip">
<option value="">Pusat</option>
<option value="192.168.1.50">UJU</option>
<option value="192.168.2.60">ABE</option>
<option value="192.168.5.80">WNA</option>
<option value="192.168.4.70">STN</option>
</select>
<input type="submit" name="submit" value="Post Informasi"/>
</form>
</center>



</td></tr>
<?php
if(isset($_POST['submit'])){
	$ip=$_POST['sl_ip'];
	$info=$_POST['ta_info'];
	if(trim($info)<>''){
		if(trim($ip)==''){
			$cmd="mysql -u rail billing -e \"INSERT INTO informasi(isi)VALUE('$info');\"";
		}else{
			$cmd="mysql -u pdam billing -h $ip -e \"INSERT INTO informasi(isi)VALUE('$info');\" ";
		}
		shell_exec($cmd);
	}
}





require_once('foot.php');
?>
