<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$kertas = $_REQUEST['kertas'];
		$idjenis = $_REQUEST['jenis'];
		
		$sql = mysql_query("UPDATE jenis_kertas SET jeniskertas='$kertas' WHERE id_jeniskertas='$idjenis'");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=kertas');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
		$id_jeniskertas = $_REQUEST['id_jeniskertas'];
		$sql = mysql_query("SELECT * FROM jenis_kertas WHERE id_jeniskertas='$id_jeniskertas'");
		list($idjenis,$kertas) = mysql_fetch_array($sql);
		//echo $kertas;
?>
<h2>Edit Jenis Kertas</h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=kertas&aksi=edit" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="idjenis" class="col-sm-2 control-label">ID Jenis Kertas</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo $idjenis; ?>" readonly required autofocus>
		</div>
	</div>
	<div class="form-group">
		<label for="kertas" class="col-sm-2 control-label">Jenis Kertas</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="kertas" name="kertas" value="<?php echo $kertas; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=kertas" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php

	}
}
?>