<?php
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$iditem = $_REQUEST['iditem'];
		$nama = $_REQUEST['nama'];
		$idkertas = $_REQUEST['kertas'];
		$idwarna = $_REQUEST['warna'];
		$hargasatuan = $_REQUEST['hargasatuan'];
		
		$sql = mysql_query("UPDATE item SET nama_item='$nama', id_jeniskertas='$idkertas', id_warnaprint='$idwarna', harga='$hargasatuan' WHERE id_item='$iditem'");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=item');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
		$iditem = $_REQUEST['id_item'];
		$sql = mysql_query("SELECT * FROM item WHERE id_item='$iditem'");
		list($iditem,$idkertas,$idwarna,$nama,$hargasatuan) = mysql_fetch_array($sql);
?>
<h2>Edit Data Item</h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=item&aksi=edit" class="form-horizontal" enctype="multipart/form-data" role="form">
	<div class="form-group">
		<label for="iditem" class="col-sm-2 control-label">ID Item</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="iditem" name="iditem" value="<?php echo $iditem; ?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="nama" class="col-sm-2 control-label">Item</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="kertas" class="col-sm-2 control-label">Jenis Kertas</label>
		<div class="col-sm-4">
			<select name="kertas" class="form-control">
			<?php
			$qkertas = mysql_query("SELECT * FROM jenis_kertas ORDER BY id_jeniskertas");
			while(list($id,$kertas)=mysql_fetch_array($qkertas)){
				echo '<option value="'.$id.'"';
				echo ($id==$idkertas) ? 'selected' : '';
				echo '>'.$kertas.'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="warna" class="col-sm-2 control-label">Warna Print</label>
		<div class="col-sm-4">
			<select name="warna" class="form-control">
			<?php
			$qwarna= mysql_query("SELECT * FROM warna_print ORDER BY id_warnaprint");
			while(list($id,$warna)=mysql_fetch_array($qwarna)){
				echo '<option value="'.$id.'"';
				echo ($id==$idwarna) ? 'selected' : '';
				echo '>'.$warna.'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="hargasatuan" class="col-sm-2 control-label">Harga Satuan</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="hargasatuan" name="hargasatuan" value="<?php echo $hargasatuan; ?>">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=barang" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php

	}
}
?>