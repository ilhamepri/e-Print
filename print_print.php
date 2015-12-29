<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$iduser = $_REQUEST['iduser'];
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$sql = mysql_query("update detail_pemesanan set status='belum' WHERE id_pemesanan='$id_pemesanan'");
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=print');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		$iduser = $_REQUEST['iduser'];
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$sql = mysql_query("SELECT * FROM pemesanan WHERE id_pemesanan='$id_pemesanan'");
		list($id_pemesanan,$iduser,$tanggal,$status) = mysql_fetch_array($sql);
		
		echo '<div class="alert alert-info">Yakin akan mengeprint:';
		$quser = mysql_query("SELECT username from user where iduser='$iduser'");
		list($user) = mysql_fetch_array($quser);
		echo '<br>Pengguna  : <strong>'.$user.'</strong>';
		echo '<br>ID Daftar Print : <strong>'.$id_pemesanan.'</strong><br><br>';		
		echo '<a href="./admin.php?hlm=master&sub=print&aksi=print&submit=ya&iduser='.$iduser.'&id_pemesanan='.$id_pemesanan.'" class="btn btn-sm btn-info">Ya, Print</a> ';
		echo '<a href="./admin.php?hlm=master&sub=print" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>