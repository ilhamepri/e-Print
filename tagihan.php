<?php
$waktu=date('Y-m-d');
$sql = mysql_query("SELECT MAX(id_pembayaran) FROM pembayaran");
list($maks) = mysql_fetch_row($sql);
		$idang = substr($maks, 2, 5);
		$idang = $idang + 1;
		if($idang <= 9) $idhasil = "PM000".$idang;
		if($idang <= 99 && $idang >9) $idhasil = "PM00".$idang;
		if($idang <= 999 && $idang >99) $idhasil = "PM0".$idang;
		if($idang <= 9999 && $idang >999) $idhasil = "PM".$idang;
		
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$jumlah = $_REQUEST['jumlah'];
		$sql=mysql_query("update pemesanan set status='lunas' where id_pemesanan='$id_pemesanan'");
		$sql=mysql_query("insert into pembayaran values('$idhasil','$id_pemesanan','$waktu','$jumlah',NULL)");
		if($sql > 0){
			header('Location: ./admin.php?hlm=tagihan');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		$iduser=$_SESSION['iduser'];
		$sql = mysql_query("SELECT dp.id_pemesanan,dp.id_item,dp.halaman,p.iduser FROM detail_pemesanan dp,pemesanan p  where dp.id_pemesanan=p.id_pemesanan and p.iduser='$iduser' and p.status='sudah' ORDER BY p.id_pemesanan");
		$sql2 = mysql_query("SELECT dp.id_pemesanan FROM detail_pemesanan dp,pemesanan p  where dp.id_pemesanan=p.id_pemesanan and p.iduser='$iduser' and dp.status='sudah' ORDER BY p.id_pemesanan desc");
		list($idpem)=mysql_fetch_array($sql2);
		echo '<h2>Tagihan Print</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-9"><table class="table table-hover">';
		echo '<tr class="success"><th>#</th><th width="125">ID Daftar Print</th><th width="150">Tipe Item</th><th>Halaman</th>';
		echo '<th>Harga</th><th>Total</th></tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$jml = 0;
			$no = 1;
			while(list($id_pemesanan,$tipe,$halaman) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$id_pemesanan.'</td>';
				$qitem = mysql_query("SELECT nama_item,harga FROM item WHERE id_item='$tipe'");
				list($item,$harga) = mysql_fetch_array($qitem);
				echo '<td>'.$item.'</td>';
				echo '<td>'.$halaman.'</td>';
				echo '<td>Rp '.$harga.' ,-</td>';
				$total=($halaman*$harga);
				echo '<td>Rp '.$total.' ,-</td>';
				$jml += $total;
				echo '</tr>';
				$no++;
			}
			    echo '<tr><td colspan="5"><span><b><em>T O T A L</em></b></span></td><td><span><b>Rp '.$jml.' ,-</span></b></td></tr>';
				echo '<tr><td colspan="6"><a href="./admin.php?hlm=tagihan&submit=ya&id_pemesanan='.$idpem.'&jumlah='.$jml.'" class="btn btn-info btn-xs btn-block">Klik Button ini, Jika sudah selesai</a></td></tr>';

		} else {
			echo '<tr><td colspan="9"><em>Belum ada data print</em></td></tr>';
		}
		
		echo '</table></div></div>';
	}
}
?>