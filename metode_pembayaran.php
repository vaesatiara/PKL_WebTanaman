<?php
// Start session to maintain user data across pages
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "toko_tanaman"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session (assuming user is logged in)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Get current order ID from session
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : 0;

// Get shipping details from session
$shipping_method = isset($_SESSION['shipping_method']) ? $_SESSION['shipping_method'] : 'jne';
$shipping_cost = isset($_SESSION['shipping_cost']) ? $_SESSION['shipping_cost'] : 25000;
$shipping_name = isset($_SESSION['shipping_name']) ? $_SESSION['shipping_name'] : 'JNE Regular';

// Subtotal from cart items
$subtotal = 545000;

// Calculate total
$total = $subtotal + $shipping_cost;

// If form is submitted to update payment method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment'])) {
    $payment_method = $_POST['payment'];
    
    // Save to session
    $_SESSION['payment_method'] = $payment_method;
    
    // Update order in database if order_id exists
    if ($order_id > 0) {
        $sql = "UPDATE orders SET payment_method = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $payment_method, $order_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Redirect to confirmation page
    header("Location: konfirmasi_pesanan.php");
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran - Toko Tanaman</title>
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
                    <li><a href="tentang_kami.html">TENTANG KAMI</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="keranjang.html"><i class="fas fa-shopping-cart"></i></a>
                <a href="profil.html"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </header>

    <main class="checkout-section">
        <div class="container">
            <div class="checkout-steps">
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-label">Alamat</div>
                </div>
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-label">Pengiriman</div>
                </div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
               
            </div>
            
            <div class="checkout-content">
                <div class="checkout-form">
                    <h2>Metode Pembayaran</h2>
                    
                    <!-- Back to Shipping Method button -->
                    <a href="metode_pengiriman.php" class="btn btn-outline" style="margin-bottom: 20px; display: inline-block;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Metode Pengiriman
                    </a>
                    
                    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="paymentForm">
                        <div class="payment-group">
                            <h4>Transfer Bank</h4>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="bca" value="bca">
                                    <label for="bca" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/bca.png" alt="BCA">
                                        </div>
                                        <div class="payment-info">
                                            <h4>Bank BCA</h4>
                                            <p>Pembayaran akan diverifikasi dalam 24 jam</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="bni" value="bni">
                                    <label for="bni" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/bni.png" alt="BNI">
                                        </div>
                                        <div class="payment-info">
                                            <h4>Bank BNI</h4>
                                            <p>Pembayaran akan diverifikasi dalam 24 jam</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="mandiri" value="mandiri">
                                    <label for="mandiri" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/mandiri.png" alt="Mandiri">
                                        </div>
                                        <div class="payment-info">
                                            <h4>Bank Mandiri</h4>
                                            <p>Pembayaran akan diverifikasi dalam 24 jam</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-group">
                            <h4>E-Wallet</h4>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="gopay" value="gopay">
                                    <label for="gopay" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/gopay.png" alt="GoPay">
                                        </div>
                                        <div class="payment-info">
                                            <h4>GoPay</h4>
                                            <p>Pembayaran instan melalui aplikasi Gojek</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="ovo" value="ovo">
                                    <label for="ovo" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/ovo.png" alt="OVO">
                                        </div>
                                        <div class="payment-info">
                                            <h4>OVO</h4>
                                            <p>Pembayaran instan melalui aplikasi OVO</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" name="payment" id="dana" value="dana">
                                    <label for="dana" class="payment-label">
                                        <div class="payment-logo">
                                            <img src="images/dana.png" alt="DANA">
                                        </div>
                                        <div class="payment-info">
                                            <h4>DANA</h4>
                                            <p>Pembayaran instan melalui aplikasi DANA</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
                
                <div class="order-summary">
                    <h2 class="summary-title">Ringkasan Pesanan</h2>
                    
                    <div class="summary-items">
                        <div class="summary-item">
                            <img src="images/monstera.jpg" alt="Monstera" class="item-image">
                            <div class="item-info">
                                <h3>Monstera</h3>
                                <p>1 x Rp195.000</p>
                            </div>
                            <div class="item-price">Rp195.000</div>
                        </div>
                        
                        <div class="summary-item">
                            <img src="images/Calathea Orbifolia.jpg" alt="Calathea Orbifolia" class="item-image">
                            <div class="item-info">
                                <h3>Calathea Orbifolia</h3>
                                <p>2 x Rp175.000</p>
                            </div>
                            <div class="item-price">Rp350.000</div>
                        </div>
                    </div>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Pengiriman (<?= htmlspecialchars($shipping_name) ?>)</span>
                        <span>Rp<?= number_format($shipping_cost, 0, ',', '.') ?></span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Metode Pembayaran (<?= htmlspecialchars($shipping_name) ?>)</span>
                        <span>Rp<?= number_format($shipping_cost, 0, ',', '.') ?></span>
                    </div>
                     <a href="struk.php" class="checkout-btn">Buat Pesanan</a>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all payment options
        const paymentOptions = document.querySelectorAll('.payment-option input');
        
        // Add event listeners to each payment option
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                // Add selected class to the parent div and remove from others
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.closest('.payment-option').classList.add('selected');
            });
        });
    });
    </script>
</body>
</html>
