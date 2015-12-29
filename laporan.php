<?php
if( empty( $_SESSION['iduser'] ) ){
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
   if( isset( $_REQUEST['sub'] )){
      $sub = $_REQUEST['sub'];
      
      include "laporan_tagihan.php";
   } else {
   
      if(isset($_REQUEST['submit'])){
         $submit = $_REQUEST['submit'];
         $tgl1 = $_REQUEST['tgl1'];
         $tgl2 = $_REQUEST['tgl2'];
         
         //echo $tgl1.'-'.$tgl2;
         $q = "SELECT id_pembayaran,total FROM pembayaran WHERE tanggal BETWEEN '$tgl1' AND '$tgl2' ";
         
         echo '<h2>Rekap Pembayaran <small>'.$tgl1.' sampai '.$tgl2.'</small></h2><hr>';
         echo '<a href="./cetak_data.php?tanggal1='.$tgl1.'&tanggal2='.$tgl2.'" class="noprint pull-right btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</a>';
         
      } else {
         $tgl = date("Y/m/d");
         $q = "SELECT id_pembayaran,total FROM pembayaran WHERE tanggal='$tgl' ";
         echo '<h2>Data Pembayaran <small>'.$tgl.'</small></h2><hr>';
      }
      
      $sql = mysql_query($q);
      
      echo '<div class="row">';
      echo '<div class="col-md-5">';
?>
<div class="well well-sm noprint">
<form class="form-inline" role="form" method="post" action="">
  <div class="form-group">
    <label class="sr-only" for="tgl1">Mulai</label>
    <input type="date" class="form-control" id="tgl1" name="tgl1">
  </div>
  <div class="form-group">
    <label class="sr-only" for="tgl2">Hingga</label>
    <input type="date" class="form-control" id="tgl2" name="tgl2">
  </div>
  <button type="submit" name="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Tampilkan</button>
</form>
</div>
<?php
      echo '<table class="table table-hover">';
      echo '<tr class="info"><th width="50">#</th><th>ID Pembayaran</th><th><span class="pull-right">Jumlah</th></tr>';
      
      $total = 0;
      $no=1;
      while(list($pembayaran,$jml) = mysql_fetch_array($sql)){
         echo '<tr><td>'.$no.'</td><td>'.$pembayaran.'</td><td><span class="pull-right">'.$jml.'</span></td></tr>';
         $total += $jml;
         $no++;
      }
      
      echo '<tr><td colspan="2"><span class="pull-right"><strong>T O T A L</strong></span></td><td><span class="pull-right"><strong>'.$total.'</strong></span></td></tr>';
      echo '</table>';
      echo '</div></div>';
   }
}
?>