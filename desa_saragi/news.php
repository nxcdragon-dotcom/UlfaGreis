<?php
/**
 * Desa Saragi - News Page
 * Display all news articles
 */
require_once 'config/db.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 6;
$offset = ($page - 1) * $itemsPerPage;

$news = [];
$totalNews = 0;
$db_error = '';

try {
    // Get total count of news
    $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM news");
    $countStmt->execute();
    $totalNews = $countStmt->fetch()['total'];
    
    // Get paginated news articles ordered by date (newest first)
    $stmt = $conn->prepare("SELECT id, title, content, image, date FROM news ORDER BY date DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $news = $stmt->fetchAll();
} catch (PDOException $e) {
    $db_error = "Database Error: " . $e->getMessage();
    error_log("News Query Error: " . $e->getMessage());
}

$totalPages = ceil($totalNews / $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Desa Saragi</title>
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
                    <a href="news.php" class="text-white bg-emerald-600 px-3 py-2 rounded transition">Berita</a>
                    <a href="officials.php" class="text-white hover:bg-emerald-600 px-3 py-2 rounded transition">Pejabat</a>
                    <a href="gallery.php" class="text-white hover:bg-emerald-600 px-3 py-2 rounded transition">Galeri</a>
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
                <a href="news.php" class="block text-white bg-emerald-600 px-3 py-2 rounded">Berita</a>
                <a href="officials.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Pejabat</a>
                <a href="gallery.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Galeri</a>
                <a href="admin/login.php" class="block bg-green-400 text-emerald-900 font-semibold px-3 py-2 rounded mt-2 text-center">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Berita Desa Saragi</h1>
            <p class="text-lg text-green-100">Informasi terbaru seputar kegiatan dan perkembangan desa kami</p>
        </div>
    </section>

    <!-- News Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <?php if (!empty($news)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <?php foreach ($news as $article): 
                        $imageUrl = !empty($article['image']) ? 'uploads/' . htmlspecialchars($article['image']) : 'https://via.placeholder.com/400x250/047857/ffffff?text=No+Image';
                        $date = date('d M Y', strtotime($article['date']));
                        $excerpt = substr(strip_tags($article['content']), 0, 120) . '...';
                    ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border border-gray-200">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <p class="text-gray-500 text-sm mb-2">📅 <?php echo $date; ?></p>
                                <h3 class="text-xl font-bold text-emerald-700 mb-3"><?php echo htmlspecialchars($article['title']); ?></h3>
                                <p class="text-gray-600 mb-4 text-sm"><?php echo htmlspecialchars($excerpt); ?></p>
                                <a href="news_detail.php?id=<?php echo $article['id']; ?>" class="text-green-500 font-semibold hover:text-emerald-700 transition inline-flex items-center">
                                    Baca Selengkapnya 
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php $totalPages = ceil($totalNews / $itemsPerPage); ?>
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center items-center space-x-2 mb-12">
                        <?php if ($page > 1): ?>
                            <a href="news.php?page=1" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">«</a>
                            <a href="news.php?page=<?php echo $page - 1; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">‹ Sebelumnya</a>
                        <?php endif; ?>

                        <span class="px-4 py-2 text-gray-700 font-semibold">
                            Halaman <?php echo $page; ?> dari <?php echo $totalPages; ?>
                        </span>

                        <?php if ($page < $totalPages): ?>
                            <a href="news.php?page=<?php echo $page + 1; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Berikutnya ›</a>
                            <a href="news.php?page=<?php echo $totalPages; ?>" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">»</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Belum Ada Berita -->
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Berita</h3>
                    <p class="text-gray-500">Silakan kunjungi kembali nanti untuk mendapatkan berita terbaru dari Desa Saragi.</p>
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
