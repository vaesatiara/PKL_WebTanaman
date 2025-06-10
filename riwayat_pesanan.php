<?php
session_start();
include "koneksi.php";

// Fungsi untuk mendapatkan data pesanan
function getOrderData($source = 'cart', $product_id = null, $quantity = 1) {
    global $koneksi;
    $orderItems = [];
    $totalHarga = 0;
    
    if ($source === 'cart') {
        // Ambil dari keranjang
        if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
            foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                if (empty($id_produk)) continue;
                
                $query = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                $produk = $query->fetch_assoc();
                
                if ($produk) {
                    $subtotal = $produk['harga'] * $jumlah;
                    $orderItems[] = [
                        'id_produk' => $id_produk,
                        'nama_tanaman' => $produk['nama_tanaman'],
                        'harga' => $produk['harga'],
                        'foto' => $produk['foto'],
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal
                    ];
                    $totalHarga += $subtotal;
                }
            }
        }
    } else if ($source === 'buy_now' && $product_id) {
        // Ambil dari beli sekarang
        $query = $koneksi->query("SELECT * FROM produk WHERE id_produk='$product_id'");
        $produk = $query->fetch_assoc();
        
        if ($produk) {
            $subtotal = $produk['harga'] * $quantity;
            $orderItems[] = [
                'id_produk' => $product_id,
                'nama_tanaman' => $produk['nama_tanaman'],
                'harga' => $produk['harga'],
                'foto' => $produk['foto'],
                'jumlah' => $quantity,
                'subtotal' => $subtotal
            ];
            $totalHarga = $subtotal;
        }
    }
    
    return [
        'items' => $orderItems,
        'subtotal' => $totalHarga
    ];
}

// Fungsi untuk mendapatkan alamat pengiriman yang dipilih
function getSelectedAddress() {
    global $koneksi;
    
    // Jika ada alamat yang dipilih dari form sebelumnya
    if (isset($_POST['selected_address_id'])) {
        $address_id = $_POST['selected_address_id'];
        $query = $koneksi->query("SELECT * FROM pengiriman WHERE id_pengiriman='$address_id'");
        return $query->fetch_assoc();
    }
    
    // Jika tidak ada, ambil alamat default atau yang pertama
    $query = $koneksi->query("SELECT * FROM pengiriman ORDER BY id_pengiriman DESC LIMIT 1");
    return $query->fetch_assoc();
}

// Fungsi untuk menghitung biaya pengiriman berdasarkan metode
function getShippingCost($method = 'jne') {
    $shippingCosts = [
        'jne' => 25000,
        'jnt' => 30000,
        'ninja' => 28000,
        'anteraja' => 26000
    ];
    
    return isset($shippingCosts[$method]) ? $shippingCosts[$method] : 25000;
}

// Fungsi untuk mendapatkan nama metode pengiriman
function getShippingName($method = 'jne') {
    $shippingNames = [
        'jne' => 'JNE Regular',
        'jnt' => 'J&T Express',
        'ninja' => 'Ninja Xpress',
        'anteraja' => 'AnterAja Regular'
    ];
    
    return isset($shippingNames[$method]) ? $shippingNames[$method] : 'JNE Regular';
}

// Tentukan sumber data berdasarkan parameter
$source = isset($_GET['source']) ? $_GET['source'] : (isset($_POST['order_source']) ? $_POST['order_source'] : 'cart');
$product_id = isset($_GET['id_produk']) ? $_GET['id_produk'] : (isset($_POST['product_id']) ? $_POST['product_id'] : null);
$quantity = isset($_GET['qty']) ? (int)$_GET['qty'] : (isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1);

// Ambil data pesanan
$orderData = getOrderData($source, $product_id, $quantity);

// Ambil alamat pengiriman yang dipilih
$shippingAddress = getSelectedAddress();

// Tentukan metode pengiriman (default atau dari form)
$selectedShipping = isset($_POST['shipping_method']) ? $_POST['shipping_method'] : 'jne';
$shippingCost = getShippingCost($selectedShipping);
$shippingName = getShippingName($selectedShipping);

// Hitung total
$total = $orderData['subtotal'] + $shippingCost;

