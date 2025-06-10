<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php?login_dulu");
    exit;
}

$id_pelanggan = $_SESSION['id_pelanggan'] ?? '';
$username = $_SESSION['username'];

// Fungsi untuk mendapatkan data pesanan
function getOrderData($source = 'cart', $product_id = null, $quantity = 1) {
    global $koneksi;
    $orderItems = [];
    $totalHarga = 0;
    
    if ($source === 'cart') {
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
        'shipping' => 25000,
        'total' => $totalHarga + 25000
    ];
}

// Proses pemilihan alamat
if (isset($_POST['pilih_alamat'])) {
    $_SESSION['alamat_terpilih'] = $_POST['alamat_id'];
}

// Proses penambahan alamat baru
if (isset($_POST['tambah_alamat'])) {
    $label_alamat = mysqli_real_escape_string($koneksi, $_POST['label_alamat']);
    $nama_penerima = mysqli_real_escape_string($koneksi, $_POST['nama_penerima']);
    $no_telepon = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
    $provinsi = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
    $kota = mysqli_real_escape_string($koneksi, $_POST['kota']);
    $kecamatan = mysqli_real_escape_string($koneksi, $_POST['kecamatan']);
    $alamat_lengkap = mysqli_real_escape_string($koneksi, $_POST['alamat_lengkap']);
    $is_primary = isset($_POST['is_primary']) ? 1 : 0;
    
    // Jika dijadikan alamat utama, update alamat lain
   
    
    $insert_sql = "INSERT INTO pengiriman (id_pelanggan, label_alamat, nama_penerima, no_telepon, provinsi, kota, kecamatan, alamat_lengkap, is_primary) 
                   VALUES ('$id_pelanggan', '$label_alamat', '$nama_penerima', '$no_telepon', '$provinsi', '$kota', '$kecamatan', '$alamat_lengkap', '$is_primary')";
    
    if (mysqli_query($koneksi, $insert_sql)) {
        $new_id = mysqli_insert_id($koneksi);
        $_SESSION['alamat_terpilih'] = $new_id;
        $_SESSION['success_message'] = "Alamat berhasil ditambahkan dan dipilih!";
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan saat menambahkan alamat.";
    }
}

// Ambil data alamat tersimpan
$sql_alamat="SELECT * FROM pengiriman";
$query_alamat = mysqli_query($koneksi, $sql_alamat);
$alamat=mysqli_fetch_assoc($query_alamat);

// Tentukan sumber data pesanan
$source = isset($_GET['source']) ? $_GET['source'] : 'cart';
$product_id = isset($_GET['id_produk']) ? $_GET['id_produk'] : null;
$quantity = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if (isset($_GET['direct_buy']) && $_GET['direct_buy'] == 1) {
    $source = 'buy_now';
}

