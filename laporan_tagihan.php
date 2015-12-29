<?php
if( empty( $_SESSION['iduser'] ) ){
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
   echo '<h2>Rekap Pembayaran</h2><hr>';
   echo '<a href="./cetak_rekap.php?cetak_rekap"class="noprint pull-right btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</a>';
   $sql = mysql_query("select * from pembayaran where status_pembayaran='lunas'");
   
   echo '<div class="row">';
   echo '<div class="col-md-7">';
   echo '<table class="table table-hover">';
   echo '<tr class="info"><th width="50">#</th><th>ID Pembayaran</th><th>ID Pemesanan</th><th>Tanggal</th><th>Jumlah</th></tr>';
   
   $no=1;
   while(list($idpembayaran,$idpemesanan,$tanggal,$total)=mysql_fetch_array($sql)){
      echo '<tr><td>'.$no.'</td><td>'.$idpembayaran.'</td><td>'.$idpemesanan.'</td><td>'.$tanggal.'</td><td>'.$total.'</td>';
      $no++;
   }
   echo '</table></div></div>';
}
?>