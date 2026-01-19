-- Create Database for Desa Cendana
CREATE DATABASE IF NOT EXISTS desa_cendana;
USE desa_cendana;

-- Users Table (Admin Credentials)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- News Table
CREATE TABLE IF NOT EXISTS news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Officials Table (Village Staff)
CREATE TABLE IF NOT EXISTS officials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    position VARCHAR(150) NOT NULL,
    bio TEXT,
    photo VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Admin User (password: admin123)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@desacendana.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert Sample Data
INSERT INTO officials (name, position, bio, photo, phone, email) VALUES 
('Budi Santoso', 'Kepala Desa', 'Pemimpin desa yang berpengalaman lebih dari 10 tahun melayani masyarakat.', '', '081234567890', 'kepala@desacendana.local'),
('Siti Nurhaliza', 'Sekretaris Desa', 'Mengelola administrasi dan dokumentasi desa.', '', '081234567891', 'sekretaris@desacendana.local'),
('Ahmad Wijaya', 'Bendahara Desa', 'Mengelola keuangan desa dengan transparan dan akuntabel.', '', '081234567892', 'bendahara@desacendana.local');

INSERT INTO news (title, content, author_id, image) VALUES 
('Selamat Datang di Desa Cendana', 'Kami dengan bangga mempersembahkan website resmi Desa Cendana. Platform digital ini dirancang untuk memudahkan komunikasi antara pemerintah desa dan masyarakat.', 1, 'welcome.jpg'),
('Program Pemberdayaan Masyarakat', 'Desa Cendana meluncurkan program pemberdayaan masyarakat untuk meningkatkan perekonomian lokal melalui UMKM dan pertanian berkelanjutan.', 1, 'program.jpg'),
('Acara Gotong Royong Bulan Ini', 'Mari bergabung dalam acara gotong royong membersihkan lingkungan desa. Kegiatan ini dilakukan setiap akhir pekan untuk menjaga kebersihan dan keindahan desa kita.', 1, 'gotong-royong.jpg');

INSERT INTO gallery (title, image, description) VALUES 
('Kegiatan Bersih Lingkungan', 'galeri1.jpg', 'Masyarakat desa bersama-sama membersihkan lingkungan sekitar.'),
('Panen Padi Desa Cendana', 'galeri2.jpg', 'Hasil panen padi yang melimpah di persawahan desa.'),
('Acara Pertemuan Warga', 'galeri3.jpg', 'Pertemuan rutin warga membahas pembangunan desa.');