// Proses jika form metode pengiriman disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_shipping'])) {
    $selectedShipping = $_POST['shipping_method'];
    $shippingCost = getShippingCost($selectedShipping);
    $shippingName = getShippingName($selectedShipping);
    $total = $orderData['subtotal'] + $shippingCost;


}
$username = $_SESSION['username'];
$sql = "SELECT * FROM pelanggan WHERE username= '$username'";
$query = mysqli_query($koneksi, $sql);
$pelanggan = mysqli_fetch_assoc($query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Toko Tanaman</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.html">
                    <img src="images/logo.png" alt="Toko Tanaman">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">BERANDA</a></li>
                    <li><a href="produk.html">PRODUK</a></li>
                    <li><a href="kontak.html">KONTAK</a></li>
                    <li><a href="tentang.html">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.html"><i class="fas fa-shopping-cart"></i></a>
                <a href="profil.html" class="active"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <main class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-sidebar">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <img src="images/user.jpg" alt="Budi Santoso">
                        </div>
                        <div class="profile-info">
                            <h2><?=$pelanggan['username']?></h2>
                            <p><?=$pelanggan['email']?></p>
                        </div>
                    </div>
                    <div class="profile-nav">
                        <ul>
                            <li>
                                <a href="profil.html">
                                    <i class="fas fa-user"></i> Profil Saya
                                </a>
                            </li>
                            <li class="active">
                                <a href="riwayat_pesanan.html">
                                    <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                                </a>
                            </li>
                            <li>
                                <a href="alamat_tersimpan.html">
                                    <i class="fas fa-map-marker-alt"></i> Alamat Tersimpan
                                </a>
                            </li>
                            <li>
                                <a href="ubah_password.html">
                                    <i class="fas fa-lock"></i> Ubah Password
                                </a>
                            </li>
                            <li>
                                <a href="login.html" class="logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="profile-content">
                    <div class="content-header">
                        <h1>Riwayat Pesanan</h1>
                    </div>
                    
                    <div class="order-tabs">
                        <button class="tab-btn active">Semua</button>
                        <button class="tab-btn">Belum Dibayar</button>
                        <button class="tab-btn">Diproses</button>
                        <button class="tab-btn">Dikirim</button>
                        <button class="tab-btn">Selesai</button>
                        <button class="tab-btn">Dibatalkan</button>
                    </div>
                    
                    <div class="order-list">
                        <div class="order-card">
                            <div class="order-header">
                                <div class="order-info">
                                    <p class="order-date">22 Mei 2023</p>
                                    <p class="order-number">INV/20230522/MPL/1234567</p>
                                </div>
                                <div class="order-status">
                                    <span class="status-badge status-completed">Selesai</span>
                                </div>
                            </div>
                            <div class="order-items">
                                <div class="order-item">
                                         
                        <div class="summary-items">
                            <?php foreach ($orderData['items'] as $item): ?>
                            <div class="summary-item">
                                <img src="uploads/<?= $item['foto'] ?>" alt="<?= $item['nama_tanaman'] ?>" class="item-image">
                                <div class="item-info">
                                    <h3><?= htmlspecialchars($item['nama_tanaman']) ?></h3>
                                    <p><?= $item['jumlah'] ?> x Rp<?= number_format($item['harga'], 0, ',', '.') ?></p>
                                </div>
                                <div class="item-price">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></div>
                            </div>
                            <?php endforeach; ?>
                        
                        </div>
                                    
                                    </div>
                                </div>
                                
                            </div>
                            <div class="order-footer">
                                <div class="order-total">
                                    Total Pesanan: <span >Rp<?= number_format($total, 0, ',', '.') ?></span>
                                </div>
                                <div class="order-actions">
                                    <a href="detail_pesanan.php?id_pesanan=<?=$pesanan['id_pesanan'] ?>" class="btn btn-outline">Detail Pesanan</a>
                                    <a href="#" class="btn btn-primary">Beli Lagi</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-card">
                            <div class="order-header">
                                <div class="order-info">
                                    <p class="order-date">15 Mei 2023</p>
                                    <p class="order-number">INV/20230515/MPL/7654321</p>
                                </div>
                                <div class="order-status">
                                    <span class="status-badge status-shipped">Dikirim</span>
                                </div>
                            </div>
                            <div class="order-items">
                                <div class="order-item">
                                    <img src="images/daun1.jpg" alt="Fiddle Fig">
                                    <div class="item-details">
                                        <h3>Fiddle Fig</h3>
                                        <p>1 x Rp250.000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-footer">
                                <div class="order-total">
                                    Total Pesanan: <span class="total-amount">Rp250.000</span>
                                </div>
                                <div class="order-actions">
                                    <a href="#" class="btn btn-outline">Detail Pesanan</a>
                                    <a href="#" class="btn btn-outline">Lacak Pengiriman</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn next">Selanjutnya <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Toko Tanaman">
                    <p>Toko tanaman hias terpercaya dengan berbagai koleksi tanaman berkualitas untuk mempercantik rumah dan ruangan Anda.</p>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Tautan Cepat</h3>
                    <ul>
                        <li><a href="index.html">BERANDA</a></li>
                        <li><a href="produk.html">PRODUK</a></li>
                        <li><a href="kontak.html">KONTAK</a></li>
                        <li><a href="tentang.html">TENTANG KAMI</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Kategori</h3>
                    <ul>
                        <li><a href="tanaman_hias_daun.html">Tanaman Hias Daun</a></li>
                        <li><a href="tanaman_hias_bunga.html">Tanaman Hias Bunga</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3 class="footer-title">Kontak Kami</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Tanaman Indah No. 123, Purwokerto</p>
                    <p><i class="fas fa-phone"></i> +62 812 3456 7890</p>
                    <p><i class="fas fa-envelope"></i> info@tokotanaman.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Toko Tanaman. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>