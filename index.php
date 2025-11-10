<?php

require_once __DIR__ . '/class/Product.php';
require_once __DIR__ . '/class/Customer.php';
require_once __DIR__ . '/class/Order.php';

// Buat instance (boleh dipakai di view jika diperlukan)
$product = new Product();
$customer = new Customer();
$order = new Order();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Toko Elektronik</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/view/partials/header.php'; ?>
    <main class="container py-4">
        <h2 class="mb-4 fw-bold text-primary">Sistem Toko Elektronik</h2>

        <!-- Navigasi antar halaman -->
        <nav class="mb-4">
            <a href="?page=home" class="btn btn-outline-primary btn-sm">Home</a>
            <a href="?page=products" class="btn btn-outline-primary btn-sm">Produk</a>
            <a href="?page=customers" class="btn btn-outline-primary btn-sm">Pelanggan</a>
            <a href="?page=orders" class="btn btn-outline-primary btn-sm">Pesanan</a>
        </nav>

        <?php
        // Routing halaman
        $page = $_GET['page'] ?? 'home';
        $viewPath = __DIR__ . '/view/' . $page . '.php';

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p class='text-danger'>Halaman tidak ditemukan.</p>";
        }
        ?>
    </main>
    <?php include __DIR__ . '/view/partials/footer.php'; ?>
</body>
</html>
