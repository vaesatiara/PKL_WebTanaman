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
        'subtotal' => $totalHarga,
        'shipping' => 25000, // Biaya pengiriman tetap
        'total' => $totalHarga + 25000
    ];
}

// Tentukan sumber data berdasarkan parameter
$source = isset($_GET['source']) ? $_GET['source'] : 'cart';
$product_id = isset($_GET['id_produk']) ? $_GET['id_produk'] : null;
$quantity = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

$orderData = getOrderData($source, $product_id, $quantity);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pesanan - Toko Tanaman</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="Toko Tanaman">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">BERANDA</a></li>
                    <li><a href="produk.php">PRODUK</a></li>
                    <li><a href="kontak.php">KONTAK</a></li>
                    <li><a href="tentang_kami.php">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="profil.php"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <main class="checkout-section">
        <div class="container">
            <div class="checkout-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Alamat</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-label">Pengiriman</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
            
            <div class="checkout-content">
                <div class="checkout-form">
                    <h2>Alamat Pengiriman</h2>
                    
                    <div class="address-section">
                        <h3>Alamat Tersimpan</h3>
                        
                        <div class="address-list">
                            <div class="address-card selected">
                                <div class="address-label">Rumah</div>
                                <div class="address-info">
                                    <p class="address-name">Casseline</p>
                                    <p class="address-phone">0812-3456-7890</p>
                                    <p class="address-detail">Jl. Tanaman Indah No. 123, Kecamatan Maju Jaya, Jakarta Selatan, 12345</p>
                                </div>
                                <div class="address-actions">
                                    <button class="btn btn-outline btn-sm edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline btn-sm delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <?php
                        $sql = "SELECT * FROM pengiriman ORDER BY id_pengiriman DESC";
                        $query = mysqli_query($koneksi, $sql);
                        while($pengiriman = mysqli_fetch_assoc($query)) : 
                        ?>
                        <div class="address-card">
                            <div class="address-label"><?= $pengiriman['label_alamat'] ?></div>
                            <div class="address-info">
                                <p class="address-name"><?= $pengiriman['nama_penerima'] ?></p>
                                <p class="address-phone"><?= $pengiriman['no_telepon'] ?></p>
                                <p class="address-detail"><?= $pengiriman['alamat_lengkap'].', '.$pengiriman['provinsi'].', '.$pengiriman['kota'].', '.$pengiriman['kecamatan'] ?></p>
                            </div>
                            <div class="address-actions">
                                <button class="btn btn-outline btn-sm edit-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline btn-sm delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endwhile; ?>

                        <form action="prosesT_pengiriman.php" method="post">
                            <div class="form-group">
                                <label for="addressLabel" class="form-label">Label Alamat</label>
                                <input type="text" name="label_alamat" class="form-control" placeholder="Rumah, Kantor, dll">
                            </div>   
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="recipientName" class="form-label">Nama Penerima</label>
                                    <input type="text" name="nama_penerima" class="form-control" placeholder="Nama lengkap penerima">
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                                    <input type="number" name="no_telepon" class="form-control" placeholder="Nomor telepon penerima">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" placeholder="Provinsi">
                                </div>
                                <div class="form-group">
                                    <label for="kota" class="form-label">Kota/Kabupaten</label>
                                    <input type="text" name="kota" class="form-control" placeholder="Kota">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="district" class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan">
                            </div>
            
                            <div class="form-group">
                                <label for="fullAddress" class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, dll"></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="setAsPrimary" class="form-check-input">
                                <label for="setAsPrimary" class="form-check-label">Jadikan sebagai alamat utama</label>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline" id="cancelBtn">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h2 class="summary-title">Ringkasan Pesanan</h2>
                    
                    <?php if (!empty($orderData['items'])): ?>
                        <div class="summary-items">
                            <?php foreach ($orderData['items'] as $item): ?>
                            <div class="summary-item">
                                <img src="uploads/<?= $item['foto'] ?>" alt="<?= $item['nama_tanaman'] ?>" class="item-image">
                                <div class="item-info">
                                    <h3><?= $item['nama_tanaman'] ?></h3>
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
                            <span>Pengiriman</span>
                            <span>Rp<?= number_format($orderData['shipping'], 0, ',', '.') ?></span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>Rp<?= number_format($orderData['total'], 0, ',', '.') ?></span>
                        </div>
                        
                        <form action="metode_pengiriman.php" method="post">
                            <!-- Hidden inputs untuk menyimpan data pesanan -->
                            <input type="hidden" name="order_source" value="<?= $source ?>">
                            <?php if ($source === 'buy_now'): ?>
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                <input type="hidden" name="quantity" value="<?= $quantity ?>">
                            <?php endif; ?>
                            
                            <button type="submit" class="checkout-btn">Lanjutkan ke Pengiriman</button>
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
    </main>

    <footer>
        <section class="feedback">
            <div class="container">
                <h2>Kirim kritik/saran untuk kami</h2>
                <p>Ceritakan kepada kami kritik dan/atau saran Anda</p>
                
                <div class="feedback-form">
                    <input type="text" placeholder="Masukkan kritik/saran">
                    <button type="submit">KIRIM</button>
                </div>
            </div>
        </section>
        
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Toko Tanaman">
                    <p>Toko tanaman hias terpercaya dengan berbagai koleksi tanaman berkualitas untuk mempercantik rumah dan ruangan Anda.</p>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Tautan Cepat</h3>
                    <ul>
                        <li><a href="index.php">BERANDA</a></li>
                        <li><a href="produk.php">PRODUK</a></li>
                        <li><a href="kontak.php">KONTAK</a></li>
                        <li><a href="tentang_kami.php">TENTANG KAMI</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3 class="footer-title">Kategori</h3>
                    <ul>
                        <li><a href="tanaman_hias_daun.php">Tanaman Hias Daun</a></li>
                        <li><a href="tanaman_hias_bunga.php">Tanaman Hias Bunga</a></li>
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
