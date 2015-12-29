<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$idwarna = $_REQUEST['id_warnaprint'];
		
		$sql = mysql_query("DELETE FROM warna_print WHERE id_warnaprint='$idwarna'");
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=warna');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		//dialog untuk memastikan proses hapus dilakukan secara sadar
		$idwarna = $_REQUEST['id_warnaprint'];
		
		echo '<div class="alert alert-danger">Yakin akan menghapus:';
		echo '<br>ID Warna Print  : <strong>'.$idwarna.'</strong>';
		$qwarna = mysql_query("SELECT warnaprint FROM warna_print WHERE id_warnaprint='$idwarna'");
		list($warna) = mysql_fetch_array($qwarna);
		echo '<br>Warna : '.$warna.'<br><br>';
		
		echo '<br><br>Aksi ini permanen!<br><br>';
		echo '<a href="./admin.php?hlm=master&sub=warna&aksi=hapus&submit=ya&id_warnaprint='.$idwarna.'" class="btn btn-sm btn-success">Ya, Hapus</a> ';
		echo '<a href="./admin.php?hlm=master&sub=warna" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>