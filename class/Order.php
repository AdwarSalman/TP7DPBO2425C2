<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/Customer.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua pesanan
    public function getAllOrders() {
        $stmt = $this->db->query("SELECT o.*, c.name AS customer_name 
                                  FROM orders o 
                                  JOIN customers c ON o.customer_id = c.id 
                                  ORDER BY o.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // buat pesanan baru
    public function addOrder($customer_id, $total) {
        $stmt = $this->db->prepare("INSERT INTO orders (customer_id, total) VALUES (?, ?)");
        return $stmt->execute([$customer_id, $total]);
    }

    // hapus pesanan
    public function deleteOrder($id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id=?");
        return $stmt->execute([$id]);
    }

    // ambil pesanan per id
    public function getOrderById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
