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
    <title>Login User</title>
    <script type="text/javascript">
		function fokus(){
			document.getElementById('txuserid').focus();
		}
    </script>
</head>
<body style="background:linear-gradient(#09f, #ccf);width:100%" onLoad="return fokus();">
	
		<!--############################################################################################################--><!--############################################################################################################-->
	 
	
<?php
//mysql_close();
putus();
//require_once("foot.php");
?>
<table align="center">
  <tr height="800px">
    <td><!--div style="height:300px;overflow:auto"-->
      <table width="300px" align="center"style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;box-shadow: 0 0 15px #999;style="background:linear-gradient(#ff0, #ccf);" >
        <tr bgcolor="#c0c0c0">
          <td colspan="2"><h3 align="center">LOGIN USERxxxx<br/>
            Billing System PDAM Jayapura</h3></td>
        </tr>
        <form name="f1" method="post" action="">
          <tr>
            <td width="100px">User ID</td>
            <td><input type="text" name="txuserid" id="txuserid" size="7" maxlength="10" required /></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" name="txpassword" id="txpassword" size="15" maxlength="10" required /></td>
          </tr>
          <tr>
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
</body></html>
