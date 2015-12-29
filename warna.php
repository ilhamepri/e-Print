<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['aksi'] )){
		$aksi = $_REQUEST['aksi'];
		
		if($aksi == 'baru'){
			include 'warna_baru.php';
		}
		if($aksi == 'edit'){
			include 'warna.php';
		}
		if($aksi == 'hapus'){
			include 'warna_hapus.php';
		}
		
	} else {

		$sql = mysql_query("SELECT * FROM warna_print ORDER BY id_warnaprint");
		echo '<h2>Daftar Warna Print</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-7"><table class="table table-hover">';
		echo '<tr class="success"><th width="50">#</th><th>ID Warna Print</th><th>Warna Print</th>';
		echo '<th width="100"><a href="./admin.php?hlm=master&sub=warna&aksi=baru" class="btn btn-success btn-xs">Tambah Data</a></th></tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($idwarna,$nama) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$idwarna.'</td>';
				echo '<td>'.$nama.'</td>';
				echo '<td><div class="btn-group"><a href="./admin.php?hlm=master&sub=warna&aksi=edit&id_warnaprint='.$idwarna.'" class="btn btn-info btn-xs">Edit</a> ';
				echo '<a href="./admin.php?hlm=master&sub=warna&aksi=hapus&id_warnaprint='.$idwarna.'" class="btn btn-danger btn-xs">Hapus</a></div></td>';
				echo '</tr>';
				$no++;
			}
		} else {
			echo '<tr><td colspan="4"><em>Belum ada data</em></td></tr>';
		}
		
		echo '</table></div></div>';
	}
}
?>