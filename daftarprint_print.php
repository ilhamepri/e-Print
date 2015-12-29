<?php
$waktu=date('Y-m-d');
$qid = mysql_query("SELECT MAX(id_pembayaran) FROM pembayaran");
list($maks) = mysql_fetch_row($qid);
		$idang = substr($maks, 1, 4);
		$idang = $idang + 1;
		if($idang <= 9) $idhasil = "P000".$idang;
		if($idang <= 99 && $idang >9) $idhasil = "P00".$idang;
		if($idang <= 999 && $idang >99) $idhasil = "P0".$idang;
		if($idang <= 9999 && $idang >999) $idhasil = "P".$idang;
		
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$id_item = $_REQUEST['id_item'];
		$iduser = $_REQUEST['iduser'];
		
		$sql = mysql_query("UPDATE detail_pemesanan SET status='sudah' where id_pemesanan='$id_pemesanan' and id_item='$id_item'");
		$sql2 = mysql_query("select dp.id_pemesanan from detail_pemesanan dp,pemesanan p where dp.id_pemesanan=p.id_pemesanan and dp.id_pemesanan='$id_pemesanan' and p.iduser='$iduser' and dp.status='sudah'");
		if( mysql_num_rows($sql2) > 0 ){
			$sql3 = mysql_query("update pemesanan set status='sudah' where id_pemesanan='$id_pemesanan'");
		}
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=daftar');
			die();
		} else {
			echo 'ada ERROR dengan query';
		}
	} else {
		//dialog untuk aksi print
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$id_item = $_REQUEST['id_item'];
		$iduser = $_REQUEST['iduser'];
		
		echo '<div class="alert alert-info">Print Item:';
		echo '<br>ID Daftar Print  : <strong>'.$id_pemesanan.'</strong>';
		//dialog query salah :D skip dulu pake id
		//$qdaftar = mysql_query("SELECT dp.id_pemesanan,dp.id_item,p.iduser FROM pemesanan p,detail_pemesanan dp where dp.id_pemesanan=p.id_pemesanan and p.id_pemesanan='$id_pemesanan' and p.iduser='$iduser'");
		//list($id_pemesanan,$id_item,$iduser) = mysql_fetch_array($qdaftar);
		//$quser = mysql_query("SELECT username FROM user WHERE iduser='$iduser'");
		//list($user) = mysql_fetch_array($quser);
		//$qitem = mysql_query("SELECT nama_item FROM item WHERE id_item='$id_item'");
		//list($item) = mysql_fetch_array($qitem);
		//wkkwkwk
		echo '<br>Pelanggan : '.$iduser.'';
		echo '<br>Item : '.$id_item.'<br><br>';
		
		echo '<a href="./admin.php?hlm=master&sub=daftar&aksi=print&submit=ya&id_pemesanan='.$id_pemesanan.'&id_item='.$id_item.'&iduser='.$iduser.'" class="btn btn-sm btn-success">Ya, Print</a> ';
		echo '<a href="./admin.php?hlm=master&sub=daftar" class="btn btn-sm btn-default">Tidak</a>';
		echo '</div>';
	}
}
?>