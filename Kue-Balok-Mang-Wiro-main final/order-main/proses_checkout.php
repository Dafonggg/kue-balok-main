<?php
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart = json_decode($_POST['cart'], true);
  $nama_pemesan = 'Customer';
  $jenis_pesanan = 'take_away';
  $id_pesanan = uniqid();
  $tgl_pesanan = date('Y-m-d');
  $total_harga = 0;

  // Hitung total harga
  foreach ($cart as $item) {
    $total_harga += $item['price'] * $item['quantity'];
  }

  // Upload bukti transfer
  $targetDir = "bukti_transfer/";
  if (!is_dir($targetDir)) mkdir($targetDir);
  $fileName = $id_pesanan . '_' . basename($_FILES['bukti']['name']);
  $targetFile = $targetDir . $fileName;
  move_uploaded_file($_FILES['bukti']['tmp_name'], $targetFile);

  // Simpan ke tabel pesanan
  $stmt = $conn->prepare("INSERT INTO pesanan (id_pesanan, nama_pemesan, tgl_pesanan, total_hargal, status_pesanan, jenis_pesanan) VALUES (?, ?, ?, ?, 'menunggu', ?)");
  $stmt->bind_param("sssds", $id_pesanan, $nama_pemesan, $tgl_pesanan, $total_harga, $jenis_pesanan);
  $stmt->execute();

  // Simpan detail pesanan
  $stmtDetail = $conn->prepare("INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_produk, sub_total) VALUES (?, ?, ?, ?, ?)");
  foreach ($cart as $id_produk => $item) {
    $jumlah = $item['quantity'];
    $harga = $item['price'];
    $sub_total = $jumlah * $harga;
    $stmtDetail->bind_param("ssidd", $id_pesanan, $id_produk, $jumlah, $harga, $sub_total);
    $stmtDetail->execute();
  }

  // Simpan transaksi
  $metode_pembayaran = 1; // misal: 1 = transfer
  $stmtTransaksi = $conn->prepare("INSERT INTO transaksi (id_pesanan, status_transaksi, bukti_pembayaran, metode_pembayaran) VALUES (?, 'sudah dibayar', ?, ?)");
  $stmtTransaksi->bind_param("ssi", $id_pesanan, $fileName, $metode_pembayaran);
  $stmtTransaksi->execute();

  echo json_encode(['status' => 'success', 'id_pesanan' => $id_pesanan]);
  exit;
} else {
  http_response_code(405);
  echo json_encode(['error' => 'Metode tidak diizinkan']);
  exit;
}
echo json_encode([
  'id_pesanan' => $id_pesanan
]);
