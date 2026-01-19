<?php
/**
 * Desa Saragi - Users Management
 * Manage admin accounts
 */
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include '../config/db.php';

$message = '';
$message_type = 'success';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Prevent deleting the current logged-in user
    if ($user_id === $_SESSION['admin_id']) {
        $message = 'Anda tidak bisa menghapus akun sendiri!';
        $message_type = 'error';
    } else {
        try {
            $deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $deleteStmt->execute([$user_id]);
            
            $message = 'Admin berhasil dihapus!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}

// Fetch all admin users
try {
    $stmt = $conn->prepare("SELECT id, username, created_at FROM users ORDER BY created_at DESC");
    $stmt->execute();
    $usersList = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = 'Database Error: ' . $e->getMessage();
    $message_type = 'error';
    $usersList = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - Desa Saragi Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-green-300 rounded-full flex items-center justify-center font-bold text-emerald-900">
                        🌿
                    </div>
                    <span class="text-white font-bold text-xl hidden sm:inline">Desa Saragi Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-green-100 text-sm">👤 <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></span>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-gray-100 min-h-screen p-6 hidden md:block">
            <div class="space-y-6">
                <div>
                    <h3 class="text-emerald-400 font-bold text-lg mb-4">📊 Dashboard</h3>
                    <ul class="space-y-2">
                        <li><a href="dashboard.php" class="hover:text-emerald-400 transition">🏠 Beranda</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-emerald-400 font-bold text-lg mb-4">📰 Berita</h3>
                    <ul class="space-y-2">
                        <li><a href="news_manage.php" class="hover:text-emerald-400 transition">📋 Kelola Berita</a></li>
                        <li><a href="add_news.php" class="hover:text-emerald-400 transition">➕ Tambah Berita</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-emerald-400 font-bold text-lg mb-4">👥 Pejabat</h3>
                    <ul class="space-y-2">
                        <li><a href="officials_manage.php" class="hover:text-emerald-400 transition">📋 Kelola Pejabat</a></li>
                        <li><a href="add_officials.php" class="hover:text-emerald-400 transition">➕ Tambah Pejabat</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-emerald-400 font-bold text-lg mb-4">🖼️ Galeri</h3>
                    <ul class="space-y-2">
                        <li><a href="gallery_manage.php" class="hover:text-emerald-400 transition">📋 Kelola Galeri</a></li>
                        <li><a href="add_gallery.php" class="hover:text-emerald-400 transition">➕ Tambah Foto</a></li>
                    </ul>
                </div>

                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-emerald-400 font-bold text-lg mb-4">⚙️ Pengaturan</h3>
                    <ul class="space-y-2">
                        <li><a href="users_manage.php" class="text-emerald-300 font-semibold">👤 Kelola Admin</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">👤 Kelola Akun Admin</h1>
                <p class="text-gray-600 mt-2">Kelola semua akun administrator Desa Saragi</p>
            </div>

            <!-- Message Alert -->
            <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <!-- Add Button -->
            <div class="mb-6">
                <a href="register.php" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition font-semibold">
                    ➕ Tambah Admin Baru
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <?php if (count($usersList) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-emerald-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Username</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Dibuat</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($usersList as $index => $user): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-800"><?php echo $index + 1; ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                    <?php if ($user['id'] === $_SESSION['admin_id']): ?>
                                        <span class="ml-2 text-xs bg-emerald-100 text-emerald-800 px-2 py-1 rounded">Anda</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo date('d M Y - H:i', strtotime($user['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($user['id'] !== $_SESSION['admin_id']): ?>
                                        <a href="?action=delete&id=<?php echo $user['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm" onclick="return confirm('Yakin ingin menghapus admin ini?');">
                                            🗑️ Hapus
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">Tidak bisa dihapus</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-8 text-center">
                    <p class="text-gray-600 text-lg">Belum ada akun admin. <a href="register.php" class="text-emerald-600 font-semibold hover:underline">Buat admin baru sekarang</a></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-sm text-blue-800">
                    <strong>💡 Tips:</strong> Anda tidak bisa menghapus akun sendiri (yang sedang login). Hanya admin lain yang bisa dihapus.
                </p>
            </div>
        </main>
    </div>
</body>
</html>
