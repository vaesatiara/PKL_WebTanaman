<?php
session_start();
include "koneksi.php";


$sql = "SELECT produk.id_produk, produk.nama_tanaman, produk.harga, produk.foto, produk.deskripsi, produk.stok, detail_produk.deskripsi_lengkap
        from produk
        LEFT JOIN detail_produk on produk.id_produk = detail_produk.id_produk
        WHERE detail_produk.id_produk";
$query = mysqli_query($koneksi, $sql);




$detail_produk = mysqli_fetch_assoc($query);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        

        .tab-navigation {
            display: flex;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .tab-button {
            flex: 1;
            padding: 15px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab-button:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .tab-button.active {
            color: #28a745;
            background-color: white;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #28a745;
        }

        .tab-content {
            padding: 30px;
            min-height: 300px;
        }

        .tab-pane {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-section {
            margin-bottom: 20px;
        }

        .content-section h3 {
            color: #343a40;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .content-section p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f1f3f4;
            color: #495057;
        }

        .feature-list li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }

        .rating {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .stars {
            color: #ffc107;
            margin-right: 10px;
        }

        .review-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .review-author {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 5px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - The Secret Garden</title>
    <link rel="stylesheet" href="css/detail_produk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="The Secret Garden">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">BERANDA</a></li>
                    <li><a href="produk.php" class="active">PRODUK</a></li>
                    <li><a href="kontak.php">KONTAK</a></li>
                    <li><a href="tentang-kami.php">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="#"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Beranda</a>
                <span class="separator">/</span>
                <a href="produk.php">Produk</a>
                <span class="separator">/</span>
                <span class="current"><?php echo $detail_produk['nama_tanaman'] ?></span>
            </div>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <div class="product-detail-container">
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="uploads/<?php echo $detail_produk['foto'] ?>" alt="<?php echo $detail_produk['nama_tanaman'] ?>">
                    </div>
                    
                </div>

                <!-- Product Info -->
                <div class="product-info">
                        <span class="product-badge">Baru</span>
                    <h1 class="product-title"><?php echo $detail_produk['nama_tanaman'] ?></h1>
                     <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-count">(4.7)</span>
                    </div>
                        
                    <div class="product-price">
                        <span class="price">Rp <?php echo number_format($detail_produk['harga'], 0, ',', '.') ?></span>
                        <!-- <?php if ($produk['harga_diskon'] > 0): ?>
                            <span class="original-price">Rp <?= number_format($produk['harga_diskon'], 0, ',', '.') ?></span>
                            <span class="discount-badge"><?= round(($produk['harga_diskon'] - $produk['harga']) / $produk['harga_diskon'] * 100) ?>%</span>
                        <?php endif; ?>
                    </div> -->
                    <div class="product-stock">
                        <i class="fas fa-<?php echo $detail_produk['stok'] > 0 ? 'check' : 'times' ?>-circle"></i>
                        <span><?php echo $detail_produk['stok'] > 0 ? 'Stok tersedia' : 'Stok habis' ?></span>
                    </div>
                    <div class="product-description">
                        <p><?php echo $detail_produk['deskripsi'] ?></p>
                    </div>
                    <div class="product-quantity">
                        <label>Jumlah:</label>
                        <div class="quantity-input">
                            <button class="quantity-btn minus">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="1" min="1" max="<?php echo $detail_produk['stok'] ?>">
                            <button class="quantity-btn plus">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                   
        <div class="product-actions">
         <?php if (isset($_SESSION['username'])): ?>
        <a href="keranjang.php?id_produk=<?php echo $detail_produk['id_produk']; ?>" class="btn primary-btn">
            <i class="fas fa-shopping-cart"></i>
            Tambahkan ke Keranjang
        </a>
        <a href="alamat_pengiriman.php" class="btn secondary-btn">
            <i class="fas fa-bolt"></i>
            Beli Sekarang
        </a>
    <?php else: ?>
   
        <a href="login.php" onclick="alert('Silakan login terlebih dahulu untuk menambahkan ke keranjang.');" class="btn primary-btn">
            <i class="fas fa-shopping-cart"></i>
            Tambahkan ke Keranjang
        </a>
        <a href="login.php" onclick="alert('Silakan login terlebih dahulu untuk membeli produk.');" class="btn secondary-btn">
            <i class="fas fa-bolt"></i>
            Beli Sekarang
        </a>
    <?php endif; ?>
</div>

                    <div class="product-delivery">
                        <div class="delivery-item">
                            <i class="fas fa-truck"></i>
                            <span>Pengiriman gratis untuk pembelian di atas Rp 500.000</span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-undo"></i>
                            <span>Pengembalian gratis dalam 7 hari</span>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Garansi tanaman sehat selama 30 hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tabs -->
    
       
    
    <div class="container">
        <div class="tab-navigation">
            <button class="tab-button active" onclick="showTab('deskripsi')">Deskripsi</button>
          
            <button class="tab-button" onclick="showTab('perawatan')">Perawatan</button>
            <button class="tab-button" onclick="showTab('ulasan')">Ulasan</button>
        </div>

        <div class="tab-content">
            <!-- Tab Deskripsi -->
            <div id="deskripsi" class="tab-pane active">
                <div class="content-section">
                    <h3>Deskripsi Produk</h3>
                    <p>Produk berkualitas tinggi yang dirancang khusus untuk memenuhi kebutuhan Anda. Dengan teknologi terdepan dan desain yang elegan, produk ini menawarkan performa optimal dalam setiap penggunaan.</p>
                    
                    <p>Dibuat dengan material premium dan melalui proses quality control yang ketat, produk ini memberikan jaminan kualitas dan daya tahan yang luar biasa. Cocok untuk penggunaan sehari-hari maupun profesional.</p>
                    
                    <h3>Keunggulan Utama</h3>
                    <ul class="feature-list">
                        <li>Kualitas material premium</li>
                        <li>Desain ergonomis dan modern</li>
                        <li>Teknologi terdepan</li>
                        <li>Garansi resmi</li>
                        <li>Ramah lingkungan</li>
                    </ul>
                </div>
            </div>

       
            

            <!-- Tab Perawatan -->
            <div id="perawatan" class="tab-pane">
                <div class="content-section">
                    <h3>Panduan Perawatan</h3>
                    <p>Untuk menjaga kualitas dan memperpanjang umur produk, ikuti panduan perawatan berikut:</p>
                    
                    <h3>Perawatan Harian</h3>
                    <ul class="feature-list">
                        <li>Bersihkan dengan kain lembut dan kering</li>
                        <li>Hindari paparan sinar matahari langsung</li>
                        <li>Simpan di tempat yang kering</li>
                        <li>Jangan gunakan bahan kimia keras</li>
                    </ul>
                    
                    <h3>Perawatan Berkala</h3>
                    <ul class="feature-list">
                        <li>Lakukan pembersihan menyeluruh setiap minggu</li>
                        <li>Periksa kondisi komponen secara rutin</li>
                        <li>Gunakan pembersih khusus jika diperlukan</li>
                        <li>Simpan dalam kemasan asli saat tidak digunakan</li>
                    </ul>
                    
                    <p><strong>Catatan:</strong> Jika terjadi kerusakan, segera hubungi layanan purna jual resmi untuk mendapatkan bantuan.</p>
                </div>
            </div>

            <!-- Tab Ulasan -->
            <div id="ulasan" class="tab-pane">
                <div class="content-section">
                    <h3>Ulasan Pelanggan</h3>
                    <div class="rating">
                        <div class="stars">★★★★★</div>
                        <span>4.8/5 (124 ulasan)</span>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-author">Ahmad Rizki</div>
                        <div class="rating">
                            <div class="stars">★★★★★</div>
                        </div>
                        <p>Produk sangat berkualitas dan sesuai dengan deskripsi. Pengiriman cepat dan packaging rapi. Sangat puas dengan pembelian ini!</p>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-author">Sari Dewi</div>
                        <div class="rating">
                            <div class="stars">★★★★☆</div>
                        </div>
                        <p>Kualitas bagus, desain menarik. Hanya saja instruksi penggunaan bisa lebih detail. Overall recommended!</p>
                    </div>
                    
                    <div class="review-item">
                        <div class="review-author">Budi Santoso</div>
                        <div class="rating">
                            <div class="stars">★★★★★</div>
                        </div>
                        <p>Sudah menggunakan selama 3 bulan, performanya konsisten dan awet. Worth it untuk harga segini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Sembunyikan semua tab pane
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => {
                pane.classList.remove('active');
            });
            
            // Hapus class active dari semua button
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            
            // Tampilkan tab yang dipilih
            document.getElementById(tabName).classList.add('active');
            
            // Tambahkan class active ke button yang diklik
            event.target.classList.add('active');
        }
        
        // Optional: Tambahkan keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                const activeButton = document.querySelector('.tab-button.active');
                const buttons = Array.from(document.querySelectorAll('.tab-button'));
                const currentIndex = buttons.indexOf(activeButton);
                
                let newIndex;
                if (e.key === 'ArrowLeft') {
                    newIndex = currentIndex > 0 ? currentIndex - 1 : buttons.length - 1;
                } else {
                    newIndex = currentIndex < buttons.length - 1 ? currentIndex + 1 : 0;
                }
                
                buttons[newIndex].click();
            }
        });
    </script>
