<?php
/**
 * Desa Saragi - Gallery Management
 * Manage gallery photos
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
    $gallery_id = intval($_GET['id']);
    
    try {
        // Get image filename first
        $stmt = $conn->prepare("SELECT gambar FROM gallery WHERE id = ?");
        $stmt->execute([$gallery_id]);
        $gallery = $stmt->fetch();
        
        if ($gallery && !empty($gallery['gambar'])) {
            $image_path = '../uploads/' . $gallery['gambar'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        $deleteStmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $deleteStmt->execute([$gallery_id]);
        
        $message = 'Foto galeri berhasil dihapus!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'error';
    }
}

// Fetch all gallery images
try {
    $stmt = $conn->prepare("SELECT id, title, gambar, tanggal FROM gallery ORDER BY tanggal DESC");
    $stmt->execute();
    $galleryList = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = 'Database Error: ' . $e->getMessage();
    $message_type = 'error';
    $galleryList = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri - Desa Saragi Admin</title>
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
                        <li><a href="gallery_manage.php" class="text-emerald-300 font-semibold">📋 Kelola Galeri</a></li>
                        <li><a href="add_gallery.php" class="hover:text-emerald-400 transition">➕ Tambah Foto</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">🖼️ Kelola Galeri</h1>
                <p class="text-gray-600 mt-2">Kelola semua foto dalam galeri website</p>
            </div>

            <!-- Message Alert -->
            <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <!-- Add Button -->
            <div class="mb-6">
                <a href="add_gallery.php" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition font-semibold">
                    ➕ Tambah Foto Baru
                </a>
            </div>

            <!-- Gallery Grid -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <?php if (count($galleryList) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($galleryList as $gallery): ?>
                    <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            <?php if (!empty($gallery['gambar'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($gallery['gambar']); ?>" alt="<?php echo htmlspecialchars($gallery['title']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">Tidak ada gambar</div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">
                                <?php echo htmlspecialchars(substr($gallery['title'], 0, 50)); ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <?php echo date('d M Y', strtotime($gallery['tanggal'])); ?>
                            </p>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="edit_gallery.php?id=<?php echo $gallery['id']; ?>" class="flex-1 bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition text-sm text-center">
                                    ✏️ Edit
                                </a>
                                <a href="?action=delete&id=<?php echo $gallery['id']; ?>" class="flex-1 bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 transition text-sm text-center" onclick="return confirm('Yakin ingin menghapus foto ini?');">
                                    🗑️ Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="p-8 text-center">
                    <p class="text-gray-600 text-lg">Belum ada foto di galeri. <a href="add_gallery.php" class="text-emerald-600 font-semibold hover:underline">Tambah foto sekarang</a></p>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
