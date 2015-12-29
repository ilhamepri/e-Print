<?php	
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$warna = $_REQUEST['warna'];
		$idwarna = $_REQUEST['idwarna'];

		
		$sql = mysql_query("INSERT INTO warna_print VALUES('$idwarna','$warna')");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=warna');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
?>
<h2>Tambah Kategori</h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=warna&aksi=baru" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="idwarna" class="col-sm-2 control-label">ID Warna Print</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="idwarna" name="idwarna" placeholder="ID Warna Print" required autofocus>
		</div>
	</div>
	<div class="form-group">
		<label for="warna" class="col-sm-2 control-label">Warna Print</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="warna" name="warna" placeholder="Warna Print" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=warna" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php
	}
}
?>