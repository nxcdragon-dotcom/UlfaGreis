<?php
/**
 * Desa Saragi - Admin Login Page
 * Secure login for administrators with password_verify()
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

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi.';
    } else {
        try {
            // Use prepared statement to fetch user by username
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Use password_verify() to check the password
            if ($user && password_verify($password, $user['password'])) {
                // Login successful - set session variables
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_name'] = $user['username'];  // Add this for dashboard display
                $_SESSION['login_time'] = time();

                // Set remember me cookie if checked
                if (isset($_POST['remember']) && $_POST['remember'] === 'on') {
                    setcookie('admin_username', $username, time() + (30 * 24 * 60 * 60), '/');
                }

                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                // Failed login attempt
                $error = 'Username atau password salah!';
            }
        } catch (PDOException $pdoError) {
            $error = 'Database Error: ' . $pdoError->getMessage();
            error_log("Login Database Error: " . $pdoError->getMessage());
        } catch (Exception $e) {
            $error = 'System Error: ' . $e->getMessage();
            error_log("Login Error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Saragi</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold">Desa Saragi</h1>
                <p class="text-green-100 text-sm mt-2">Panel Admin</p>
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
                        <p class="font-semibold text-sm">✓ <?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="" class="space-y-5">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-gray-700 font-semibold text-sm mb-2">
                            📧 Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            required 
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan username Anda"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : (isset($_COOKIE['admin_username']) ? htmlspecialchars($_COOKIE['admin_username']) : ''); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        >
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-gray-700 font-semibold text-sm mb-2">
                            🔐 Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        >
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="w-4 h-4 text-emerald-600 rounded focus:ring-2 focus:ring-emerald-500"
                        >
                        <label for="remember" class="ml-2 text-gray-700 text-sm">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-emerald-700 to-green-600 text-white font-bold py-2 px-4 rounded-lg hover:from-emerald-800 hover:to-green-700 transition transform hover:scale-105 duration-200"
                    >
                        🔓 Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 border-t border-gray-300"></div>

                <!-- Links -->
                <div class="text-center space-y-3">
                    <p class="text-gray-600 text-sm">
                        Kembali ke 
                        <a href="../index.php" class="text-emerald-600 font-semibold hover:text-emerald-700 transition">
                            Beranda
                        </a>
                    </p>
                    
                    <p class="text-gray-600 text-sm">
                        Belum punya akun? 
                        <a href="register.php" class="text-emerald-600 font-semibold hover:text-emerald-700 transition">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="bg-gray-50 border-t border-gray-200 p-4 text-center text-gray-600 text-xs">
                <p>🔒 Akses terbatas untuk administrator terdaftar</p>
                <p class="mt-1">© 2026 Desa Saragi</p>
            </div>
        </div>

        <!-- Additional Security Info -->
        <div class="mt-6 text-center text-white text-xs">
            <p>Jika Anda lupa password, hubungi administrator desa.</p>
        </div>
    </div>

    <!-- Simple Validation Script -->
    <script>
        // Client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            if (!username) {
                e.preventDefault();
                alert('Silakan masukkan username Anda.');
                document.getElementById('username').focus();
                return false;
            }

            if (!password) {
                e.preventDefault();
                alert('Silakan masukkan password Anda.');
                document.getElementById('password').focus();
                return false;
            }

            if (username.length < 3) {
                e.preventDefault();
                alert('Username minimal 3 karakter.');
                document.getElementById('username').focus();
                return false;
            }
        });

        // Clear error messages when user starts typing
        document.getElementById('username').addEventListener('input', function() {
            const errorBox = document.querySelector('[class*="bg-red-100"]');
            if (errorBox) {
                errorBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>
