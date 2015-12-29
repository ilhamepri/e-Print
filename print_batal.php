<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$id_item = $_REQUEST['id_item'];
		$sql = mysql_query("DELETE FROM detail_pemesanan WHERE id_item='$id_item'");
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=print');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$id_item = $_REQUEST['id_item'];
		$sql = mysql_query("SELECT * FROM detail_pemesanan WHERE id_item='$id_item'");
		list($id_pemesanan,$iditem,$halaman) = mysql_fetch_array($sql);
		echo '<div class="alert alert-danger">Yakin akan membatalkan:';	
		echo '<br>ID Daftar Print : <strong>'.$id_pemesanan.'</strong><br>';		
		$qitem = mysql_query("SELECT nama_item from item where id_item='$iditem'");
		list($item) = mysql_fetch_array($qitem);
		
		echo '<br>Tipe Item : <strong>'.$item.'</strong><br><br>';
		echo '<a href="./admin.php?hlm=master&sub=print&aksi=batal&submit=ya&id_item='.$id_item.'" class="btn btn-sm btn-success">Ya, Batal</a> ';
		echo '<a href="./admin.php?hlm=master&sub=print" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>