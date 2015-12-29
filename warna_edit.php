<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$nama = $_REQUEST['nama'];
		$idkategori = $_REQUEST['idkategori'];
		
		$sql = mysql_query("UPDATE kelompok SET namakelompok='$nama' WHERE idkategori='$idkategori'");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=kelompok');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
		$idwarna = $_REQUEST['id_warnaprint'];
		$sql = mysql_query("SELECT * FROM warna_print WHERE id_warnaprint='$$idwarna'");
		list($idwarna,$warna) = mysql_fetch_array($sql);
		echo $nama;
?>
<h2>Edit Data Barang</h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=kelompok&aksi=edit" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="idwarna" class="col-sm-2 control-label">ID Warna Print</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="idwarna" name="idwarna" value="<?php echo $idwarna; ?> "readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="warna" class="col-sm-2 control-label">Warna Print</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="warna" name="warna" value="<?php echo $warna; ?>">
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=kelompok" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php

	}
}
?>