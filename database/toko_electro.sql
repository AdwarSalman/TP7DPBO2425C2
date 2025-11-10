
CREATE DATABASE IF NOT EXISTS toko_electro_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toko_electro_demo;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES
('Smartphone'),
('Laptop'),
('Aksesoris'),
('Audio');

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category_id INT NOT NULL,
  description TEXT,
  price DECIMAL(12,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) 
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO products (name, category_id, description, price, stock, image) VALUES
('Smartphone XZ Pro', 1, 'Layar 6.5\" • 8GB RAM • 128GB', 4299000, 12, 'https://via.placeholder.com/300x200?text=Smartphone'),
('Laptop Ultra 14\"', 2, 'Intel i5 • 16GB RAM • 512GB SSD', 9499000, 5, 'https://via.placeholder.com/300x200?text=Laptop'),
('Headphone NoiseCancel 700', 4, 'Wireless • ANC • 30 jam', 1899000, 20, 'https://via.placeholder.com/300x200?text=Headphone'),
('Smart Watch V2', 3, 'Sensor detak jantung • 7 hari baterai', 599000, 30, 'https://via.placeholder.com/300x200?text=Smart+Watch'),
('Router AX3000', 3, 'WiFi 6 • Dual-band', 799000, 15, 'https://via.placeholder.com/300x200?text=Router'),
('Speaker Bluetooth 50W', 4, 'Waterproof • 12 jam', 1199000, 8, 'https://via.placeholder.com/300x200?text=Speaker');


CREATE TABLE IF NOT EXISTS customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150),
  phone VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO customers (name, email, phone) VALUES
('Andi Setiawan', 'andi@example.com', '081234567890'),
('Budi Hartono', 'budi@example.com', '081298765432'),
('Citra Dewi', 'citra@example.com', '085612341234');

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  total DECIMAL(12,2) NOT NULL DEFAULT 0,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO orders (customer_id, total) VALUES
(1, 4299000),
(2, 9499000),
(3, 1899000);

