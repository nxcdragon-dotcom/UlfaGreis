<?php
/**
 * Database Configuration - Simple PDO Connection
 * Used for admin login and basic database operations
 */

$host = "localhost";
$db_name = "desa_saragi";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("❌ Koneksi Database Gagal: " . $e->getMessage() . 
        "<br>Pastikan:<br>1. Database 'desa_saragi' sudah dibuat di phpMyAdmin<br>" .
        "2. Jalankan SQL untuk membuat tabel users, news, officials, dan gallery<br>" .
        "3. Username MySQL adalah 'root' dan password kosong");
}
?>
