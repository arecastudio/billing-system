<?php
$mode=$_GET['mode'];
require_once("mydb.php");
//====================================================

if($mode=='wilayah-view'){
	$id_cabang=$_GET['id_cabang'];
	$jurusan=mysql_query("select * from master_wilayah where kode_cabang='$id_cabang'");
	$cek=mysql_num_rows($jurusan);
	if($cek){
		?>	
		<select title="optwil" name="id_wil" id="id_wil" onchange="wilayah(id_wil.value);">
		<?
		while($row=mysql_fetch_array($jurusan)){
			$id_wil=$row['kode_wilayah'];
			$nama_wil=$row['nama_wilayah'];
			?><option value="<? echo $id_wil; ?>"><? echo $nama_wil; ?></option><?
		}
		?></select><?
	}else{
		echo "Silahkan pilih nama Wilayah";
	}
}else if($mode=='blok-view'){
	$id_wilayah=$_GET['id_wil'];
	$jurusan=mysql_query("select * from master_blok where kode_wilayah='$id_wilayah'");
	$cek=mysql_num_rows($jurusan);
	if($cek){
		?>	
		<select title="optblok" name="id_blok" id="id_blok">
		<?
		while($row=mysql_fetch_array($jurusan)){
			$id_blok=$row['kode_blok'];
			$nama_blok=$row['ket_blok'];
			?><option value="<? echo $id_blok; ?>"><? echo $nama_blok; ?></option><?
		}
		?></select><?
	}else{
		echo "Silahkan pilih nama Blok";
	}
}
?>