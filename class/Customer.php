<?php
require_once __DIR__ . '/../config/db.php';

class Customer {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM customers ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($name, $email, $phone) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $phone]);
    }

    public function update($id, $name, $email, $phone) {
        $stmt = $this->db->prepare("UPDATE customers SET name=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([$name, $email, $phone, $id]);
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM customers WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1451) {
                throw new Exception("Pelanggan tidak bisa dihapus karena memiliki riwayat transaksi.");
            }
            throw $e;
        }
    }
}
?>