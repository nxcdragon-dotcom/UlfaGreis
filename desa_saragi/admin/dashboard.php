<?php
/**
 * Desa Saragi - Admin Dashboard
 * Main admin control panel
 */
session_start();

// Check if user is logged in - redirect to login if not
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Get database statistics
$newsCount = 0;
$officialsCount = 0;
$galleryCount = 0;

try {
    // Count news
    $newsStmt = $conn->prepare("SELECT COUNT(*) as count FROM news");
    $newsStmt->execute();
    $newsCount = $newsStmt->fetch()['count'];
    
    // Count officials
    $officialsStmt = $conn->prepare("SELECT COUNT(*) as count FROM officials");
    $officialsStmt->execute();
    $officialsCount = $officialsStmt->fetch()['count'];
    
    // Count gallery
    $galleryStmt = $conn->prepare("SELECT COUNT(*) as count FROM gallery");
    $galleryStmt->execute();
    $galleryCount = $galleryStmt->fetch()['count'];
    
} catch (PDOException $e) {
    error_log("Dashboard Query Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Desa Saragi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-emerald-700 shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
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
                <div class="text-center pb-4 border-b border-gray-700">
                    <h2 class="text-xl font-bold text-green-400">MENU</h2>
                </div>

                <nav class="space-y-3">
                    <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-2 bg-emerald-700 rounded hover:bg-emerald-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-4m0 0l4 4m-4-4V5"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="news_manage.php" class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-800 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v11m-9-10h.01M17 20h4a2 2 0 002-2v-4"></path>
                        </svg>
                        <span>Kelola Berita</span>
                    </a>
                    <a href="officials_manage.php" class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-800 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Kelola Pejabat</span>
                    </a>
                    <a href="gallery_manage.php" class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-800 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Kelola Galeri</span>
                    </a>
                    <a href="users_manage.php" class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-800 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </nav>

                <div class="border-t border-gray-700 pt-4">
                    <a href="logout.php" class="flex items-center space-x-3 px-4 py-2 text-red-400 hover:bg-red-900 hover:bg-opacity-30 rounded transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10">
            <!-- Welcome Section -->
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    Selamat Datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>! 👋
                </h1>
                <p class="text-gray-600">Kelola konten Desa Saragi dari sini</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- News Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">📰 BERITA</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2"><?php echo $newsCount; ?></p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="add_news.php" class="text-blue-500 font-semibold text-sm mt-4 inline-block hover:text-blue-700">Tambah Berita →</a>
                </div>

                <!-- Officials Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">👥 PEJABAT</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2"><?php echo $officialsCount; ?></p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="officials_manage.php" class="text-green-500 font-semibold text-sm mt-4 inline-block hover:text-green-700">Kelola Pejabat →</a>
                </div>

                <!-- Gallery Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">🖼️ GALERI</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2"><?php echo $galleryCount; ?></p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="gallery_manage.php" class="text-purple-500 font-semibold text-sm mt-4 inline-block hover:text-purple-700">Kelola Galeri →</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">⚡ Tindakan Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="news_manage.php?action=add" class="bg-blue-50 p-4 rounded-lg hover:bg-blue-100 transition text-center border border-blue-200">
                        <p class="text-4xl mb-2">📝</p>
                        <p class="font-semibold text-gray-700 text-sm">Tambah Berita</p>
                    </a>
                    <a href="officials_manage.php?action=add" class="bg-green-50 p-4 rounded-lg hover:bg-green-100 transition text-center border border-green-200">
                        <p class="text-4xl mb-2">➕</p>
                        <p class="font-semibold text-gray-700 text-sm">Tambah Pejabat</p>
                    </a>
                    <a href="gallery_manage.php?action=add" class="bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition text-center border border-purple-200">
                        <p class="text-4xl mb-2">📸</p>
                        <p class="font-semibold text-gray-700 text-sm">Unggah Foto</p>
                    </a>
                    <a href="../index.php" class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition text-center border border-gray-200">
                        <p class="text-4xl mb-2">🏠</p>
                        <p class="font-semibold text-gray-700 text-sm">Kunjungi Website</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
