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
                    <li><a href="index.html">BERANDA</a></li>
                    <li><a href="produk.html">PRODUK</a></li>
                    <li><a href="kontak.html">KONTAK</a></li>
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
                
                <div class="receipt-details">
                    <div class="receipt-row">
                        <div class="receipt-label">Nomor Pesanan:</div>
                        <div class="receipt-value">TN12345</div>
                    </div>
                    <div class="receipt-row">
                        <div class="receipt-label">Tanggal Pesanan:</div>
                        <div class="receipt-value">22 Mei 2023, 14:35 WIB</div>
                    </div>
                    <div class="receipt-row">
                        <div class="receipt-label">Status Pembayaran:</div>
                        <div class="receipt-value status-pending">Menunggu Pembayaran</div>
                    </div>
                    <div class="receipt-row">
                        <div class="receipt-label">Metode Pembayaran:</div>
                        <div class="receipt-value">Transfer Bank BCA</div>
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
                        <div class="total-amount">Rp 335.000</div>
                        <button class="copy-btn" data-clipboard-text="335000">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    
                    <p class="payment-note">Catatan: Mohon transfer tepat hingga 3 digit terakhir untuk memudahkan verifikasi.</p>
                    
                    <a href="konfirmasi_pembayaran.php" class="btn btn-primary">Konfirmasi Pembayaran</a>
                </div>
                
                <div class="shipping-info">
                    <h2>Informasi Pengiriman</h2>
                    
                    <div class="shipping-details">
                        <div class="shipping-address">
                            <h3>Alamat Pengiriman</h3>
                            <p class="recipient">John Doe</p>
                            <p class="phone">+62 812 3456 7890</p>
                            <p class="address">Jl. Tanaman Indah No. 123, Kecamatan Kebayoran, Jakarta Selatan, DKI Jakarta, 12345</p>
                        </div>
                        
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
                    
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-image">
                                <img src="images/monstera.jpg" alt="Monstera Deliciosa">
                            </div>
                            <div class="item-details">
                                <h3>Monstera Deliciosa</h3>
                                <p class="item-variant">Ukuran: Medium, Pot: Plastik Hitam</p>
                                <p class="item-price">Rp 175.000 x 1</p>
                            </div>
                            <div class="item-subtotal">Rp 175.000</div>
                        </div>
                        
                        <div class="order-item">
                            <div class="item-image">
                                <img src="images/Calathea Orbifolia.jpg" alt="Calathea">
                            </div>
                            <div class="item-details">
                                <h3>Calathea Orbifolia</h3>
                                <p class="item-variant">Ukuran: Medium, Pot: Keramik</p>
                                <p class="item-price">Rp 135.000 x 1</p>
                            </div>
                            <div class="item-subtotal">Rp 135.000</div>
                        </div>
                    </div>
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <div class="summary-label">Subtotal</div>
                            <div class="summary-value">Rp 310.000</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Pengiriman (JNE)</div>
                            <div class="summary-value">Rp 25.000</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Diskon</div>
                            <div class="summary-value">Rp 0</div>
                        </div>
                        <div class="summary-row total">
                            <div class="summary-label">Total</div>
                            <div class="summary-value">Rp 335.000</div>
                        </div>
                    </div>
                </div>
                
                <div class="receipt-actions">
                    <a href="index.html" class="btn btn-outline">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                    <button class="btn btn-outline" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak Struk
                    </button>
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