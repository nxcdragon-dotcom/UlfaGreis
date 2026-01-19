<?php
/**
 * Desa Saragi - Officials Management
 * Manage village officials/staff
 */
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include '../config/db.php';

$message = '';
$message_type = 'success';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $official_id = intval($_GET['id']);
    
    try {
        $deleteStmt = $conn->prepare("DELETE FROM officials WHERE id = ?");
        $deleteStmt->execute([$official_id]);
        
        $message = 'Pejabat berhasil dihapus!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'error';
    }
}

// Fetch all officials
try {
    $stmt = $conn->prepare("SELECT id, nama, posisi, foto FROM officials ORDER BY posisi ASC");
    $stmt->execute();
    $officialsList = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = 'Database Error: ' . $e->getMessage();
    $message_type = 'error';
    $officialsList = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pejabat - Desa Saragi Admin</title>
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
                        <li><a href="officials_manage.php" class="text-emerald-300 font-semibold">📋 Kelola Pejabat</a></li>
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
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">👥 Kelola Pejabat</h1>
                <p class="text-gray-600 mt-2">Kelola semua data pejabat/staff desa</p>
            </div>

            <!-- Message Alert -->
            <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <!-- Add Button -->
            <div class="mb-6">
                <a href="add_officials.php" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition font-semibold">
                    ➕ Tambah Pejabat Baru
                </a>
            </div>

            <!-- Officials Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <?php if (count($officialsList) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-emerald-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Posisi</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Foto</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($officialsList as $index => $official): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-800"><?php echo $index + 1; ?></td>
                                <td class="px-6 py-4 text-gray-800 font-medium">
                                    <?php echo htmlspecialchars($official['nama']); ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo htmlspecialchars($official['posisi']); ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php if (!empty($official['foto'])): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($official['foto']); ?>" alt="Foto" class="w-12 h-12 object-cover rounded">
                                    <?php else: ?>
                                        <span class="text-gray-400">Tidak ada foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="edit_officials.php?id=<?php echo $official['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition text-sm">
                                            ✏️ Edit
                                        </a>
                                        <a href="?action=delete&id=<?php echo $official['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm" onclick="return confirm('Yakin ingin menghapus pejabat ini?');">
                                            🗑️ Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-8 text-center">
                    <p class="text-gray-600 text-lg">Belum ada data pejabat. <a href="add_officials.php" class="text-emerald-600 font-semibold hover:underline">Tambah pejabat sekarang</a></p>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
