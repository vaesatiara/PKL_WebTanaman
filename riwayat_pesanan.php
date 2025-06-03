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
                            <h2>Casseline</h2>
                            <p>caselline11@gmail.com</p>
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
                                    <img src="images/bunga2.jpg" alt="Monstera">
                                    <div class="item-details">
                                        <h3>Monstera Deliciosa</h3>
                                        <p>1 x Rp195.000</p>
                                    </div>
                                </div>
                                <div class="order-item">
                                    <img src="images/bunga1.jpg" alt="Calathea">
                                    <div class="item-details">
                                        <h3>Calathea Orbifolia</h3>
                                        <p>1 x Rp175.000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-footer">
                                <div class="order-total">
                                    Total Pesanan: <span class="total-amount">Rp370.000</span>
                                </div>
                                <div class="order-actions">
                                    <a href="#" class="btn btn-outline">Detail Pesanan</a>
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