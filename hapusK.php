<?php
session_start();
include "koneksi.php";

$id_produk=$_GET['id_produk'];
unset($_SESSION['keranjang'][$id_produk]);

echo 
    header ("Locaation: produk.php?hapus=sukses");
    exit;
echo
    header ("Location: manajemen_produk.php?hapus=gagal");
    exit;

?>