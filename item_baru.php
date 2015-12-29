<?php
$qid = mysql_query("SELECT MAX(id_item) FROM item");
list($maks) = mysql_fetch_row($qid);
		$idang = substr($maks, 1, 4);
		$idang = $idang + 1;
		if($idang <= 9) $idhasil = "i000".$idang;
		if($idang <= 99 && $idang >9) $idhasil = "i00".$idang;
		if($idang <= 999 && $idang >99) $idhasil = "i0".$idang;
		if($idang <= 9999 && $idang >999) $idhasil = "i".$idang;

		
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$iditem = $_REQUEST['item'];
		$nama = $_REQUEST['nama'];
		$idkertas = $_REQUEST['kertas'];
		$idwarna = $_REQUEST['warna'];
		$hargasatuan = $_REQUEST['hargasatuan'];		
		
		$sql = mysql_query("INSERT INTO item VALUES('$iditem','$idkertas','$idwarna','$nama','$hargasatuan')");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=master&sub=item');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
?>
<h2>Tambah Item</h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=item&aksi=baru" class="form-horizontal" enctype="multipart/form-data" role="form">
	<div class="form-group">
		<label for="item" class="col-sm-2 control-label">ID Item</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="item" name="item" value="<?php echo $idhasil ?>" placeholder="ID Barang" readonly required autofocus>
		</div>
	</div>
	<div class="form-group">
		<label for="nama" class="col-sm-2 control-label">Item</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Item" required>
		</div>
	</div>
	<div class="form-group">
		<label for="kertas" class="col-sm-2 control-label">Jenis Kertas</label>
		<div class="col-sm-4">
			<select name="kertas" class="form-control">
			<?php
			$qkertas = mysql_query("SELECT * FROM jenis_kertas ORDER BY id_jeniskertas");
			while(list($idkertas,$kertas)=mysql_fetch_array($qkertas)){
				echo '<option value="'.$idkertas.'">'.$kertas.'</option>';
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
			while(list($idwarna,$warna)=mysql_fetch_array($qwarna)){
				echo '<option value="'.$idwarna.'">'.$warna.'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="hargasatuan" class="col-sm-2 control-label">Harga Satuan</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="hargasatuan" name="hargasatuan" placeholder="0" required autofocus>
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