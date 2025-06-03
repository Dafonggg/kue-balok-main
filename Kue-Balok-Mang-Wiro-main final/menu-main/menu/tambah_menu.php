<?php 
include('../../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../../assets/img/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO produk (id_produk, nama, harga, kategori, gambar) VALUES ('$id_produk', '$nama', '$harga', '$kategori', '$gambar')";
        mysqli_query($koneksi, $query);
        header("Location: list_menu.php");
    } else {
        echo "Gagal mengupload gambar.";
    }
}

?>

<form method="POST" enctype="multipart/form-data">
    <label>Id_menu:</label><br>
    <input type="text" name="id_produk" required><br>
    <label>Nama Menu:</label><br>
    <input type="text" name="nama" required><br>
    <label>Harga:</label><br>
    <input type="number" name="harga" required><br>
    <label>Kategori:</label><br>
    <input type="text" name="kategori" required><br>
    <label>Upload Gambar:</label><br>
    <input type="file" name="gambar" required><br><br>
    <button type="submit" name="submit">Tambah Menu</button>
</form>