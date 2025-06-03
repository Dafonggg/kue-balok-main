<?php
include('../../koneksi.php');
$result = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<a href="tambah_menu.php">+ Tambah menu</a>
<table border="1" cellpadding="10">
    <tr><th>id</th><th>Nama</th><th>Harga</th><th>Kategori</th><th>Gambar</th><th>Opsi</th></tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id_produk']?></td>
        <td><?= $row['nama']?></td>
        <td>Rp <?= number_format($row['harga'])?></td>
        <td><?= $row['kategori']?></td>
        <td><img src="../../assets/img <?= $row['gambar'] ?>" width="100"></td>
        <td>
            <a href="edit_produk.php?id_produk=<?= $row['id_produk'] ?>">Edit</a>
            <a href="hapus_produk.php?id_produk=<?= $row['id_produk']?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>