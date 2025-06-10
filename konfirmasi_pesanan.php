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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Toko Tanaman</title>
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
                    <li><a href="index.php">BERANDA</a></li>
                    <li><a href="produk.php">PRODUK</a></li>
                    <li><a href="kontak.php">KONTAK</a></li>
                    <li><a href="tentang.html">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.html"><i class="fas fa-shopping-cart"></i></a>
                <a href="profil.html"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <main class="receipt-section">
        <div class="container">
            <div class="receipt-container">
                <div class="receipt-header">
                    <div class="store-logo"> <br>
                        <img src="images/logo.png" alt="TOKO TANAMAN"> 
                        <br>
                    </div>
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <br> 
                    <h1>Pesanan Berhasil!</h1>
                    <br>
                    <p>Terima kasih telah berbelanja di TOKO TANAMAN</p>
                </div>
                
              <?php
 // sambungkan ke database

// Ambil nomor pesanan terakhir (misalnya dari checkout)
$nomor_pesanan = 'TN12345';

// Query ke database
$sql=  "SELECT * FROM pesanan WHERE nomor_pesanan = '$nomor_pesanan'";
$query=mysqli_query($koneksi,$sql);
$data = mysqli_fetch_assoc($query);

// Format tanggal
$tanggal_pesanan = date("d M Y, H:i", strtotime($data['tgl_pesanan']));
$status_pesanan = $data['status_pesanan'];

// Ambil metode dari SESSION
$metode_pembayaran = isset($_SESSION['metode_pembayaran']) ? $_SESSION['metode_pembayaran'] : 'Tidak diketahui';
?>

<div class="receipt-details">
    <div class="receipt-row">
        <div class="receipt-label">Nomor Pesanan:</div>
        <div class="receipt-value"><?= $data['nomor_pesanan'] ?></div>
    </div>
    <div class="receipt-row">
        <div class="receipt-label">Tanggal Pesanan:</div>
        <div class="receipt-value"><?= $tanggal_pesanan ?> WIB</div>
    </div>
    <div class="receipt-row">
        <div class="receipt-label">Status Pembayaran:</div>
        <div class="receipt-value status-pending"><?= $status_pesanan ?></div>
    </div>
    <div class="receipt-row">
        <div class="receipt-label">Metode Pembayaran:</div>
        <div class="receipt-value"><?= $metode_pembayaran ?></div>
    </div>
