<?php	
$sql = mysql_query("SELECT MAX(id_pemesanan) FROM pemesanan");
list($maks) = mysql_fetch_row($sql);
		$idang = substr($maks, 2, 5);
		$idang = $idang + 1;
		if($idang <= 9) $idhasil = "PR000".$idang;
		if($idang <= 99 && $idang >9) $idhasil = "PR00".$idang;
		if($idang <= 999 && $idang >99) $idhasil = "PR0".$idang;
		if($idang <= 9999 && $idang >999) $idhasil = "PR".$idang;

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
				include 'print_baru.php';
				break;
			case 'edit':
				include 'print_edit.php';
				break;
			case 'batal':
				include 'print_batal.php';
				break;
			case 'print':
				include 'print_print.php';
				break;
		}
	} else {
		$id=$_SESSION['iduser'];
		$sql = mysql_query("SELECT dp.id_pemesanan,dp.id_item,dp.halaman,dp.file,dp.komentar,dp.status,p.iduser FROM pemesanan p,detail_pemesanan dp where dp.id_pemesanan=p.id_pemesanan and p.iduser='$id' and dp.status is null ORDER BY id_pemesanan");
		$sql2 = mysql_query("SELECT p.id_pemesanan FROM pemesanan p where iduser='$id' and p.status is null ORDER BY id_pemesanan");
			if( mysql_num_rows($sql2) > 0 ){
				list($idhasil)=mysql_fetch_array($sql2);
			}
		echo '<h2>Daftar Print</h2><hr>';
		echo '<div class="row">';
		echo '<div class="col-md-9"><table class="table table-hover">';
		echo '<tr class="success"><th>#</th><th width="125">ID Daftar Print</th><th width="150">Tipe Item</th><th>Halaman</th><th>File</th><th>Komentar</th>';
		echo '<th width="100"><a href="./admin.php?hlm=master&sub=print&aksi=baru&id_pemesanan='.$idhasil.'" class="btn btn-success btn-xs btn-block">Tambah</a></th></tr>';
		
		if( mysql_num_rows($sql) > 0 ){
			$no = 1;
			while(list($id_pemesanan,$tipe,$halaman,$file,$komentar,$status) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$id_pemesanan.'</td>';
				$qitem = mysql_query("SELECT nama_item,harga FROM item WHERE id_item='$tipe'");
				list($item) = mysql_fetch_array($qitem);
				echo '<td>'.$item.'</td>';
				echo '<td>'.$halaman.'</td>';
				echo '<td><a href="'.$file.'">View</a></td>';
				echo '<td>'.$komentar.'</td>';
				echo '<td> <div class="btn-group"><a href="./admin.php?hlm=master&sub=print&aksi=edit&id_pemesanan='.$id_pemesanan.'&id_item='.$tipe.'" class="btn btn-info btn-xs">Ganti</a> ';
				echo '<a href="./admin.php?hlm=master&sub=print&aksi=batal&id_pemesanan='.$id_pemesanan.'&id_item='.$tipe.'" class="btn btn-danger btn-xs">Batal</a></div></td>';
				echo '</tr>';
				$no++;
			}
				$sql = mysql_query("SELECT dp.id_pemesanan FROM pemesanan p,detail_pemesanan dp where dp.id_pemesanan=p.id_pemesanan and p.iduser='$id' and dp.status is null ORDER BY id_pemesanan");
				list($id_pemesanan) = mysql_fetch_array($sql);
				echo '<tr><td colspan="9"><a href="./admin.php?hlm=master&sub=print&aksi=print&iduser='.$id.'&id_pemesanan='.$id_pemesanan.'" class="btn btn-info btn-xs btn-block">Print</a></td></tr>';
		} else {
			echo '<tr><td colspan="9"><em>Belum ada data print</em></td></tr>';
		}
		
		echo '</table></div></div>';
	}
}
?>