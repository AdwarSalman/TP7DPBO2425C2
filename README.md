# TP7DPBO2425C2 - Sistem Toko Elektronik Berbasis OOP

Project ini merupakan tugas praktikum yang mengimplementasikan konsep **Object-Oriented Programming (OOP)** dalam Website berbasis **PHP dengan GUI Web**.  
Aplikasi ini menampilkan sistem **Toko Elektronik** untuk mengelola **produk, pelanggan, dan transaksi (pesanan)** dengan fitur **CRUD (Create, Read, Update, Delete)** serta **relasi kompleks antar 5 tabel** menggunakan **MySQL Database**.

---

## 🙏🏻 Janji

Saya Muhammad Adwar Salman dengan NIM 2401539 mengerjakan Tugas Praktikum 7 dalam mata kuliah **Desain dan Pemrograman Berorientasi Objek (DPBO)** untuk keberkahan-Nya, maka saya **tidak melakukan kecurangan** seperti yang telah dispesifikasikan.  
_Aamiin._

---

## 💡 Fitur Utama

### 📦 1. Manajemen Produk (Products)
- Menampilkan daftar produk lengkap dengan Kategori, Harga, dan Stok.
- Menambah dan mengedit produk dengan memilih Kategori dari **dropdown** (data dinamis dari database).
- Menghapus produk (dilindungi *Foreign Key* jika sudah pernah terjual).
- **Relasi:** `products.category_id` → `categories.id`.

### 👤 2. Manajemen Pelanggan (Customers)
- Menampilkan daftar pelanggan beserta kontak (email & telepon).
- CRUD lengkap untuk data pelanggan.
- **Validasi Hapus:** Tidak bisa dihapus jika memiliki riwayat transaksi aktif.

### 🛒 3. Transaksi Pesanan (Orders)
- Mencatat transaksi pembelian baru dengan memilih Pelanggan dan Produk.
- **Otomatisasi Stok:** Stok produk berkurang otomatis saat transaksi dibuat.
- Menggunakan **Database Transaction** (`beginTransaction`, `commit`, `rollback`) untuk menjamin integritas data antara tabel `orders`, `order_details`, dan `products`.
- Menampilkan riwayat transaksi beserta total pembayarannya.

---

## 🗂️ Struktur Direktori Project
# Struktur Direktori Project

* [class/](class/)
    * [Category.php](class/Category.php)
    * [Customer.php](class/Customer.php)
    * [Order.php](class/Order.php)
    * [Product.php](class/Product.php)
* [config/](config/)
    * [db.php](config/db.php)
* [database/](database/)
    * [electronic_store_v2.sql](database/electronic_store_v2.sql)
* [view/](view/)
    * [customers.php](view/customers.php)
    * [home.php](view/home.php)
    * [orders.php](view/orders.php)
    * [products.php](view/products.php)
    * [style.css](view/style.css)
* [index.php](index.php)
* [README.md](README.md)
---

## 🧠 Konsep OOP yang Diterapkan

| Konsep | Implementasi dalam Project |
| :--- | :--- |
| **Encapsulation** | Setiap entitas (`Product`, `Customer`, `Order`) dibungkus dalam *class* terpisah. Properti koneksi database (`$db`) bersifat `private` dan hanya bisa diakses oleh method dalam class tersebut. |
| **Abstraction** | Kompleksitas query SQL (JOIN, Transaction) disembunyikan di dalam method seperti `getAll()` atau `createOrder()`. View hanya tinggal memanggil method tersebut tanpa tahu detail query-nya. |
| **Modularity** | Kode dipecah ke dalam folder `class/` (logika), `view/` (tampilan), dan `config/` (konfigurasi) agar mudah dikelola dan dikembangkan. |
| **Relations & Integrity**| Menggunakan *Foreign Key* di database dan *Exception Handling* di PHP untuk menjaga data tetap konsisten (misal: mencegah penghapusan data induk yang masih dipakai anak). |

---

## 💾 Struktur Database (`electronic_store_v2.sql`)

Sistem ini menggunakan 5 tabel yang saling berelasi:

1.  **`categories`** (id, name) → Menyimpan jenis produk (Laptop, HP, dll).
2.  **`products`** (id, category_id, name, price, stock) → Menyimpan data barang yang dijual.
3.  **`customers`** (id, name, email, phone) → Menyimpan data pembeli.
4.  **`orders`** (id, customer_id, order_date, total_amount) → Header transaksi (siapa yang beli & kapan).
5.  **`order_details`** (id, order_id, product_id, quantity, subtotal) → Rincian barang apa saja yang dibeli dalam satu transaksi.

---

## ⚙️ Alur Program (Flow)

1.  **Akses Web:** Pengguna membuka `index.php`. Secara default akan diarahkan ke halaman `home` (Dashboard).
2.  **Navigasi:** Pengguna memilih menu (misal: Produk). `index.php` akan memanggil file view yang sesuai (`view/products.php`).
3.  **Interaksi View-Class:**
    * `view/products.php` membuat objek dari `class/Product.php`.
    * View memanggil method `$product->getAll()` untuk mendapatkan data.
    * Class menjalankan query SQL ke database melalui `config/db.php` dan mengembalikan hasilnya ke View.
4.  **Transaksi (Contoh Kasus Kompleks):**
    * Di halaman `orders.php`, saat user klik "Proses Transaksi":
    * Data dikirim ke `class/Order.php`.
    * Method `createOrder()` berjalan dalam satu *transaction*: cek stok → kurangi stok → buat order header → buat order detail.
    * Jika ada satu langkah gagal (misal stok habis), semua perubahan dibatalkan (*rollback*).

---

## 📸 Dokumentasi

*(Tambahkan screenshot aplikasi Anda di sini)*
