<?php
ob_start();
session_start();
require_once("mydb.php");
sambung();
require_once("global_functions.php");

//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//require_once("head.php");//mysql_num_rows();
//echo date('Y-m-d');
//$_SESSION['login']="tutup";
if(isset($_GET['aksi'])){
	$aksi=$_GET['aksi'];
	if ($aksi=='tutup'){
		$_SESSION['login']="tutup";
	}
}

$upw="";
$kunci=base64_encode('billing123');
$tes=base64_encode('tes');
$qry=mysql_query("insert ignore into login_user(nama,kunci,id)values('admin','$kunci',1);")or die(mysql_error());
$qry=mysql_query("insert ignore into login_user(nama,kunci,id)values('tes','$tes',5);")or die(mysql_error());

if(isset($_POST['login'])){
	$uid=$_POST["txuserid"];
	$upw=$_POST["txpassword"];
	//$upw_enc=base64_encode
	$qry=mysql_query("SELECT nama,kunci,id FROM login_user where nama='$uid';")or die(mysql_error());
	if($row=mysql_fetch_row($qry)){
		//$_SESSION['login']="buka";
		$_SESSION['nama_user']=$row[0];
		if($upw==base64_decode($row[1])){
			$_SESSION['login']="buka";
		}else{
			$_SESSION['login']="tutup";
			echo"<script type=\"text/javascript\">alert('Login gagal!');</script>";
		}
	}else{
		$_SESSION['login']="tutup";
		echo"<script type=\"text/javascript\">alert('Login gagal!');</script>";
	}
}

if(isset($_SESSION['login'])){
	$hasil=$_SESSION['login'];
	//echo $upw;
	if($_SESSION['login']=="buka"){
		header("location: index0.php");
		//$_SESSION['login']=0;
	}else{
		$_SESSION['login']="tutup";
	}
}

?>
<html>
<head>
	<link rel="shortcut icon" href="favicon1.ico" type="image/x-icon"/>
    <link href="jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui-1.10.4.custom.js"></script>
<script src="jquery.validate.js"></script>
<script type="text/javascript" src="messages_id.js"></script>
<script type="text/javascript" src="/js/circletype.js"></script>
<script>
$(function() {
$( ".datepicker" ).datepicker({
   changeMonth: true,
   changeYear: true,
   //showOn:"button"
  });
  
  $( ".datepicker" ).datepicker({ altFormat: 'yy-mm-dd' });
  $( ".datepicker" ).change(function() {
  	$( ".datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd" );
  });
  
  $( ".button" ).button();	 
  $('#reversed_arc').circleType({radius: 160, dir:-1});
});
    <title>Login User</title>
    <script type="text/javascript">
		function fokus(){
			document.getElementById('txuserid').focus();
		}
    </script>
    <style>
    .wrapper1 {
font: 60.5% "Trebuchet MS", sans-serif;
-moz-box-shadow: 0 0 15px #999;
-webkit-box-shadow: 0 0 15px #999;
-o-box-shadow: 0 0 15px #999;
box-shadow: 0 0 15px #999;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
-o-border-radius: 15px;
border-radius: 15px;
-moz-border: 2px solid #009900;
-webkit-border: 3px solid #009900;
-o-border: 2px solid #009900;
border: 2px solid #009900;
background:linear-gradient(#ff0, #ffc);
}
    
    
    .wrapper11 {font: 60.5% "Trebuchet MS", sans-serif;
-moz-box-shadow: 0 0 15px #999;
-webkit-box-shadow: 0 0 15px #999;
-o-box-shadow: 0 0 15px #999;
box-shadow: 0 0 15px #999;
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
-o-border-radius: 15px;
border-radius: 15px;
-moz-border: 2px solid #009900;
-webkit-border: 3px solid #009900;
-o-border: 2px solid #009900;
border: 2px solid #009900;
background:linear-gradient(#ff0, #ffc);
}


    </style>
</head>

<body style="background: linear-gradient(#28486e, #fff);width:100%;height:100%;" onLoad="return fokus();">
	
		<!--############################################################################################################--><!--############################################################################################################-->
	 
	
<?php
//mysql_close();
putus();
//require_once("foot.php");
?>
<br>
<h2 align="center" id="reversed_arc" style="padding:2px 0;text-shadow:2px -2px 2px red;color:#fff;font-size:16px;font-weight:bold;font-family:Britannic;">MOTO PDAM JAYAPURA</h2>
<p align="center" style="padding:2px 0;text-shadow:2px -2px 2px red;color:#fff;font-size:18px;font-family:Broadway;font-weight:bold;text-decoration:blink;">..::.. MENGALIR SAMPAI KE HATI ..::..</p>
<p align="left" style="text-shadow:2px -2px 2px red;color:#fff;font-size:18px;font-weight:bold;font-family:Broadway;margin-left:10em;">Visi : </p>
<p style="text-shadow:2px -2px 2px yellow;color:#000;margin-left:15em;font-weight:bold;font-family:Courier;font-size:14px">"Menjadikan Perusahaan Yang Sehat Dengan Pelayanan Prima"</p>
<table align="center" >
  <tr height="100px">
  
    <td><!--div style="height:300px;overflow:auto"-->
      <table cellpadding="2" cellspacing="2" width="268" align="center"style="font-family:Times;font-size:12px;box-shadow: 0 0 15px #999;color:#000";border-collapse:collapse; class="wrapper1">
        <tr style="" >
          <td><img src="Login.gif" ></td>
          <td><img src="billing.gif" ></td>
        </tr>
        <tr style="">
        
          <td colspan="2"><h3 align="center">Silahkan Masukan<br>
          User dan Password </h3></td>
        </tr>
        <form name="f1" method="post" action="">
          <tr style="" >
            <td width="69">User ID</td>
            <td width="209"><input type="text" name="txuserid" id="txuserid" size="10" maxlength="10" required /></td>
          </tr>
          <tr style="" >
            <td>Password</td>
            <td><input type="password" name="txpassword" id="txpassword" size="15" maxlength="10" required /></td>
          </tr>
          <tr style="">
            <td>&nbsp;</td>
            <td><input type="submit" name="login" value="Login" />
              &nbsp;
              <input type="reset" name="reset" value="Batal" /></td>
          </tr>
        </form>
      </table>
      <!--/div--></td>
  </tr>
</table>
<p style="text-shadow:2px -2px 2px red;color:#fff;font-size:18px;font-weight:bold;margin-left:10em;font-family:Broadway;">Misi : </p>
<p style="text-shadow:2px -2px 2px yellow;color:#000;margin-left:15em;font-weight:bold;font-family:Courier;font-size:14px;">1. Meningkatkan Kualitas Pelayanan Kepada Pelanggan (Kualitas,Kuantitas dan Kontinuitas).
<br>2. Meningkatkan Cakupan Pelayanan Menjadi 53%.
<br>3. Menurunkan Kebocoran Menjadikan 22%.
<br>4. Perusahaan Tetap Dalam Full Cost Recovery (FCR).
<br>5. Meningkatkan Efisiensi Penagihan Menjadi 90%.
<br>6. Meningkatkan Kualitas, Profesionalisme dan Kesejahteraan Pegawai.
<br>7. Menjadikan PDAM Jayapura Sebagai Salah Satu PDAM Terbaik di Wilayah Timur Indonesia.
<br>8. Terdepan Dalam Mensukseskan Pembangunan Daerah.</p></br>
</body></html>
