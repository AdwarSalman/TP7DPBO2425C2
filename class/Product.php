<?php
require_once __DIR__ . '/../config/db.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        // JOIN dengan kategori biar muncul nama kategorinya
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($name, $category_id, $price, $stock) {
        $stmt = $this->db->prepare("INSERT INTO products (name, category_id, price, stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $category_id ?: null, $price, $stock]);
    }

    public function update($id, $name, $category_id, $price, $stock) {
        $stmt = $this->db->prepare("UPDATE products SET name=?, category_id=?, price=?, stock=? WHERE id=?");
        return $stmt->execute([$name, $category_id ?: null, $price, $stock, $id]);
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            // Error 1451: Cannot delete or update a parent row (Foreign Key fail)
            if ($e->errorInfo[1] == 1451) {
                throw new Exception("Produk tidak bisa dihapus karena sudah pernah terjual.");
            }
            throw $e;
        }
    }
}
?>