</body>
</html>

    <!-- Footer -->
    <footer class="footer">
        <!-- Feedback Section -->
        <div class="feedback-section">
            <div class="container">
                <h2 class="feedback-title">Kirim kritik/saran untuk kami</h2>
                <p class="feedback-subtitle">Ceritakan kepada kami kritik dan/atau saran Anda</p>
                <form action="submit-feedback.php" method="POST" class="feedback-form">
                    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
                    <input type="text" name="feedback" placeholder="Masukkan kritik/saran" class="feedback-input" required>
                    <button type="submit" class="feedback-btn">KIRIM</button>
                </form>
            </div>
        </div>
        
        <!-- Main Footer -->
        <div class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <!-- Company Info -->
                    <div class="footer-company">
                        <div class="footer-logo">
                            <img src="images/logo.png" alt="The Secret Garden">
                        </div>
                        <p class="company-description">
                            Toko tanaman hias terpercaya dengan berbagai koleksi tanaman berkualitas untuk mempercantik rumah dan ruangan Anda.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="footer-links">
                        <h3 class="footer-heading">Tautan Cepat</h3>
                        <ul class="footer-menu">
                            <li><a href="index.php">BERANDA</a></li>
                            <li><a href="produk.php">PRODUK</a></li>
                            <li><a href="kontak.php">KONTAK</a></li>
                        </ul>
                    </div>
                    
                    <!-- Categories -->
                    <div class="footer-categories">
                        <h3 class="footer-heading">Kategori</h3>
                        <ul class="footer-menu">
                            <li><a href="produk.php?kategori=bunga">Tanaman Hias Bunga</a></li>
                            <li><a href="produk.php?kategori=daun">Tanaman Hias Daun</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="footer-contact">
                        <h3 class="footer-heading">Kontak Kami</h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. Tanaman Indah No. 123, Purwokerto</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>0812-3456-7890</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>thesecretgarden@gmail.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <p>© <?= date('Y') ?> The Secret Garden. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Toast Notification -->
    <div id="notification-toast" class="toast">
        <div class="toast-content">
            <div class="toast-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-message">Produk telah ditambahkan ke keranjang!</div>
        </div>
        <button class="toast-close">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- JavaScript -->
    <script src="js/detail.js"></script>
    <script>
        // Add to cart functionality
        document.getElementById('add-to-cart-btn').addEventListener('click', function() {
            const productId = <?= $id_produk ?>;
            const quantity = document.querySelector('.quantity-input input').value;
            
            fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_produk=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show toast notification
                    const toast = document.getElementById('notification-toast');
                    toast.classList.add('show');
                    
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);
                } else {
                    alert('Gagal menambahkan ke keranjang: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        // Close toast notification
        document.querySelector('.toast-close').addEventListener('click', function() {
            document.getElementById('notification-toast').classList.remove('show');
        });

        
    </script>
</body>
</html>
