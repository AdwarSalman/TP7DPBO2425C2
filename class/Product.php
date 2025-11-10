<?php
require_once __DIR__ . '/../config/db.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua produk
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT p.*, c.name AS category_name 
                                  FROM products p 
                                  JOIN categories c ON p.category_id = c.id 
                                  ORDER BY p.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tambah produk baru
    public function addProduct($name, $category_id, $desc, $price, $stock) {
        $stmt = $this->db->prepare("INSERT INTO products (name, category_id, description, price, stock)
                                    VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $category_id, $desc, $price, $stock]);
    }

    // update produk
    public function updateProduct($id, $name, $category_id, $desc, $price, $stock) {
        $stmt = $this->db->prepare("UPDATE products 
                                    SET name=?, category_id=?, description=?, price=?, stock=? 
                                    WHERE id=?");
        return $stmt->execute([$name, $category_id, $desc, $price, $stock, $id]);
    }

    // hapus produk
    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
        return $stmt->execute([$id]);
    }

    // ambil data 1 produk
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
