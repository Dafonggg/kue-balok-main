<?php
include '../koneksi/koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$metode = isset($_GET['metode']) ? $_GET['metode'] : '';

$pesanan = null;
if ($id) {
  // Coba dari pesanan pelanggan
  $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id'"));

  // Jika tidak ketemu, coba dari pesanan kasir
  if (!$pesanan) {
    $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan_kasir WHERE id_pesanan = '$id'"));
  }

  $detail = mysqli_query($koneksi, "SELECT * FROM detail_pesanan WHERE id_pesanan = '$id'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pembayaran</title>
  <style>
    body { font-family: sans-serif; padding: 2rem; background-color: #f5f5f5; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: #fff; }
    th, td { padding: 0.5rem; border: 1px solid #ccc; text-align: left; }
    .info { margin: 1rem 0; }
    .total { font-weight: bold; font-size: 1.1rem; text-align: right; }
    .print-btn { margin-top: 1rem; text-align: center; }
    .print-btn button {
      padding: 0.5rem 1rem;
      background: #2e4358;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h2>Struk Pembayaran</h2>

  <?php if (!$pesanan): ?>
    <p style="color: red;">❌ Data pesanan tidak ditemukan.</p>
  <?php else: ?>

    <div class="info">
      <p><strong>ID Pesanan:</strong> <?= $pesanan['id_pesanan'] ?></p>
      <p><strong>Nama:</strong> <?= $pesanan['nama_pemesan'] ?></p>
      <p><strong>Tanggal:</strong> <?= $pesanan['tgl_pesanan'] ?></p>
      <p><strong>Metode:</strong> <?= $metode == 1 ? 'Transfer' : 'QRIS' ?></p>
    </div>

    <table>
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        while ($row = mysqli_fetch_assoc($detail)):
          $sub = $row['jumlah'] * $row['harga_produk'];
          $total += $sub;
        ?>
          <tr>
            <td><?= $row['id_produk'] ?></td>
            <td>Rp<?= number_format($row['harga_produk'], 0, ',', '.') ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td>Rp<?= number_format($sub, 0, ',', '.') ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <p class="total">Total Bayar: Rp<?= number_format($total, 0, ',', '.') ?></p>

    <div class="print-btn">
      <button onclick="window.print()">🖨️ Cetak Struk</button>
    </div>

  <?php endif; ?>

</body>
</html>