$orderData = getOrderData($source, $product_id, $quantity);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Pengiriman - Toko Tanaman</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .address-selection {
            margin-bottom: 20px;
        }
        
        .address-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .address-card:hover {
            border-color: #4CAF50;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
        }
        
        .address-card.selected {
            border-color: #4CAF50;
            background-color: #f8fff8;
        }
        
        .address-card.selected::before {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        
        .address-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            display: none;
        }
        
        .address-form.show {
            display: block;
        }
        
        .form-toggle {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
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
                
            </div>
            
            <div class="checkout-content">
                <div class="checkout-form">
                    <h2>Pilih Alamat Pengiriman</h2>
                    
                    <?php if(isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?= $_SESSION['success_message']; ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $_SESSION['error_message']; ?>
                        <?php unset($_SESSION['error_message']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="address-selection">
                        <h3>Alamat Tersimpan</h3>
                        
                       
                            <form method="POST" id="alamatForm">
                                
                                <!-- <div class="address-card <?= (isset($_SESSION['alamat_terpilih']) && $_SESSION['alamat_terpilih'] == $alamat['id_pengiriman']) || (!isset($_SESSION['alamat_terpilih']) && $alamat['is_primary']) ? 'selected' : '' ?>" 
                                     onclick="selectAddress(<?= $alamat['id_pengiriman'] ?>)"> -->
                                    <input type="radio" name="alamat_id" value="<?= $alamat['id_pengiriman'] ?>"> </div>
                                         
                                    
                                    <div class="address-label">
                                        <?= $alamat['label_alamat'] ?>
                                        <!-- <?php if($alamat['is_primary']): ?>
                                            <span class="badge-primary">Utama</span>
                                        <?php endif; ?> -->
                                    </div>
                                    <div class="address-info">
                                        <p class="address-name"><?= $alamat['nama_penerima'] ?></p>
                                        <p class="address-phone"><?= $alamat['no_telepon'] ?></p>
                                        <p class="address-detail">
                                            <?= $alamat['alamat_lengkap'] . ', ' . $alamat['kecamatan'] . ', ' . $alamat['kota'] . ', ' . $alamat['provinsi'] ?>
                                        </p>
                                    </div>
                                    <div class="address-actions" onclick="event.stopPropagation();">
                                        <a href="edit_alamat.php?id=<?= $alamat['id_pengiriman'] ?>" class="btn btn-outline btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="hapus_alamat.php?id_pengiriman=<?= $alamat['id_pengiriman'] ?>" 
                                           class="btn btn-outline btn-sm delete-btn"
                                           onclick="return confirm('Yakin ingin menghapus alamat ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                        </div>
                            
                                
                                <button type="submit" name="pilih_alamat" class="btn btn-primary" style="margin-bottom: 20px;">
                                    <i class="fas fa-check"></i> Gunakan Alamat Terpilih
                                </button>
                                
                            </form>
                       
                            <p>Belum ada alamat tersimpan. Silakan tambah alamat baru.</p>
                      
                        
                        <button type="button" class="form-toggle" onclick="toggleAddressForm()">
                            <i class="fas fa-plus"></i> Tambah Alamat Baru
                        </button>
                        </div>
                        </div>
                        </div>
                        <div class="address-form" id="addressForm">
                            <h4>Tambah Alamat Baru</h4>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="label_alamat" class="form-label">Label Alamat</label>
                                    <input type="text" name="label_alamat" class="form-control" placeholder="Rumah, Kantor, dll" required>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nama_penerima" class="form-label">Nama Penerima</label>
                                        <input type="text" name="nama_penerima" class="form-control" placeholder="Nama lengkap penerima" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                        <input type="tel" name="no_telepon" class="form-control" placeholder="Nomor telepon penerima" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="provinsi" class="form-label">Provinsi</label>
                                        <select name="provinsi" class="form-control" required>
                                            <option value="">Pilih Provinsi</option>
                                            <option value="DKI Jakarta">DKI Jakarta</option>
                                            <option value="Jawa Barat">Jawa Barat</option>
                                            <option value="Jawa Tengah">Jawa Tengah</option>
                                            <option value="Jawa Timur">Jawa Timur</option>
                                            <option value="Yogyakarta">D.I. Yogyakarta</option>
                                            <option value="Banten">Banten</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kota" class="form-label">Kota/Kabupaten</label>
                                        <input type="text" name="kota" class="form-control" placeholder="Kota/Kabupaten" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, dll" required></textarea>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" id="is_primary" name="is_primary" class="form-check-input">
                                    <label for="is_primary" class="form-check-label">Jadikan sebagai alamat utama</label>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline" onclick="toggleAddressForm()">Batal</button>
                                    <button type="submit" name="tambah_alamat" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan & Gunakan
                                    </button>
                               
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
                            <input type="hidden" name="order_source" value="<?= $source ?>">
                            <?php if ($source === 'buy_now'): ?>
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                <input type="hidden" name="quantity" value="<?= $quantity ?>">
                            <?php endif; ?>
                            
                            <a href="metode_pengiriman.php" class="checkout-btn" >
                                   
                                Lanjutkan ke Pengiriman
                            </a>
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

    <script>
        function selectAddress(id) {
            // Remove selected class from all cards
            document.querySelectorAll('.address-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
            
            // Check the radio button
            document.querySelector(`input[value="${id}"]`).checked = true;
        }
        
        function toggleAddressForm() {
            const form = document.getElementById('addressForm');
            form.classList.toggle('show');
        }
        
        // Auto-submit form when address is selected
        document.querySelectorAll('input[name="alamat_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Optional: Auto-submit when address is selected
                // document.getElementById('alamatForm').submit();
            });
        });
    </script>
</body>
</html>