</div>

                
                <div class="payment-instructions">
                    <h2>Instruksi Pembayaran</h2>
                    <p>Silakan transfer ke rekening di bawah dalam waktu 24 jam:</p>
                    
                    <div class="bank-account">
                        <div class="bank-logo">
                            <img src="images/bca.jpg" alt="BCA">
                        </div>
                        <div class="account-details">
                            <div class="account-number">1234 5678 9012</div>
                            <div class="account-name">a.n. Toko Tanaman Indonesia</div>
                        </div>
                        <button class="copy-btn" data-clipboard-text="1234 5678 9012">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    
                    <div class="payment-total">
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-amount">
                            <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                        <button class="copy-btn" data-clipboard-text="Rp<?= number_format($total, 0, ',', '.') ?>">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    
                    <p class="payment-note">Catatan: Mohon transfer tepat hingga 3 digit terakhir untuk memudahkan verifikasi.</p>
                    
                    <a href="konfirmasi_pembayaran.php" class="btn btn-primary">Konfirmasi Pembayaran</a>
                </div>
                
                <div class="shipping-info">
                    <h2>Informasi Pengiriman</h2>
                    
                    <div class="shipping-details">
                      
                           <?php if ($shippingAddress): ?>
                        <div class="address-summary">
                            <div class="address-info">
                                <p class="address-name"><strong><?= htmlspecialchars($shippingAddress['nama_penerima']) ?></strong> (<?= htmlspecialchars($shippingAddress['label_alamat']) ?>)</p>
                                <p class="address-phone"><?= htmlspecialchars($shippingAddress['no_telepon']) ?></p>
                                <p class="address-detail"><?= htmlspecialchars($shippingAddress['alamat_lengkap']) ?>, <?= htmlspecialchars($shippingAddress['kecamatan']) ?>, <?= htmlspecialchars($shippingAddress['kota']) ?>, <?= htmlspecialchars($shippingAddress['provinsi']) ?></p>
                            </div>
                            <a href="alamat_pengiriman.php?source=<?= $source ?><?= $product_id ? '&id_produk='.$product_id.'&qty='.$quantity : '' ?>" class="btn btn-outline btn-sm">Ubah Alamat</a>
                        </div>
                        <?php else: ?>
                        <div class="no-address">
                            <p>Belum ada alamat pengiriman yang dipilih.</p>
                            <a href="alamat_pengiriman.php?source=<?= $source ?><?= $product_id ? '&id_produk='.$product_id.'&qty='.$quantity : '' ?>" class="btn btn-primary">Pilih Alamat</a>
                        </div>
                        <?php endif; ?>
                        
                      
                        
                        <div class="shipping-method">
                            <h3>Metode Pengiriman</h3>
                            <div class="courier-logo">
                                <img src="images/jne (1).jpg" alt="JNE">
                            </div>
                            <p class="courier-name">JNE Regular</p>
                            <p class="estimated-time">Estimasi tiba 2-3 hari</p>
                        </div>
                    </div>
                </div>
                
                <div class="order-details">
                    <h2>Detail Pesanan</h2>
                    
                  <div class="order-summary">
                    <h2 class="summary-title">Ringkasan Pesanan</h2>
                    
                    <?php if (!empty($orderData['items'])): ?>
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
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp<?= number_format($orderData['subtotal'], 0, ',', '.') ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Pengiriman (<?= $shippingName ?>)</span>
                            <span>Rp<?= number_format($shippingCost, 0, ',', '.') ?></span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <form action="konfirmasi_pesanan.php" method="post">
                        <!-- Hidden inputs untuk menyimpan data pesanan -->
                        <input type="hidden" name="order_source" value="<?= $source ?>">
                        <?php if ($source === 'buy_now'): ?>
                            <input type="hidden" name="product_id" value="<?= $product_id ?>">
                            <input type="hidden" name="quantity" value="<?= $quantity ?>">
                        <?php endif; ?>
                        <input type="hidden" name="shipping_address_id" value="<?= $shipping_address_id ?>">
                        <input type="hidden" name="shipping_method" value="<?= $selectedShipping ?>">
                        <input type="hidden" name="shipping_cost" value="<?= $shippingCost ?>">
                        <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
                        
                    </form>
                    <?php else: ?>
                        <div class="empty-order">
                            <p>Tidak ada item dalam pesanan</p>
                            <a href="produk.php" class="btn btn-primary">Belanja Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
                <div class="receipt-actions">
                    <a href="index.php" class="btn btn-outline">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
                
                <div class="help-section">
                    <h3>Butuh Bantuan?</h3>
                    <p>Hubungi kami di: <a href="tel:+6281234567890">+62 812 3456 7890</a> atau <a href="mailto:help@tokotanaman.com">help@tokotanaman.com</a></p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Toko Tanaman">
                    <p>Toko tanaman hias terlengkap dan terpercaya</p>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Tautan Cepat</h3>
                    <ul>
                        <li><a href="index.html">Beranda</a></li>
                        <li><a href="produk.html">Produk</a></li>
                        <li><a href="tentang.html">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Kategori</h3>
                    <ul>
                        <li><a href="#">Tanaman Hias Daun</a></li>
                        <li><a href="#">Tanaman Hias Bunga</a></li>
                       
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3 class="footer-title">Kontak Kami</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Tanaman Indah No. 123, Jakarta</p>
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