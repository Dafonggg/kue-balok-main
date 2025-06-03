<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            width: 150px;
            text-align: center;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h2>Menu</h2>
    <div class="product-list">
    <?php
    include 'koneksi/koneksi.php'; 
    $produk = mysqli_query($koneksi, "SELECT * FROM produk");
    while ($row = mysqli_fetch_assoc($produk)) : ?>
        <div class="product-card">
            <img src="assets/img/<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>">
            <h4><?= $row['nama'] ?></h4>
            <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
        </div>
    <?php endwhile; ?>
    </div>

            
</body>
</html>