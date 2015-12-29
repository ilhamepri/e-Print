<?php
date_default_timezone_set('Asia/Jakarta');
$waktu=date('Y-m-d');
$waktu2=date('Ymd');
$sql = mysql_query("SELECT MAX(id_pemesanan) FROM pemesanan");
list($maks) = mysql_fetch_row($sql);
		$idang = substr($maks, 2, 5);
		$idang = $idang + 1;
		if($idang <= 9) $idhasil = "PR000".$idang;
		if($idang <= 99 && $idang >9) $idhasil = "PR00".$idang;
		if($idang <= 999 && $idang >99) $idhasil = "PR0".$idang;
		if($idang <= 9999 && $idang >999) $idhasil = "PR".$idang;
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
		$idaktif=$_SESSION['iduser'];
		$idpemesanan = $_REQUEST['idpemesanan'];
		$halaman = $_REQUEST['halaman'];
		$kertas = $_REQUEST['idkertas'];
		$warna = $_REQUEST['idwarna'];
		$komentar = $_REQUEST['komentar'];

		if (($_FILES['file']['type']=='application/msword')||($_FILES['file']['type']=='text/pdf')){
			$temp = explode(".", $_FILES["file"]["name"]);
			$newfilename = $hasilfile . '.' . end($temp);
			move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename);		
		}
		
		$sql3=mysql_query("SELECT * FROM pemesanan WHERE iduser='$idaktif' and status is NULL");
		list($cekid,$user,$tanggal,$status) = mysql_fetch_array($sql3);
		
		$sql2=mysql_query("SELECT id_pemesanan FROM pemesanan WHERE iduser='$idaktif'");
		list($cekidpemesanan) = mysql_fetch_array($sql2);
		$sql= mysql_query("select id_item,harga from item where id_jeniskertas='$kertas' and id_warnaprint='$warna'");
		list($item,$harga)=mysql_fetch_array($sql);
		$subtotal=($halaman*$harga);
		
		if($cekidpemesanan!=$idpemesanan){
		$sql = mysql_query("INSERT INTO pemesanan VALUES('$idpemesanan','$idaktif','$waktu',NULL)");
		$sql = mysql_query("INSERT INTO detail_pemesanan VALUES('$idpemesanan','$item','$halaman','$newfilename','$komentar',NULL)");
		}else if($cekidpemesanan==$idpemesanan){
		$sql = mysql_query("INSERT INTO detail_pemesanan VALUES('$idpemesanan','$item','$halaman','$newfilename','$komentar',NULL)");
		}
		
		if($sql > 0){
			header('Location: ./admin.php?hlm=print');
			die();
		} else {
			echo 'ERROR! Periksa penulisan querynya.';
		}
	} else {
		$id=$_SESSION['iduser'];
		$id_pemesanan = $_REQUEST['id_pemesanan'];
		$sql2 = mysql_query("SELECT p.id_pemesanan FROM pemesanan p where p.iduser='$id' and p.id_pemesanan='$id_pemesanan' and p.status is null ORDER BY id_pemesanan");
		if( mysql_num_rows($sql2) > 0 ){
			list($idhasil)=mysql_fetch_array($sql2);
		}
?>
<h2>Tambah Daftar Print</h2>
<h4>ID Daftar Print <i><?php echo $id_pemesanan; ?></i></h4>
<hr>
<form method="post" action="admin.php?hlm=master&sub=print&aksi=baru" class="form-horizontal" enctype="multipart/form-data" role="form">
	<div class="form-group">
		<label for="idpemesanan" class="col-sm-2 control-label">ID Daftar Print</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="idpemesanan" name="idpemesanan" value="<?php echo $idhasil; ?>" readonly required>
		</div>
	</div>
	<div class="form-group">
		<label for="prodi" class="col-sm-2 control-label">Kertas</label>
		<div class="col-sm-4">
			<select name="idkertas" class="form-control">
			<?php
			$qkertas = mysql_query("SELECT * FROM jenis_kertas ORDER BY id_jeniskertas");
			while(list($idkertas,$nama)=mysql_fetch_array($qkertas)){
				echo '<option value="'.$idkertas.'">'.$nama.'</option>';
			}
			?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="warna" class="col-sm-2 control-label">Warna</label>
		<div class="col-sm-4">
			<select name="idwarna" class="form-control">
			<?php
			$qwarna = mysql_query("SELECT * FROM warna_print ORDER BY id_warnaprint");
			while(list($idwarna,$warna)=mysql_fetch_array($qwarna)){
				echo '<option value="'.$idwarna.'">'.$warna.'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="halaman" class="col-sm-2 control-label">Banyak Halaman</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="halaman" name="halaman" placeholder="0" required >
		</div>
	</div>
	<div class="form-group">
		<label for="komentar" class="col-sm-2 control-label">Komentar</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="komentar" name="komentar" placeholder="ex: di print semua / memilih halaman apa saja" required>
		</div>
	</div>
	<div class="form-group">
		<label for="file" class="col-sm-2 control-label">File</label>
		<div class="col-sm-4">
			<input accept=".doc,.docx,.pdf,.ppt,.pptx" id="uploadfile" type="file" name="file" onchange="PreviewImage();" />
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="submit" class="btn btn-default">Simpan</button>
			<a href="./admin.php?hlm=master&sub=print" class="btn btn-link">Batal</a>
		</div>
	</div>
</form>
<?php
	}
}
?>