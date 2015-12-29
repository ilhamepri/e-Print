<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if(isset($_REQUEST['submit'])){
		$id_pembayaran = $_REQUEST['id_pembayaran'];
		$id_pemesanan = $_REQUEST['id_pemesanan'];

		$sql3=mysql_query("update pembayaran set status_pembayaran='lunas' where id_pembayaran='$id_pembayaran' and id_pemesanan='$id_pemesanan'");
		if($sql3 > 0){
			header('Location: ./admin.php?hlm=bayar');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}

	} else {
		$id=$_SESSION['iduser'];
		$sql = mysql_query("SELECT * FROM pembayaran where status_pembayaran is NULL ORDER BY id_pembayaran");
		echo '<h2>Daftar Pembayaran</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-9"><table class="table table-hover">';
		echo '<tr class="success"><th>#</th><th width="125">ID Pembayaran</th><th width="125">ID Daftar Print</th><th>Atas Nama</th><th>Tanggal</th><th>Total</th><th width="100"></th>';
		echo '</tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($idpembayaran,$idpemesanan,$tanggal,$total,$status) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$idpembayaran.'</td>';
				echo '<td>'.$idpemesanan.'</td>';
				//query mencari username
				$sql1 = mysql_query("SELECT iduser FROM pemesanan where id_pemesanan='$idpemesanan'");
				list($id1)=mysql_fetch_array($sql1);
				$sql2 = mysql_query("SELECT username FROM user where iduser='$id1'");
				list($id2)=mysql_fetch_array($sql2);
				echo '<td>'.$id2.'</td>';

				echo '<td>'.$tanggal.'</td>';
				echo '<td>'.$total.'</td>';
				echo '<td><a href="./admin.php?hlm=bayar&submit=ya&id_pembayaran='.$idpembayaran.'&id_pemesanan='.$idpemesanan.'" class="btn btn-info btn-xs btn-block">Selesai</a> ';
				echo '</td>';
				echo '</tr>';
				$no++;
			}
		} else {
			echo '<tr><td colspan="9"><em>Belum ada data print</em></td></tr>';
		}
		
		echo '</table></div></div>';
	}
}

?>