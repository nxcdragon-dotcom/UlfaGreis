<?php
/**
 * Desa Saragi - Gallery Page
 * Display photo gallery of village activities
 */
require_once 'config/database.php';

// Get the Database connection
try {
    $db = Database::getConnection();
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    $db = null;
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 12;
$offset = ($page - 1) * $itemsPerPage;

$gallery = [];
$totalGallery = 0;

if ($db) {
    try {
        // Get total count
        $countStmt = $db->prepare("SELECT COUNT(*) as total FROM gallery");
        $countStmt->execute();
        $totalGallery = $countStmt->fetch()['total'];
        
        // Get paginated gallery
        $stmt = $db->prepare("SELECT id, title, image, description, created_at FROM gallery ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $gallery = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Query Error: " . $e->getMessage());
    }
}

$totalPages = $totalGallery > 0 ? ceil($totalGallery / $itemsPerPage) : 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Desa Saragi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-emerald-700 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-green-300 rounded-full flex items-center justify-center font-bold text-emerald-900">
                        🌿
                    </div>
                    <span class="text-white font-bold text-xl hidden sm:inline">Desa Saragi</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    <a href="index.php" class="text-white hover:bg-emerald-600 px-3 py-2 rounded transition">Home</a>
                    <a href="news.php" class="text-white hover:bg-emerald-600 px-3 py-2 rounded transition">Berita</a>
                    <a href="officials.php" class="text-white hover:bg-emerald-600 px-3 py-2 rounded transition">Pejabat</a>
                    <a href="gallery.php" class="text-white bg-emerald-600 px-3 py-2 rounded transition">Galeri</a>
                    <a href="admin/login.php" class="bg-green-400 text-emerald-900 font-semibold px-4 py-2 rounded hover:bg-green-300 transition">Login Admin</a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="menuBtn" class="md:hidden text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="index.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Home</a>
                <a href="news.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Berita</a>
                <a href="officials.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Pejabat</a>
                <a href="gallery.php" class="block text-white bg-emerald-600 px-3 py-2 rounded">Galeri</a>
                <a href="admin/login.php" class="block bg-green-400 text-emerald-900 font-semibold px-3 py-2 rounded mt-2 text-center">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Galeri Desa Saragi</h1>
            <p class="text-lg text-green-100">Dokumentasi kegiatan dan momen berharga dari Desa Saragi</p>
        </div>
    </section>

    <!-- Gallery Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <?php if ($db && !empty($gallery)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
                    <?php foreach ($gallery as $item): 
                        $imageUrl = !empty($item['image']) ? 'uploads/' . htmlspecialchars($item['image']) : 'assets/images/placeholder.jpg';
                        $date = date('d M Y', strtotime($item['created_at']));
                    ?>
                        <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition h-64 cursor-pointer">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                                <h3 class="text-white font-bold text-lg"><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p class="text-gray-200 text-sm"><?php echo $date; ?></p>
                                <?php if (!empty($item['description'])): ?>
                                    <p class="text-gray-300 text-xs mt-2 line-clamp-2"><?php echo htmlspecialchars($item['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center items-center space-x-2 mb-12">
                        <?php if ($page > 1): ?>
                            <a href="gallery.php?page=1" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">«</a>
                            <a href="gallery.php?page=<?php echo $page - 1; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">‹ Sebelumnya</a>
                        <?php endif; ?>

                        <span class="px-4 py-2 text-gray-700 font-semibold">
                            Halaman <?php echo $page; ?> dari <?php echo $totalPages; ?>
                        </span>

                        <?php if ($page < $totalPages): ?>
                            <a href="gallery.php?page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Berikutnya ›</a>
                            <a href="gallery.php?page=<?php echo $totalPages; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">»</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php elseif ($db): ?>
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Foto</h3>
                    <p class="text-gray-500">Galeri masih kosong. Silakan kunjungi kembali nanti untuk melihat foto-foto kegiatan desa kami.</p>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-red-50 rounded-lg">
                    <p class="text-red-600 font-semibold">Database tidak tersedia. Silakan hubungi administrator.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-gray-100 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h4 class="text-lg font-bold text-green-300 mb-4">Tentang Desa Saragi</h4>
                    <p class="text-sm text-gray-300">
                        Desa Saragi adalah sebuah desa yang berkomitmen untuk menjaga kelestarian alam dan mengembangkan potensi lokal secara berkelanjutan.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold text-green-300 mb-4">Link Cepat</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="index.php" class="hover:text-green-300 transition">Beranda</a></li>
                        <li><a href="news.php" class="hover:text-green-300 transition">Berita</a></li>
                        <li><a href="officials.php" class="hover:text-green-300 transition">Perangkat Desa</a></li>
                        <li><a href="admin/login.php" class="hover:text-green-300 transition">Admin Panel</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold text-green-300 mb-4">Kontak</h4>
                    <p class="text-sm mb-2">
                        <strong>Alamat:</strong><br>
                        Desa Saragi, Jawa Barat
                    </p>
                    <p class="text-sm">
                        <strong>Email:</strong> info@desacendana.id<br>
                        <strong>Telepon:</strong> +62 XXX XXXX XXXX
                    </p>
                </div>
            </div>

            <div class="border-t border-emerald-800 pt-8">
                <p class="text-center text-sm text-gray-400">
                    &copy; 2026 Desa Saragi. Semua hak dilindungi. | Dikembangkan dengan ❤️
                </p>
            </div>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
