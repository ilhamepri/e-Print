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
			include 'kertas_baru.php';
		}
		if($aksi == 'edit'){
			include 'kertas_edit.php';
		}
		if($aksi == 'hapus'){
			include 'kertas_hapus.php';
		}
		
	} else {

		$sql = mysql_query("SELECT * FROM jenis_kertas ORDER BY id_jeniskertas");
		echo '<h2>Daftar Jenis Kertas</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-7"><table class="table table-hover">';
		echo '<tr class="success"><th width="50">#</th><th>ID Kertas</th><th>Kertas</th>';
		echo '<th width="100"><a href="./admin.php?hlm=master&sub=kertas&aksi=baru" class="btn btn-success btn-xs">Tambah Data</a></th></tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($idmerk,$merk) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$idmerk.'</td>';
				echo '<td>'.$merk.'</td>';
				echo '<td><div class="btn-group"><a href="./admin.php?hlm=master&sub=kertas&aksi=edit&id_jeniskertas='.$idmerk.'" class="btn btn-info btn-xs">Edit</a> ';
				echo '<a href="./admin.php?hlm=master&sub=kertas&aksi=hapus&id_jeniskertas='.$idmerk.'" class="btn btn-danger btn-xs ">Hapus</a></div></td>';
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