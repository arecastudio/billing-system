<html>
<head>
<title>Untitled Document</title>
<script language="javascript">
    // http://cariprogram.blogspot.com
        // nuramijaya@gmail.com
        
        var kembali1 = '';
        var kembali2 = '';
        var i;
        function cekpegawai()
        {
                kembali1='';
                kembali2='';
                for (i=1;i<=3;i++) //jika ingin dinamis, jumlahnya diganti <?php // echo $jmldata; ?> 
                {
                        if (document.getElementById('cek'+i).checked==true)
                        {
                                if (kembali1=='')
                                {
                                        kembali1='Pegawai'+i;
                                        kembali2=document.getElementById('hidden'+i).value;
                                }
                                else
                                {
                                        kembali1=kembali1+',Pegawai'+i;
                                        kembali2=kembali2+','+document.getElementById('hidden'+i).value;
                                }
                        }
                }
        }
</script>
</head>

<body>
Klik Nama Pegawai Untuk Memilih 1 Pegawai, <br />
Untuk Memilih Banyak Pegawai pilih Checkbox Kemudian Klik OK.<br />
<?php // jika ingin dinamis datanya, query ke database while { ?>
<input type="checkbox" name="cek1" id="cek1" />
<a href="#" onclick="window.opener.document.getElementById('input1').value = 'Pegawai1'; window.opener.document.getElementById('input2').value = document.getElementById('hidden1').value; window.close(); /*window.opener.document.location='refresh.html'*/;">Pegawai1</a>
<input name="hidden1" type="hidden" id="hidden1" value="NIP1" />
<br />
<input type="checkbox" name="cek2" id="cek2" />
<a href="#" onclick="window.opener.document.getElementById('input1').value = 'Pegawai2'; window.opener.document.getElementById('input2').value = document.getElementById('hidden2').value; window.close(); /*window.opener.document.location='refresh.html'*/;">Pegawai2</a>
<input name="hidden2" type="hidden" id="hidden2" value="NIP2" />
<br />
<input type="checkbox" name="cek3" id="cek3" />
<a href="#" onclick="window.opener.document.getElementById('input1').value = 'Pegawai3'; window.opener.document.getElementById('input2').value = document.getElementById('hidden3').value; window.close(); /*window.opener.document.location='refresh.html'*/;">Pegawai3</a>
<input name="hidden3" type="hidden" id="hidden3" value="NIP3" />
<br />
<input type="button" name="button3" id="button3" value="Ok" onclick="cekpegawai(); window.opener.document.getElementById('input1').value = kembali1; window.opener.document.getElementById('input2').value = kembali2; window.opener.document.getElementById('button2').style.visibility='visible'; window.close(); " />
</body>
</html>
