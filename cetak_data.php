<?php
session_start();

include "koneksi.php";
         $tgl1 = $_REQUEST['tanggal1'];
         $tgl2 = $_REQUEST['tanggal2'];
#ambil data di tabel dan masukkan ke array
	$query = "SELECT id_pembayaran,id_pemesanan,tanggal,total FROM pembayaran WHERE tanggal BETWEEN '$tgl1' AND '$tgl2'";
	$sql = mysql_query ($query);
	$data = array();
	while ($row = mysql_fetch_assoc($sql)) {
		array_push($data, $row);
	}
	 
	#setting judul laporan dan header tabel
	$judul = 'Data Pembayaran '.$tgl1.' sampai '.$tgl2;
	$header = array(
			array("label"=>"ID Pembayaran", "length"=>50, "align"=>"L"),
			array("label"=>"ID Pemesanan", "length"=>50, "align"=>"L"),
			array("label"=>"Tanggal", "length"=>50, "align"=>"L"),
			array("label"=>"Jumlah", "length"=>40, "align"=>"L"),
		);
		
#sertakan library FPDF dan bentuk objek
	require_once ("assets/fpdf/fpdf.php");
	$pdf = new FPDF();
	$pdf->AddPage();
	 
	#tampilkan judul laporan
	$pdf->SetFont('Arial','B','16');
	$pdf->Cell(0,20, $judul, '0', 1, 'C');
	 
	#buat header tabel
	$pdf->SetFont('Arial','','10');
	$pdf->SetFillColor(255,0,0);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(128,0,0);

	foreach ($header as $kolom) {
	$pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
	}
	$pdf->Ln();
	 
	#tampilkan data tabelnya
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('');
	$fill=false;
	foreach ($data as $baris) {
		$i = 0;
		foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $kolom['align'], $fill);
			$i++;
		}
		$fill = !$fill;
		$pdf->Ln();
}
#output file PDF
$pdf->Output();
?>
