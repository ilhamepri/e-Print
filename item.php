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
			case 'baru':
				include 'item_baru.php';
				break;
			case 'edit':
				include 'item_edit.php';
				break;
			case 'hapus':
				include 'item_hapus.php';
				break;
		}
	} else {
		$sql = mysql_query("SELECT * FROM item ORDER BY id_item");
		echo '<h2>Daftar Item</h2><hr>';
      echo '<div class="row">';
		echo '<div class="col-md-9"><table class="table table-hover">';
		echo '<tr class="danger"><th>#</th><th width="100">ID Item</th><th>Nama Item</th><th>Jenis Kertas</th><th>Warna Print</th><th width="100">Harga@</th>';
		echo '<th width="100"><a href="./admin.php?hlm=master&sub=item&aksi=baru" class="btn btn-success btn-xs">Tambah Item</a></th></tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($iditem,$idkertas,$idwarna,$nama,$harga) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$iditem.'</td>';
				echo '<td>'.$nama.'</td>';
				$qkertas = mysql_query("SELECT jeniskertas FROM jenis_kertas WHERE id_jeniskertas='$idkertas'");
				list($kertas) = mysql_fetch_array($qkertas);
				echo '<td>'.$kertas.'</td>';
				$qwarna = mysql_query("SELECT warnaprint from warna_print where id_warnaprint='$idwarna'");
				list($warna) = mysql_fetch_array($qwarna);
				echo '<td>'.$warna.'</td>';
				echo '<td>Rp. '.$harga.',-</td>';
				echo '<td><div class="btn-group"><a href="./admin.php?hlm=master&sub=item&aksi=edit&id_item='.$iditem.'" class="btn btn-info btn-xs">Edit</a> ';
				echo '<a href="./admin.php?hlm=master&sub=item&aksi=hapus&id_item='.$iditem.'" class="btn btn-danger btn-xs">Hapus</a></div></td>';
				echo '</tr>';
				$no++;
			}
		} else {
			echo '<tr><td colspan="9"><em>Belum ada data barang</em></td></tr>';
		}
		
		echo '</table></div></div>';
	}
}
?>