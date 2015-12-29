<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$idjenis = $_REQUEST['id_jeniskertas'];
		
		$sql = mysql_query("DELETE FROM jenis_kertas WHERE id_jeniskertas='$idjenis'");
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=kertas');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		//dialog untuk memastikan proses hapus dilakukan secara sadar
		$idjenis = $_REQUEST['id_jeniskertas'];
		
		echo '<div class="alert alert-danger">Yakin akan menghapus:';
		echo '<br>ID Jenis Kertas  : <strong>'.$idjenis.'</strong>';
		$qkertas = mysql_query("SELECT jeniskertas FROM jenis_kertas WHERE id_jeniskertas='$idjenis'");
		list($kertas) = mysql_fetch_array($qkertas);	
		echo '<br>Kertas : '.$kertas.'<br><br>';
		
		echo '<br><br>Aksi ini permanen!<br><br>';
		echo '<a href="./admin.php?hlm=master&sub=kertas&aksi=hapus&submit=ya&id_jeniskertas='.$idjenis.'" class="btn btn-sm btn-success">Ya, Hapus</a> ';
		echo '<a href="./admin.php?hlm=master&sub=kertas" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>