<?php
if( empty( $_SESSION['iduser'] ) ){
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['sub'] )){
		
		$sub = $_REQUEST['sub'];
		
		switch($sub){
			case 'warna':
				include 'warna.php';
				break;
			case 'kertas':
				include 'kertas.php';
				break;
			case 'print':
				include 'print.php';
				break;
			case 'item':
				include 'item.php';
				break;
			case 'daftar':
				include "daftarprint.php";
				break;

		}
	} else {
		//tampilkan daftar user		
		if(isset($_REQUEST['aksi'])){
			$aksi = $_REQUEST['aksi'];
			
			switch($aksi){
				case 'baru':
					include 'user_baru.php';
					break;
				case 'edit':
					include 'user_edit.php';
					break;
				case 'hapus':
					include 'user_hapus.php';
					break;
			}
		} else {
			echo '<h2>Daftar User</h2><hr>';
			
			$sql = mysql_query("SELECT iduser,username,admin,fullname FROM user ORDER BY iduser");
			
			//diasumsikan bahwa selalu ada user, minimal user awal yaitu: admin dan kasir
			$no = 1;
         echo '<div class="row">';
         echo '<div class="col-md-6">';
			echo '<table class="table table-hover">';
			echo '<tr class="danger"><th width="50">No.</th><th>Username</th><th width="100">Nama Lengkap</th><th width="50">Admin</th>';
			echo '<th width="50"><a href="admin.php?hlm=master&aksi=baru" class="btn btn-success btn-xs">Tambah User</a></th></tr>';
			while(list($id,$username,$admin,$fullname) = mysql_fetch_array($sql)){
				echo '<tr><td>'.$no.'</td>';
				echo '<td>'.$username.'</td>';
				echo '<td>'.$fullname.'</td>';
				echo '<td>';
				echo ($admin == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '';
				echo '</td>';
				echo '<td><div class="btn-group"><a href="admin.php?hlm=master&aksi=edit&id='.$id.'" class="btn btn-info btn-xs">Edit</a> ';
				echo '<a href="admin.php?hlm=master&aksi=hapus&id='.$id.'" class="btn btn-danger btn-xs">Hapus</a></div></td></tr>';
				$no++;
			}
			echo '</table>';
         echo '</div></div>';
		}
	}
}
?>