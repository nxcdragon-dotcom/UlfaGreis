<?php
require 'config/db.php';

echo "=== STRUKTUR TABEL NEWS ===\n";
try {
    $stmt = $conn->query("DESCRIBE news");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "\n=== STRUKTUR TABEL OFFICIALS ===\n";
try {
    $stmt = $conn->query("DESCRIBE officials");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "\n=== STRUKTUR TABEL GALLERY ===\n";
try {
    $stmt = $conn->query("DESCRIBE gallery");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
