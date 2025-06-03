<?php
include '../koneksi/koneksi.php';

$queryStok = mysqli_query($koneksi, "SELECT SUM(stok) as total_stok FROM stok_harian WHERE tanggal = CURDATE()");
$rowStok = mysqli_fetch_assoc($queryStok);
$totalStok = $rowStok['total_stok'];

$queryProduk = mysqli_query($koneksi, "SELECT * FROM produk");
$produk = [];
while ($row = mysqli_fetch_assoc($queryProduk)) {
    $produk[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Produk</title>
  <link rel="stylesheet" href="mobile-style.css">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <style>
    .toast {
      position: fixed;
      bottom: 80px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #2e4358;
      color: white;
      padding: 0.8rem 1.2rem;
      border-radius: 5px;
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 9999;
    }
    .toast.show {
      opacity: 1;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="navbar-logo">
      <a href = "../index.php">
        <img src="../img/logokecilorder.png" alt="">
    </div>
    <div class="navbar-nav">
      <a href="../index.php">Home</a>
      <a href="#order">Order</a>
    </div>
    <div class="navbar-extra">
      <a href="#" id="cart-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="main-grid-item-icon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          <circle cx="9" cy="21" r="1" />
          <circle cx="20" cy="21" r="1" />
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
        </svg>
        <span class="cart-badge" id="cart-count">0</span>
      </a>
    </div>
  </nav>

  <section class="order" id="order">
    <h2>Menu Order</h2>
    <p>Total stok tersedia hari ini: <strong><?= $totalStok ?></strong></p>
    <div class="product-grid">
      <?php foreach ($produk as $item): ?>
        <div class="product-card">
          <img src="../menu-main/assets/img/<?= $item['poto_produk'] ?>" alt="<?= $item['nama_produk'] ?>">
          <h3><?= $item['nama_produk'] ?></h3>
          <p>Rp<?= number_format($item['harga_produk'], 0, ',', '.') ?></p>
          <button onclick="addToCart('<?= $item['id_produk'] ?>', '<?= $item['nama_produk'] ?>', <?= $item['harga_produk'] ?>, '../menu-main/assets/img/<?= $item['poto_produk'] ?>')">Tambah</button>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <div class="shopping-cart" id="shopping-cart">
    <h3>Keranjang</h3>
    <input type="text" id="nama" placeholder="Nama Pemesan" required>
    <select id="metode-pembayaran">
      <option value="2">QRIS</option>
      <option value="1">Transfer</option>
    </select>
    <div id="info-pembayaran"></div>
    <div id="cart-items"></div>
    <p>Total: Rp<span id="cart-total">0</span></p>
    <input type="file" id="bukti-transfer" accept="image/*" style="display:none;">
    <button onclick="checkout()">Bayar</button>
  </div>

  <div class="toast" id="toast">Produk ditambahkan ke keranjang</div>

  <script>
    let cart = {};

    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.innerText = message;
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 2000);
    }

    function addToCart(id, name, price, img) {
      if (!cart[id]) {
        cart[id] = { name, price, quantity: 1, img };
      } else {
        cart[id].quantity++;
      }
      renderCart();
      showToast(`"${name}" ditambahkan ke keranjang.`);
    }

    function changeQty(id, delta) {
      if (cart[id]) {
        cart[id].quantity += delta;
        if (cart[id].quantity <= 0) delete cart[id];
        renderCart();
      }
    }

    function renderCart() {
      const cartItems = document.getElementById('cart-items');
      cartItems.innerHTML = '';
      let total = 0;
      let count = 0;

      for (let id in cart) {
        const item = cart[id];
        const subtotal = item.price * item.quantity;
        total += subtotal;
        count += item.quantity;

        cartItems.innerHTML += `
          <div class="cart-item">
            <img src="${item.img}" width="40">
            <p>${item.name}</p>
            <p>Rp${item.price.toLocaleString()}</p>
            <div class="qty-control">
              <button onclick="changeQty('${id}', -1)">-</button>
              <span>${item.quantity}</span>
              <button onclick="changeQty('${id}', 1)">+</button>
            </div>
            <p>Total: Rp${subtotal.toLocaleString()}</p>
          </div>`;
      }

      document.getElementById('cart-total').innerText = total.toLocaleString();
      document.getElementById('cart-count').innerText = count;
    }

    document.getElementById('cart-button').addEventListener('click', () => {
      document.getElementById('shopping-cart').classList.toggle('active');
    });

    document.getElementById('metode-pembayaran').addEventListener('change', function() {
      const info = document.getElementById('info-pembayaran');
      const fileInput = document.getElementById('bukti-transfer');
      if (this.value === '2') {
        info.innerHTML = '<img src="transaksi/img/qris.jpg" width="200"><p>Scan QRIS untuk membayar</p>';
        fileInput.style.display = 'block';
      } else {
        info.innerHTML = '<p>Transfer ke: <strong>1234567890 (BCA a.n. Kue Balok)</strong></p>';
        fileInput.style.display = 'block';
      }
    });

    function checkout() {
      const nama = document.getElementById('nama').value;
      const metode = document.getElementById('metode-pembayaran').value;
      const bukti = document.getElementById('bukti-transfer').files[0];

      if (!nama || !metode || (metode === '1' && !bukti)) {
        alert("Lengkapi data pemesan dan bukti transfer jika pilih transfer.");
        return;
      }

      const formData = new FormData();
      formData.append('nama', nama);
      formData.append('metode_pembayaran', metode);
      formData.append('cart', JSON.stringify(cart));
      if (metode === '1') formData.append('bukti', bukti);

      axios.post('proses_checkout.php', formData)
        .then(res => {
          const idPesanan = res.data.id_pesanan;
          alert("Pesanan berhasil: " + idPesanan);
          cart = {}; renderCart();
          window.location.href = `struk.php?id=${idPesanan}`;
        })
        .catch(err => alert("Gagal memproses pesanan."));
    }
  </script>
</body>
</html>
