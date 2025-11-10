<?php
// class/Order.php
require_once __DIR__ . '/../config/db.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Ambil semua data order beserta nama pelanggannya
    public function getAll() {
        $sql = "SELECT o.*, c.name as customer_name 
                FROM orders o
                JOIN customers c ON o.customer_id = c.id
                ORDER BY o.order_date DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk membuat transaksi baru (Sederhana: 1 Order = 1 Jenis Produk)
    // Menggunakan Transaction biar aman (kurangi stok dulu, baru buat order)
    public function createOrder($customer_id, $product_id, $qty) {
        try {
            $this->db->beginTransaction();

            // 1. Ambil harga produk dan cek stok
            $stmt = $this->db->prepare("SELECT price, stock FROM products WHERE id = ? FOR UPDATE");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product || $product['stock'] < $qty) {
                throw new Exception("Stok produk tidak mencukupi!");
            }

            $subtotal = $product['price'] * $qty;

            // 2. Kurangi Stok Produk
            $updateStock = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $updateStock->execute([$qty, $product_id]);

            // 3. Buat Header Order
            $stmtOrder = $this->db->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");
            $stmtOrder->execute([$customer_id, $subtotal]);
            $order_id = $this->db->lastInsertId();

            // 4. Buat Detail Order
            $stmtDetail = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
            $stmtDetail->execute([$order_id, $product_id, $qty, $subtotal]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
?>