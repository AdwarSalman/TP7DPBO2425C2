<?php
require_once __DIR__ . '/../config/db.php';

class Customer {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua pelanggan
    public function getAllCustomers() {
        $stmt = $this->db->query("SELECT * FROM customers ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tambah pelanggan
    public function addCustomer($name, $email, $phone) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $phone]);
    }

    // update pelanggan
    public function updateCustomer($id, $name, $email, $phone) {
        $stmt = $this->db->prepare("UPDATE customers SET name=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([$name, $email, $phone, $id]);
    }

    // hapus pelanggan
    public function deleteCustomer($id) {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id=?");
        return $stmt->execute([$id]);
    }

    // ambil data pelanggan tertentu
    public function getCustomerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
