<?php
#inc.php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'pdamjpr123');
define('DB', 'billing');

#error_reporting(E_ALL);
#ini_set('display_errors', 1);



date_default_timezone_set('Asia/Jayapura');
$tanggal=date('d-M-Y [H:i:s]',time());

$conn=mysql_connect(HOST,USER,PASS)or die(mysql_error());
mysql_select_db(DB,$conn)or die(mysql_error());

if(isset($_POST['kirim_json'])){
	$arr_hasil=array();

	$data=json_decode($_POST['kirim_json']);
	$cbg=$data->cabang;
	$sql="SELECT nomor,nolama,UCASE(nama),cabang,kode_blok,alamat FROM master WHERE cabang='$cbg' ORDER BY kode_blok ASC, nolama ASC;";
	$j=0;
	
	$pel=mysql_query($sql)or die(mysql_error());
	$j=mysql_num_rows($pel);

	while ($row=mysql_fetch_row($pel)) {
		array_push($arr_hasil, array('nomor'=>$row[0],'nolama'=>$row[1],'nama'=>$row[2],'cabang'=>$row[3],'kode_blok'=>$row[4],'alamat'=>$row[5]));
		#$j=1;
	}

	if($j>0){
	//echo json_encode($arr_hasil);
		echo json_encode(array("retVal"=>"SUKSES","hasil"=>$arr_hasil));
	}else{
		echo json_encode(array("retVal"=>"GAGAL"));
	}

}

if(isset($_POST['hasil_baca'])){
	//$ar=array();
	$data = $_POST['hasil_baca'];
    	$jd = json_decode($data);
    	$sql=$jd->sql_simpan;

    	$i=0;
	if ($pel=mysql_query($sql)) {
		echo json_encode(array("retVal"=>"SUKSES"));
	}else{
		echo json_encode(array("retVal"=>"GAGAL"));
	}
	$stmt->close();
}

mysql_close();
