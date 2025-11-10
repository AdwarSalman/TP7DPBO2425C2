# TP7DPBO2425C2
Project ini merupakan tugas praktikum yang mengimplementasikan konsep **Object-Oriented Programming (OOP)** dalam Website berbasis **PHP dengan GUI Web**.  
Aplikasi ini menampilkan sistem sederhana untuk mengelola **produk, pelanggan, dan pesanan** dengan fitur **CRUD (Create, Read, Update, Delete)** serta **relasi antar tabel** menggunakan **MySQL Database**.

---

## 🙏🏻 Janji
Saya Muhammad Adwar Salman dengan NIM 2401539 mengerjakan Tugas Praktikum 7 dalam mata kuliah **Desain dan Pemrograman Berorientasi Objek (DPBO)** untuk keberkahan-Nya, maka saya **tidak melakukan kecurangan** seperti yang telah dispesifikasikan.  
_Aamiin._

---

## 💡 Fitur Utama

### 🛒 1. Manajemen Produk (Products)
- Menampilkan daftar produk beserta kategori, harga, stok, dan deskripsi.
- Menambah produk baru dengan memilih kategori (dropdown).
- Mengedit dan menghapus produk dari sistem.
- Menggunakan relasi tabel kategori (`category_id → categories.id`).

### 👤 2. Manajemen Pelanggan (Customers)
- Menampilkan daftar pelanggan terdaftar.
- Menambah pelanggan baru dengan nama, email, dan nomor telepon.
- Mengedit dan menghapus data pelanggan.

### 🧾 3. Manajemen Pesanan (Orders)
- Membuat pesanan berdasarkan pelanggan yang sudah ada.
- Menampilkan daftar pesanan aktif.
- Menghapus pesanan.
- Relasi langsung antara `orders.customer_id → customers.id`.

---

## 🗂️ Struktur Direktori Project

- TP7DPBO2425C2/
  - index.php → Halaman utama (router antar view)
  - style.css → Styling tampilan web (Bootstrap + CSS custom)
  - class/
    - Product.php → Class untuk entitas Produk
    - Customer.php → Class untuk entitas Pelanggan
    - Order.php → Class untuk entitas Pesanan
  - config/
    - db.php → File koneksi database menggunakan PDO
  - database/
    - toko_electro.sql → Skema dan data awal database
  - view/
    - home.php → Halaman utama (welcome)
    - products.php → Tampilan & CRUD Produk
    - customers.php → Tampilan & CRUD Pelanggan
    - orders.php → Tampilan & CRUD Pesanan
    - partials/
      - header.php → Komponen header (navigasi)
      - footer.php → Komponen footer

---

## 🧠 Konsep OOP yang Diterapkan

| Konsep | Implementasi |
|--------|---------------|
| **Encapsulation** | Setiap entitas (`Product`, `Customer`, `Order`) diatur dalam class tersendiri, menyembunyikan detail query di dalam method. |
| **Abstraction** | Detail koneksi database disembunyikan di `config/db.php` menggunakan class `Database`. |
| **Composition** | Class `Order` menggunakan objek dari `Customer` untuk menghubungkan data pesanan dan pelanggan. |
| **Modularity** | Pemisahan file berdasarkan fungsinya (class, config, view) agar kode lebih terstruktur. |
| **Prepared Statement** | Semua query database menggunakan PDO + prepared statements untuk keamanan dari SQL Injection. |

---

## 💾 Struktur Database (`toko_electro.sql`)

### 📦 Table: `categories`

| Field | Type | Keterangan |
|-------|------|------------|
| id | INT (PK) | ID unik kategori |
| name | VARCHAR(100) | Nama kategori produk |

### 🛒 Table: `products`

| Field | Type | Keterangan |
|-------|------|------------|
| id | INT (PK) | ID unik produk |
| name | VARCHAR(100) | Nama produk |
| category_id | INT (FK → categories.id) | Relasi ke kategori |
| description | TEXT | Deskripsi produk |
| price | DOUBLE | Harga produk |
| stock | INT | Jumlah stok tersedia |

### 👤 Table: `customers`

| Field | Type | Keterangan |
|-------|------|------------|
| id | INT (PK) | ID unik pelanggan |
| name | VARCHAR(100) | Nama pelanggan |
| email | VARCHAR(100) | Email pelanggan |
| phone | VARCHAR(20) | Nomor telepon pelanggan |

### 🧾 Table: `orders`

| Field | Type | Keterangan |
|-------|------|------------|
| id | INT (PK) | ID unik pesanan |
| customer_id | INT (FK → customers.id) | Pelanggan yang memesan |
| total | DOUBLE | Total harga pesanan |
| created_at | DATETIME | Waktu pesanan dibuat |

---

## ⚙️ Flow Program

1. **index.php**  
   → Entry point utama aplikasi, berfungsi sebagai router antar halaman (`products`, `customers`, `orders`).  
   Mengatur pemanggilan class sesuai aksi CRUD.

2. **config/db.php**  
   → Membuat koneksi database menggunakan **PDO** dengan `try-catch` untuk menampilkan error jika koneksi gagal.

3. **class/**  
   → Berisi logika utama aplikasi:  
   - `Product.php` → CRUD Produk  
   - `Customer.php` → CRUD Pelanggan  
   - `Order.php` → CRUD Pesanan  

4. **view/**  
   → Menyediakan tampilan GUI (HTML + PHP) untuk setiap entitas.  
   - `products.php` → Form dan tabel produk  
   - `customers.php` → Data pelanggan  
   - `orders.php` → Data pesanan  

5. Semua proses CRUD dilakukan lewat method class masing-masing.  
   Setelah operasi (insert/update/delete), data otomatis direfresh di tabel tampilan.

---

## 📸 Dokumentasi
