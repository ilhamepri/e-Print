<?php
$waktu2=date('Ymd');
$sql2 = mysql_query("SELECT MAX(file) FROM detail_pemesanan");
list($maxfile) = mysql_fetch_row($sql2);
		$idfile = substr($maxfile, 12, 14);
		$idfile = $idfile + 1;
		if($idfile <= 9) $hasilfile = "doc/".$waktu2.'00'.$idfile;
		if($idfile <= 99 && $idfile >9) $hasilfile = "doc/".$waktu2.'0'.$idfile;
		if($idfile <= 999 && $idfile >99) $hasilfile = "doc/".$waktu2.''.$idfile;
		
if( empty( $_SESSION['iduser'] ) ){
	//session_destroy();
	$_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
	header('Location: ./');
	die();
} else {
	if( isset( $_REQUEST['submit'] )){
		$id_pemesanan = $_REQUEST['idpemesanan'];
		$id_item = $_REQUEST['iditem'];
		$kertas = $_REQUEST['kertas'];
		$warna = $_REQUEST['warna'];
		$halaman = $_REQUEST['halaman'];
		$komentar = $_REQUEST['komentar'];
		if (($_FILES['file']['type']=='application/msword')||($_FILES['file']['type']=='text/pdf')){
				$temp = explode(".", $_FILES["file"]["name"]);
				$newfilename = $hasilfile . '.' . end($temp);
				move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename);				
		}
		
		$sql2= mysql_query("select id_item,harga from item where id_jeniskertas='$kertas' and id_warnaprint='$warna'");
		list($item,$harga)=mysql_fetch_array($sql2);
		$sql = mysql_query("UPDATE detail_pemesanan SET file='$newfilename',id_item='$item',halaman='$halaman',komentar='$komentar' WHERE id_pemesanan='$id_pemesanan' and id_item='$id_item'");
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=print');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
		$id_item = $_REQUEST['id_item'];
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$sql = mysql_query("SELECT * FROM detail_pemesanan WHERE id_pemesanan='$id_pemesanan' and id_item='$id_item'");
		list($idpesan,$tipe,$halaman,$file,$komentar,$status) = mysql_fetch_array($sql);
		$qitem= mysql_query("SELECT * FROM item where id_item='$tipe'");
		list($iditem,$idkertas,$idwarna) = mysql_fetch_array($qitem);
?>
<h2>Edit Item Print <i><?php echo $id_pemesanan; ?></i></h2>
<hr>
<form method="post" action="admin.php?hlm=master&sub=print&aksi=edit" class="form-horizontal" enctype="multipart/form-data" role="form">
	<div class="form-group">
		<label for="idpemesanan" class="col-sm-2 control-label">ID Daftar Print</label>
		<div class="col-sm-2">
			<input type="text" class="form-control" id="idpemesanan" name="idpemesanan" value="<?php echo $id_pemesanan; ?>" readonly>
		</div>
		<div class="col-sm-2">
			<input type="text" class="form-control" id="iditem" name="iditem" value="<?php echo $id_item; ?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="merk" class="col-sm-2 control-label">Kertas</label>
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
		<label for="kelompok" class="col-sm-2 control-label">Warna</label>
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
		<label for="halaman" class="col-sm-2 control-label">Banyak Halaman</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="halaman" name="halaman" value="<?php echo $halaman; ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="komentar" class="col-sm-2 control-label">Komentar</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="komentar" name="komentar" value="<?php echo $komentar; ?>" required >
		</div>
	</div>
	<div class="form-group">
		<label for="file" class="col-sm-2 control-label">File</label>
		<div class="col-sm-4">
			<input id="file" type="file" name="file" onchange="PreviewImage();" />
			<p><strong>Harus dipilih lagi file ingin di print</strong></p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=item" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php

	}
}
?>