<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['aksi'] )){
		$aksi = $_REQUEST['aksi'];
		switch($aksi){
			case 'print':
				include 'daftarprint_print.php';
				break;
		}
	} else {
		$iduser=$_SESSION['iduser'];
		$sql = mysql_query("SELECT dp.id_pemesanan,dp.id_item,dp.halaman,dp.file,dp.komentar,dp.status,p.iduser,p.tanggal FROM pemesanan p,detail_pemesanan dp where dp.id_pemesanan=p.id_pemesanan and dp.status='belum' ORDER BY id_pemesanan");
		echo '<h2>Daftar Print</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-9"><table class="table table-hover">';
		echo '<tr class="success"><th>#</th><th width="125">ID Daftar Print</th><th>Atas Nama</th><th width="150">Tipe Item</th><th>Halaman</th><th width="100">File</th><th width="125">Komentar</th><th width="100"></th>';
		echo '</tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($id_pemesanan,$tipe,$halaman,$file,$komentar,$status,$iduser,$tanggal) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$id_pemesanan.'</td>';
				$quser = mysql_query("SELECT username FROM user WHERE iduser='$iduser'");
				list($user) = mysql_fetch_array($quser);
				echo '<td>'.$user.'</td>';
				$qitem = mysql_query("SELECT nama_item,harga FROM item WHERE id_item='$tipe'");
				list($item) = mysql_fetch_array($qitem);
				echo '<td>'.$item.'</td>';
				echo '<td>'.$halaman.'</td>';
				echo '<td><a href="'.$file.'">Download</a></td>';
				echo '<td>'.$komentar.'</td>';
				echo '<td><a href="./admin.php?hlm=master&sub=daftar&aksi=print&id_pemesanan='.$id_pemesanan.'&id_item='.$tipe.'&iduser='.$iduser.'" class="btn btn-info btn-xs btn-block">Print</a> ';
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