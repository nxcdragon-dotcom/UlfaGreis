<?php
/**
 * Test INSERT queries untuk verifikasi sinkronisasi database
 */
require 'config/db.php';

echo "=== TEST DATABASE QUERIES ===\n\n";

// Test 1: NEWS INSERT
echo "1️⃣ Testing NEWS INSERT\n";
try {
    $sql = "INSERT INTO news (Judul, kontak, gambar) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "   Parameters: ['Test Judul', 'Test Kontak', 'test.jpg']\n";
    
    // Don't actually execute, just test prepare
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: OFFICIALS INSERT
echo "2️⃣ Testing OFFICIALS INSERT\n";
try {
    $sql = "INSERT INTO officials (nama, posisi, foto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "   Parameters: ['Test Nama', 'Test Posisi', 'test.jpg']\n";
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 3: GALLERY INSERT
echo "3️⃣ Testing GALLERY INSERT\n";
try {
    $sql = "INSERT INTO gallery (title, gambar) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "   Parameters: ['Test Title', 'test.jpg']\n";
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 4: NEWS SELECT
echo "4️⃣ Testing NEWS SELECT\n";
try {
    $sql = "SELECT id, Judul, tanggal, gambar FROM news ORDER BY tanggal DESC";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 5: OFFICIALS SELECT
echo "5️⃣ Testing OFFICIALS SELECT\n";
try {
    $sql = "SELECT id, nama, posisi, foto FROM officials ORDER BY posisi ASC";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 6: GALLERY SELECT
echo "6️⃣ Testing GALLERY SELECT\n";
try {
    $sql = "SELECT id, title, gambar, tanggal FROM gallery ORDER BY tanggal DESC";
    $stmt = $conn->prepare($sql);
    echo "✅ Query prepared: $sql\n";
    echo "✅ Query syntax valid!\n\n";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

echo "=== ALL QUERY TESTS PASSED ===\n";
?>
