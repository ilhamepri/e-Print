<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$iditem = $_REQUEST['id_item'];
		$sql = mysql_query("DELETE FROM item WHERE id_item='$iditem'");
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=item');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		$iditem = $_REQUEST['id_item'];
		$sql = mysql_query("SELECT * FROM item WHERE id_item='$iditem'");
		list($idtem,$idkertas,$idwarna,$nama,$harga) = mysql_fetch_array($sql);
		
		echo '<div class="alert alert-danger">Yakin akan menghapus Item:';
		echo '<br>Nama Item  : <strong>'.$nama.'</strong>';
		echo '<br>ID Item   : '.$iditem;
		echo '<br>Harga : '.$harga.' <br><br>';
		echo '<a href="./admin.php?hlm=master&sub=item&aksi=hapus&submit=ya&id_item='.$iditem.'" class="btn btn-sm btn-success">Ya, Hapus</a> ';
		echo '<a href="./admin.php?hlm=master&sub=item" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>