<?php
/**
 * Desa Saragi - News Detail Page
 * Display full news article
 */
require_once 'config/db.php';

$article = null;
$db_error = '';
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    header('Location: news.php');
    exit();
}

try {
    // Get the news article by ID
    $stmt = $conn->prepare("SELECT id, title, content, image, date FROM news WHERE id = ?");
    $stmt->execute([$article_id]);
    $article = $stmt->fetch();
    
    // If article not found, redirect to news page
    if (!$article) {
        header('Location: news.php');
        exit();
    }
} catch (PDOException $e) {
    $db_error = "Database Error: " . $e->getMessage();
    error_log("News Detail Query Error: " . $e->getMessage());
}

$imageUrl = !empty($article['image']) ? 'uploads/' . htmlspecialchars($article['image']) : 'https://via.placeholder.com/800x400/047857/ffffff?text=No+Image';
$date = date('d M Y', strtotime($article['date']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title'] ?? 'Berita'); ?> - Desa Saragi</title>
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
        <div class="max-w-4xl mx-auto px-4">
            <a href="news.php" class="text-green-100 hover:text-white mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Berita
            </a>
            <h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo htmlspecialchars($article['title']); ?></h1>
            <p class="text-green-100 text-lg">📅 <?php echo $date; ?></p>
        </div>
    </section>

    <!-- Article Content -->
    <article class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Article Image -->
            <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-96 object-cover">
            </div>

            <!-- Article Text -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <div class="prose prose-emerald max-w-none">
                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>
            </div>

            <!-- Back to News Button -->
            <div class="flex justify-center">
                <a href="news.php" class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </article>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="mb-2">&copy; 2024 Desa Saragi. Semua Hak Dilindungi.</p>
            <p class="text-green-300">Dibangun dengan ❤️ untuk komunitas desa</p>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
