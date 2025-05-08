<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Tanaman</title>
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
                <a href="keranjang.html" class="active"><i class="fas fa-shopping-cart"></i></a>
                <a href=""><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <main class="cart-section">
        <div class="container">
            <h1 class="cart-title">Keranjang Belanja</h1>
            <p class="cart-subtitle">Tinjau item yang Anda tambahkan ke keranjang</p>
            
            <div class="cart-container">
                <div class="cart-items">
                    <div class="cart-header">
                        <div class="header-product">Produk</div>
                        <div class="header-price">Harga</div>
                        <div class="header-quantity">Jumlah</div>
                        <div class="header-subtotal">Subtotal</div>
                        <div class="header-remove"></div>
                    </div>

                    <form action="prosesT_keranjang.php" method="post">
                    <div class="cart-item">
                        <div class="product-info">
                            
                            <div class="product-details">
                                <h3><?=$produk['nama_tanaman']?></h3>
                                <p class="size">Ukuran: Sedang</p>
                            </div>
                        </div>
                        <div class="item-price">Rp 150.000</div>
                        <div class="item-quantity">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <input type="text" class="quantity-input" value="1" readonly>
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>
                        <div class="item-subtotal">Rp 150.000</div>
                        <div class="item-remove">
                            <button class="remove-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    </form>
                    
                    <div class="cart-item">
                        <div class="product-info">
                            <img src="images/Anyelir mini.jpg" alt="Anyelir Mini" class="product-image">
                            <div class="product-details">
                                <h3>Anyelir Mini</h3>
                                <p class="size">Ukuran: Sedang</p>
                            </div>
                        </div>
                        <div class="item-price">Rp 150.000</div>
                        <div class="item-quantity">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <input type="text" class="quantity-input" value="1" readonly>
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>
                        <div class="item-subtotal">Rp 150.000</div>
                        <div class="item-remove">
                            <button class="remove-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="product-info">
                            <img src="images/monstera.jpg" alt="Monstera" class="product-image">
                            <div class="product-details">
                                <h3>Monstera</h3>
                                <p class="size">Ukuran: Kecil</p>
                            </div>
                        </div>
                        <div class="item-price">Rp 250.000</div>
                        <div class="item-quantity">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <input type="text" class="quantity-input" value="1" readonly>
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>
                        <div class="item-subtotal">Rp 250.000</div>
                        <div class="item-remove">
                            <button class="remove-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="product-info">
                            <img src="images/oxalis.jpg" alt="Oxalis Triangularis" class="product-image">
                            <div class="product-details">
                                <h3>Oxalis Triangularis</h3>
                                <p class="size">Ukuran: Sedang</p>
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="price-discount">
                                <span class="original-price">Rp 180.000</span>
                                <span class="current-price">Rp 135.000</span>
                            </div>
                        </div>
                        <div class="item-quantity">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <input type="text" class="quantity-input" value="1" readonly>
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>
                        <div class="item-subtotal">Rp 135.000</div>
                        <div class="item-remove">
                            <button class="remove-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    
                    <div class="cart-actions">
                        <a href="produk.html" class="continue-shopping-btn">
                            <i class="fas fa-arrow-left"></i> Lanjutkan Belanja
                        </a>
                        <button class="empty-cart-btn">
                            <i class="fas fa-trash"></i> Kosongkan Keranjang
                        </button>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h2 class="summary-title">Ringkasan Pesanan</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp 535.000</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Diskon</span>
                        <span>- Rp 0</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Estimasi Pengiriman</span>
                        <span>Rp 25.000</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp 560.000</span>
                    </div>
                    
                    <div class="promo-section">
                        <h3 class="promo-title">Kode Promo</h3>
                        <div class="promo-form">
                            <input type="text" class="promo-input" placeholder="Masukkan kode promo">
                            <button class="promo-btn">Terapkan</button>
                        </div>
                    </div>
                    
                    <a href="alamat_pengiriman.html" class="checkout-btn">Lanjutkan ke Pembayaran</a>
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
         <br>
         <br>
         <br>
         <br>  
        
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Toko Tanaman">
                    <p>Toko tanaman hias terpercaya dengan berbagai koleksi tanaman berkualitas untuk mempercantik rumah dan ruangan Anda.</p>
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

</body>
</html>