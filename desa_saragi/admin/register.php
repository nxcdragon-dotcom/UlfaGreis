<?php
/**
 * Desa Saragi - Admin Registration Page
 * Secure registration for new admin accounts with password hashing
 */
session_start();

// Include database connection
include '../config/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($username) < 3) {
        $error = 'Username minimal 3 karakter!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan Konfirmasi Password tidak cocok!';
    } else {
        try {
            // Check if username already exists
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $checkStmt->execute([$username]);
            $existingUser = $checkStmt->fetch();

            if ($existingUser) {
                $error = 'Username sudah terdaftar! Gunakan username lain.';
            } else {
                // Hash password using password_hash()
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into database
                $insertStmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $insertStmt->execute([$username, $hashedPassword]);

                $success = 'Akun berhasil dibuat! Silakan login dengan username dan password Anda.';
                
                // Clear form
                $_POST = [];
            }
        } catch (PDOException $pdoError) {
            $error = 'Database Error: ' . $pdoError->getMessage();
            error_log("Register Database Error: " . $pdoError->getMessage());
        } catch (Exception $e) {
            $error = 'System Error: ' . $e->getMessage();
            error_log("Register Error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - Desa Saragi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-700 via-green-600 to-emerald-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-700 to-green-600 text-white p-8 text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold">Desa Saragi</h1>
                <p class="text-green-100 text-sm mt-2">Daftar Admin Baru</p>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                <!-- Error Message -->
                <?php if (!empty($error)): ?>
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        <p class="font-semibold text-sm">❌ <?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Success Message -->
                <?php if (!empty($success)): ?>
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                        <p class="font-semibold text-sm">✅ <?php echo htmlspecialchars($success); ?></p>
                        <a href="login.php" class="text-green-600 font-semibold text-sm mt-3 inline-block hover:underline">
                            Ke halaman login →
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <form method="POST" action="" class="space-y-5">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-gray-700 font-semibold mb-2">
                            👤 Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            placeholder="Minimal 3 karakter"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Gunakan username yang mudah diingat</p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            🔒 Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal</p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="confirm_password" class="block text-gray-700 font-semibold mb-2">
                            🔒 Konfirmasi Password
                        </label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            placeholder="Ketik ulang password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Pastikan password sama dengan field di atas</p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition duration-200 flex items-center justify-center mt-6"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Daftar Akun Baru
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center mt-6 text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="login.php" class="text-emerald-600 hover:underline font-semibold">Login di sini</a>
                </p>
            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded text-sm text-blue-800">
            <p class="font-semibold mb-2">💡 Tips Keamanan:</p>
            <ul class="list-disc list-inside space-y-1 text-xs">
                <li>Password harus minimal 6 karakter</li>
                <li>Gunakan kombinasi huruf, angka, dan simbol</li>
                <li>Jangan bagikan password dengan orang lain</li>
                <li>Password disimpan dengan enkripsi bcrypt</li>
            </ul>
        </div>
    </div>
</body>
</html>
