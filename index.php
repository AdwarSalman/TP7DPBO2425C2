<?php
require_once __DIR__ . '/class/Product.php';
require_once __DIR__ . '/class/Customer.php';
require_once __DIR__ . '/class/Order.php';

$product = new Product();
$customer = new Customer();
$order = new Order();

// handle aksi CRUD sederhana langsung dari index
if (isset($_POST['create_product'])) {
    $product->addProduct($_POST['name'], $_POST['category_id'], $_POST['description'], $_POST['price'], $_POST['stock']);
}
if (isset($_POST['create_customer'])) {
    $customer->addCustomer($_POST['name'], $_POST['email'], $_POST['phone']);
}
if (isset($_POST['create_order'])) {
    $order->addOrder($_POST['customer_id'], $_POST['total']);
}
if (isset($_GET['delete_product'])) {
    $product->deleteProduct($_GET['delete_product']);
}
if (isset($_GET['delete_customer'])) {
    $customer->deleteCustomer($_GET['delete_customer']);
}
if (isset($_GET['delete_order'])) {
    $order->deleteOrder($_GET['delete_order']);
}
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
    <?php include 'view/partials/header.php'; ?>
    <main class="container py-4">
        <h2 class="mb-4 fw-bold text-primary">Sistem Toko Elektronik</h2>

        <nav class="mb-4">
            <a href="?page=products" class="btn btn-outline-primary btn-sm">Produk</a>
            <a href="?page=customers" class="btn btn-outline-primary btn-sm">Pelanggan</a>
            <a href="?page=orders" class="btn btn-outline-primary btn-sm">Pesanan</a>
        </nav>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'products') include 'view/products.php';
            elseif ($page == 'customers') include 'view/customers.php';
            elseif ($page == 'orders') include 'view/orders.php';
        } else {
            include 'view/home.php';
        }
        ?>
    </main>
    <?php include 'view/partials/footer.php'; ?>
</body>
</html>
