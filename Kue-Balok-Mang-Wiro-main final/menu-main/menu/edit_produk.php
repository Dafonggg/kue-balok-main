<?php
include '../../koneksi.php';

// Validasi apakah id_produk ada
if (!isset($_GET['id_produk'])) {
    echo "ID produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id_produk'];
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk ='$id_produk'");

// Validasi apakah data produk ditemukan
if (!$query || mysqli_num_rows($query) == 0) {
    echo "Data produk tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($query);

// Proses simpan perubahan
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    if ($_FILES['gambar']['name'] != '') {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../../assets/img/$gambar");

        mysqli_query($koneksi, "UPDATE produk 
            SET nama='$nama', harga='$harga', kategori='$kategori', gambar='$gambar' 
            WHERE id_produk='$id_produk'");
    } else {
        mysqli_query($koneksi, "UPDATE produk 
            SET nama='$nama', harga='$harga', kategori='$kategori' 
            WHERE id_produk='$id_produk'");
    }

    header("Location: list_produk.php");
    exit;
}
?>

<!-- Form Edit Produk -->
<form method="POST" enctype="multipart/form-data">
    <label>Nama Menu:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br>

    <label>Harga:</label><br>
    <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required><br>

    <label>Kategori:</label><br>
    <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>" required><br>

    <label>Upload Gambar Baru:</label><br>
    <input type="file" name="gambar"><br><br>

    <button type="submit" name="submit">Simpan</button>
</form>
