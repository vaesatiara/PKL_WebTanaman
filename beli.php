<?php
session_start();

include "koneksi.php"; // pastikan ini menyambungkan ke database

$data = [];
$query = mysqli_query($koneksi, "SELECT * FROM produk");
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}



// Fungsi untuk update jumlah produk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_keranjang'])) {
    foreach ($_POST['jumlah'] as $id_produk => $jumlah) {
        if (isset($_SESSION['keranjang'][$id_produk])) {
            $_SESSION['keranjang'][$id_produk]['jumlah'] = max(1, (int)$jumlah);
        }
    }
    header('Location: beli.php');
    exit();
}

// Fungsi untuk menghapus produk
if (isset($_GET['hapus'])) {
    $produk_id = $_GET['hapus'];
    if (isset($_SESSION['keranjang'][$id_produk])) {
        unset($_SESSION['keranjang'][$id_produk]);
    }
    header('Location: beli.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Keranjang Belanja</title>
    <style>
        .quantity-input {
            display: flex;
            align-items: center;
        }
        .quantity-input button {
            width: 25px;
            height: 25px;
            font-size: 14px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .quantity-input input {
            width: 40px;
            height: 23px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .remove-btn {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Keranjang Belanja Anda</h2>
    
    <?php if (empty($_SESSION['keranjang'])): ?>
        <p>Keranjang belanja Anda kosong.</p>
    <?php else: ?>
        <form method="post" action="">
            <table>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $total = 0;
                foreach ($_SESSION['keranjang'] as $id_produk => $item): 
    $harga = isset($item['harga']) ? (int) str_replace(['Rp', '.', ',', ' '], '', $item['harga']) : 0;
    $jumlah = isset($item['jumlah']) ? (int) $item['jumlah'] : 0;

    $subtotal = $harga * $jumlah;
    $total += $subtotal;
                ?>
                <?php foreach ($data as $produk): ?>
                    <tr>
                        <td><?= htmlspecialchars($produk['nama_tanaman']) ?></td>
                        <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php endforeach; ?>
                            <div class="quantity-input">
                                <button type="button" onclick="updateQuantity('<?= $id ?>', -1)">-</button>
                                <input type="number" name="jumlah[<?= $id ?>]" 
                                       id="qty_<?= $id ?>" 
                                       value="<?= $item['jumlah'] ?>" min="1">
                                <button type="button" onclick="updateQuantity('<?= $id ?>', 1)">+</button>
                            </div>
                        </td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td>
                            <a href="beli.php?hapus=<?= $id ?>" class="remove-btn">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    <td></td>
                </tr>
            </table>
            <button type="submit" name="update_beli">Update Keranjang</button>
        </form>
    <?php endif; ?>
    
    <p><a href="index.php">Lanjut Belanja</a></p>
    
    <script>
        function updateQuantity(id_produk, change) {
            const input = document.getElementById('qty_' + id_produk);
            let newValue = parseInt(input.value) + change;
            if (newValue < 1) newValue = 1;
            input.value = newValue;
        }
    </script>
</body>
</html>

