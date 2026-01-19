<?php
/**
 * Desa Saragi - Homepage
 * Main landing page with responsive design
 */
require_once 'config/database.php';

// Get the Database connection
try {
    $db = Database::getConnection();
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    $db = null;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Saragi - Desa Wisata Berkelanjutan</title>
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
                <a href="news.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Berita</a>
                <a href="officials.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Pejabat</a>
                <a href="gallery.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Galeri</a>
                <a href="admin/login.php" class="block bg-green-400 text-emerald-900 font-semibold px-3 py-2 rounded mt-2 text-center">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-96 md:h-[500px] bg-gradient-to-b from-emerald-700 to-emerald-600 flex items-center justify-center">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                Selamat Datang di Desa Saragi
            </h1>
            <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                Desa yang indah, asri, dan penuh dengan keramahan. Bergabunglah dengan kami dalam menjaga kelestarian alam dan budaya lokal.
            </p>
            <a href="#news" class="inline-block bg-green-400 text-emerald-900 font-bold px-8 py-3 rounded-lg hover:bg-green-300 transition transform hover:scale-105">
                Jelajahi Selengkapnya
            </a>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="news" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-emerald-700 mb-2">Berita Terbaru</h2>
                <div class="w-24 h-1 bg-green-400 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                if ($db) {
                    try {
                        $stmt = $db->prepare("SELECT id, title, content, image, created_at FROM news ORDER BY created_at DESC LIMIT 3");
                        $stmt->execute();
                        $news = $stmt->fetchAll();

                        if (!empty($news)) {
                            foreach ($news as $article):
                                $imageUrl = !empty($article['image']) ? 'uploads/' . htmlspecialchars($article['image']) : 'assets/images/placeholder.jpg';
                                $date = date('d M Y', strtotime($article['created_at']));
                                $excerpt = substr(strip_tags($article['content']), 0, 100) . '...';
                                ?>
                                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border border-gray-200">
                                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-48 object-cover">
                                    <div class="p-6">
                                        <p class="text-gray-500 text-sm mb-2"><?php echo $date; ?></p>
                                        <h3 class="text-xl font-bold text-emerald-700 mb-3"><?php echo htmlspecialchars($article['title']); ?></h3>
                                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($excerpt); ?></p>
                                        <a href="#" class="text-green-500 font-semibold hover:text-emerald-700 transition">Baca Selengkapnya →</a>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        } else {
                            echo '<p class="text-center text-gray-500 col-span-3">Belum ada berita. Silakan kunjungi kembali nanti.</p>';
                        }
                    } catch (Exception $e) {
                        echo '<p class="text-center text-red-500 col-span-3">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                } else {
                    echo '<p class="text-center text-gray-500 col-span-3">Database tidak tersedia.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Village Officials Section -->
    <section id="officials" class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-emerald-700 mb-2">Perangkat Desa</h2>
                <div class="w-24 h-1 bg-green-400 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                if ($db) {
                    try {
                        $stmt = $db->prepare("SELECT id, name, position, photo FROM officials ORDER BY position ASC");
                        $stmt->execute();
                        $officials = $stmt->fetchAll();

                        if (!empty($officials)) {
                            foreach ($officials as $official):
                                $photoUrl = !empty($official['photo']) ? 'uploads/' . htmlspecialchars($official['photo']) : 'assets/images/default-profile.jpg';
                                ?>
                                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition text-center p-6">
                                    <img src="<?php echo $photoUrl; ?>" alt="<?php echo htmlspecialchars($official['name']); ?>" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-emerald-200">
                                    <h3 class="text-lg font-bold text-emerald-700 mb-1"><?php echo htmlspecialchars($official['name']); ?></h3>
                                    <p class="text-gray-600 font-semibold text-sm"><?php echo htmlspecialchars($official['position']); ?></p>
                                </div>
                                <?php
                            endforeach;
                        } else {
                            echo '<p class="text-center text-gray-500 col-span-4">Belum ada data perangkat desa.</p>';
                        }
                    } catch (Exception $e) {
                        echo '<p class="text-center text-red-500 col-span-4">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                } else {
                    echo '<p class="text-center text-gray-500 col-span-4">Database tidak tersedia.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section (Placeholder) -->
    <section id="gallery" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-emerald-700 mb-2">Galeri Desa</h2>
                <div class="w-24 h-1 bg-green-400 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition h-64 bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center">
                        <p class="text-gray-600 font-semibold">Foto Galeri <?php echo $i; ?></p>
                    </div>
                <?php endfor; ?>
            </div>
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
                        <li><a href="#home" class="hover:text-green-300 transition">Beranda</a></li>
                        <li><a href="#news" class="hover:text-green-300 transition">Berita</a></li>
                        <li><a href="#officials" class="hover:text-green-300 transition">Perangkat Desa</a></li>
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

    <!-- Mobile Menu Toggle Script -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close menu when a link is clicked
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
