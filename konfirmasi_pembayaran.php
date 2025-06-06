<?php
include "koneksi.php";

?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - The Secret Garden</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.html">
                    <img src="images/logo.png" alt="The Secret Garden">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">BERANDA</a></li>
                    <li><a href="produk.html">PRODUK</a></li>
                    <li><a href="kontak.html">KONTAK</a></li>
                    <li><a href="tentang_kami.html">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.html" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
                <a href="profil.html" class="user-icon"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <section class="confirmation-section">
        <div class="container">
            <div class="confirmation-header">
                <h1>Konfirmasi Pembayaran</h1>
                <p>Silakan konfirmasi pembayaran Anda untuk pesanan <strong>TSG23051200001</strong></p>
            </div>
            
            <div class="confirmation-content">
                <div class="confirmation-form">
                    <div class="form-card">
                        <h2>Detail Pembayaran</h2>
                        <div class="payment-details">
                            <div class="detail-row">
                                <span>Nomor Pesanan</span>
                                <span>TSG23051200001</span>
                            </div>
                            <div class="detail-row">
                                <span>Total Pembayaran</span>
                                <span></span>
                            </div>
                            <div class="detail-row">
                                <span>Metode Pembayaran</span>
                                <span>Transfer Bank BCA</span>
                            </div>
                        </div>
                        
                        <form id="payment-confirmation-form">
                            <div class="form-group">
                                <label for="payment-date">Tanggal Pembayaran</label>
                                <input type="date" id="payment-date" name="payment-date" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment-time">Waktu Pembayaran</label>
                                <input type="time" id="payment-time" name="payment-time" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment-amount">Jumlah Pembayaran</label>
                                <input type="text" id="payment-amount" name="payment-amount" value="540000" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment-proof">Bukti Pembayaran</label>
                                <div class="file-upload">
                                    <input type="file" id="payment-proof" name="payment-proof" accept="image/*" required>
                                    <label for="payment-proof" class="file-label">
                                        <i class="fas fa-upload"></i> Pilih File
                                    </label>
                                    <span class="file-name">Belum ada file dipilih</span>
                                </div>
                                <p class="file-help">Format yang diterima: JPG, PNG, PDF. Maksimal 2MB.</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment-notes">Catatan (Opsional)</label>
                                <textarea id="payment-notes" name="payment-notes" rows="3"></textarea>
                            </div>
                            
                            <div class="form-buttons">
                                <a href="struk.html" class="btn btn-outline">Kembali</a>
                                <button type="submit" class="btn btn-primary" value="riwayat_pesanan.php">Konfirmasi Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="confirmation-info">
                    <div class="info-card">
                        <h2>Informasi Pembayaran</h2>
                        <div class="bank-info">
                            <img src="images/bca.jpg" alt="BCA">
                            <div>
                                <h3>Bank BCA</h3>
                                <p>Nomor Virtual Account: 8277081234567890</p>
                                <p>Atas Nama: The Secret Garden</p>
                            </div>
                        </div>
                        <div class="payment-instructions">
                            <h3>Petunjuk Konfirmasi</h3>
                            <ol>
                                <li>Pastikan Anda telah melakukan pembayaran sesuai dengan total yang tertera.</li>
                                <li>Isi formulir konfirmasi dengan data yang benar.</li>
                                <li>Unggah bukti pembayaran (screenshot atau foto struk).</li>
                                <li>Klik tombol "Konfirmasi Pembayaran".</li>
                                <li>Tim kami akan memverifikasi pembayaran Anda dalam 1x24 jam.</li>
                            </ol>
                        </div>
                        <div class="help-contact">
                            <h3>Butuh Bantuan?</h3>
                            <p>Jika Anda mengalami kesulitan dalam melakukan konfirmasi pembayaran, silakan hubungi customer service kami:</p>
                            <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
                            <p><i class="fab fa-whatsapp"></i> 0812-3456-7890</p>
                            <p><i class="fas fa-envelope"></i> cs@thesecretgarden.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="The Secret Garden">
                    <p>Toko tanaman hias terpercaya dengan berbagai koleksi tanaman berkualitas untuk mempercantik rumah dan ruangan Anda.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Tautan Cepat</h3>
                    <ul>
                        <li><a href="index.html">BERANDA</a></li>
                        <li><a href="produk.html">PRODUK</a></li>
                        <li><a href="kontak.html">KONTAK</a></li>
                        <li><a href="tentang.html">TENTANG KAMI</a></li>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Kategori</h3>
                    <ul>
                        <li><a href="produk.html?category=bunga">Tanaman Hias Bunga</a></li>
                        <li><a href="produk.html?category=daun">Tanaman Hias Daun</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3>Kontak Kami</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Tanaman Indah No. 123, Jakarta</p>
                    <p><i class="fas fa-phone"></i> 0812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> thesecretgarden@gmail.com</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 The Secret Garden. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>