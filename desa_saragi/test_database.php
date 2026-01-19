<?php
/**
 * Desa Cendana - Database Connection Tester
 * 
 * PURPOSE: Test if database, tables, and login credentials are properly set up
 * 
 * HOW TO USE:
 * 1. Save this file as: c:\laragon\www\desa_cendana\test_database.php
 * 2. Visit: http://localhost/desa_cendana/test_database.php
 * 3. Check all ✓ marks - if any ✗, follow the instructions
 * 
 * DELETE THIS FILE AFTER TESTING FOR SECURITY!
 */

// Start output buffering to see results
ob_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - Desa Cendana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-emerald-700 mb-2">🔧 Database Connection Test</h1>
            <p class="text-gray-600 mb-8">Testing Desa Cendana database setup...</p>

            <div class="space-y-6">
                <?php
                
                // Test 1: PHP Version
                echo '<div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">';
                echo '<h3 class="text-lg font-bold text-blue-900 mb-2">✓ PHP Version</h3>';
                echo '<p class="text-blue-800">PHP ' . phpversion() . '</p>';
                if (version_compare(phpversion(), '7.4', '>=')) {
                    echo '<p class="text-green-600 font-semibold">✓ Compatible</p>';
                } else {
                    echo '<p class="text-red-600 font-semibold">✗ Needs PHP 7.4+</p>';
                }
                echo '</div>';

                // Test 2: PDO Extension
                echo '<div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">';
                echo '<h3 class="text-lg font-bold text-blue-900 mb-2">✓ PDO Extension</h3>';
                if (extension_loaded('pdo')) {
                    echo '<p class="text-green-600 font-semibold">✓ PDO is installed</p>';
                } else {
                    echo '<p class="text-red-600 font-semibold">✗ PDO not found - install PDO extension</p>';
                }
                echo '</div>';

                // Test 3: MySQL PDO Driver
                echo '<div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">';
                echo '<h3 class="text-lg font-bold text-blue-900 mb-2">✓ MySQL PDO Driver</h3>';
                if (in_array('mysql', PDO::getAvailableDrivers())) {
                    echo '<p class="text-green-600 font-semibold">✓ MySQL driver available</p>';
                } else {
                    echo '<p class="text-red-600 font-semibold">✗ MySQL driver not found - install php-mysql</p>';
                }
                echo '</div>';

                // Test 4: Database Connection
                echo '<div class="border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded">';
                echo '<h3 class="text-lg font-bold text-yellow-900 mb-2">⏳ Database Connection</h3>';
                
                try {
                    // Try to connect
                    require_once 'config/database.php';
                    $db = Database::getConnection();
                    
                    echo '<p class="text-green-600 font-semibold">✓ Connected to MySQL</p>';
                    echo '<p class="text-gray-700">Host: localhost</p>';
                    echo '<p class="text-gray-700">User: root</p>';
                    
                    // Test 5: Database Exists
                    echo '</div>';
                    echo '<div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">';
                    echo '<h3 class="text-lg font-bold text-green-900 mb-2">✓ Database Exists</h3>';
                    
                    try {
                        $stmt = $db->prepare("SELECT DATABASE()");
                        $stmt->execute();
                        $currentDb = $stmt->fetch(PDO::FETCH_COLUMN);
                        echo '<p class="text-green-600 font-semibold">✓ Database: ' . htmlspecialchars($currentDb) . '</p>';
                    } catch (Exception $e) {
                        echo '<p class="text-red-600 font-semibold">✗ Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    
                    // Test 6: Tables Exist
                    echo '</div>';
                    echo '<div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">';
                    echo '<h3 class="text-lg font-bold text-green-900 mb-2">✓ Tables Exist</h3>';
                    
                    $tables = ['users', 'news', 'officials', 'gallery'];
                    $allTablesExist = true;
                    
                    foreach ($tables as $table) {
                        try {
                            $stmt = $db->prepare("SELECT 1 FROM $table LIMIT 1");
                            $stmt->execute();
                            echo '<p class="text-green-600">✓ Table: ' . $table . '</p>';
                        } catch (Exception $e) {
                            echo '<p class="text-red-600">✗ Table: ' . $table . ' (not found)</p>';
                            $allTablesExist = false;
                        }
                    }
                    
                    // Test 7: Admin User
                    echo '</div>';
                    echo '<div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">';
                    echo '<h3 class="text-lg font-bold text-green-900 mb-2">✓ Admin User</h3>';
                    
                    try {
                        $stmt = $db->prepare("SELECT id, username, email FROM users WHERE username = ?");
                        $stmt->execute(['admin']);
                        $admin = $stmt->fetch();
                        
                        if ($admin) {
                            echo '<p class="text-green-600 font-semibold">✓ Admin user found</p>';
                            echo '<p class="text-gray-700">ID: ' . htmlspecialchars($admin['id']) . '</p>';
                            echo '<p class="text-gray-700">Username: ' . htmlspecialchars($admin['username']) . '</p>';
                            echo '<p class="text-gray-700">Email: ' . htmlspecialchars($admin['email']) . '</p>';
                            
                            // Test password hash
                            $stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
                            $stmt->execute(['admin']);
                            $userPass = $stmt->fetch(PDO::FETCH_COLUMN);
                            
                            if (password_verify('admin123', $userPass)) {
                                echo '<p class="text-green-600 font-semibold">✓ Password hash verified for admin123</p>';
                            } else {
                                echo '<p class="text-red-600 font-semibold">✗ Password hash mismatch</p>';
                            }
                        } else {
                            echo '<p class="text-red-600 font-semibold">✗ Admin user not found</p>';
                            echo '<p class="text-red-700">Solution: Import database.sql</p>';
                        }
                    } catch (Exception $e) {
                        echo '<p class="text-red-600 font-semibold">✗ Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    
                    // Test 8: Sample Data
                    echo '</div>';
                    echo '<div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">';
                    echo '<h3 class="text-lg font-bold text-green-900 mb-2">✓ Sample Data</h3>';
                    
                    try {
                        $counts = [
                            'news' => 'Berita',
                            'officials' => 'Pejabat',
                            'gallery' => 'Galeri'
                        ];
                        
                        foreach ($counts as $table => $label) {
                            $stmt = $db->prepare("SELECT COUNT(*) as count FROM $table");
                            $stmt->execute();
                            $count = $stmt->fetch()['count'];
                            echo '<p class="text-gray-700">' . $label . ': <span class="font-semibold">' . $count . ' item(s)</span></p>';
                        }
                    } catch (Exception $e) {
                        echo '<p class="text-red-600">Error fetching counts: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    
                } catch (PDOException $e) {
                    echo '<p class="text-red-600 font-semibold">✗ Connection Failed</p>';
                    echo '<p class="text-red-700 mb-4">' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '<div class="bg-red-100 border border-red-400 p-4 rounded text-red-800">';
                    echo '<h4 class="font-bold mb-2">Troubleshooting:</h4>';
                    echo '<ol class="list-decimal list-inside space-y-2">';
                    echo '<li>Make sure MySQL is running (Laragon start button)</li>';
                    echo '<li>Check database "desa_cendana" exists</li>';
                    echo '<li>Verify config/database.php has correct credentials</li>';
                    echo '<li>Import database.sql if not done yet</li>';
                    echo '</ol>';
                    echo '</div>';
                }
                
                echo '</div>';
                
                // Summary
                echo '<div class="mt-8 bg-gradient-to-r from-emerald-700 to-green-600 text-white p-6 rounded-lg">';
                echo '<h2 class="text-2xl font-bold mb-4">📋 Summary</h2>';
                echo '<p class="mb-4">If all tests above show ✓, your setup is correct!</p>';
                echo '<h3 class="text-lg font-bold mb-2">Next Steps:</h3>';
                echo '<ol class="list-decimal list-inside space-y-2">';
                echo '<li>Delete this file (test_database.php) for security</li>';
                echo '<li>Visit: <a href="/desa_cendana/admin/login.php" class="underline">Admin Login</a></li>';
                echo '<li>Login with: admin / admin123</li>';
                echo '<li>Check dashboard for statistics</li>';
                echo '</ol>';
                echo '</div>';
                
                ?>
            </div>

            <div class="mt-8 border-t pt-6">
                <p class="text-gray-600 text-sm">
                    <strong>⚠️ IMPORTANT:</strong> Delete this test file (test_database.php) after verification for security reasons!
                </p>
                <p class="text-gray-600 text-sm mt-2">
                    Created: January 19, 2026 | Desa Cendana Website
                </p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>
