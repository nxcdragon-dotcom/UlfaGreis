<?php
/**
 * Desa Saragi - Officials Page
 * Display all village officials and staff
 */
require_once 'config/database.php';

// Get the Database connection
try {
    $db = Database::getConnection();
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    $db = null;
}

$officials = [];

if ($db) {
    try {
        $stmt = $db->prepare("SELECT id, name, position, photo, bio FROM officials ORDER BY position ASC");
        $stmt->execute();
        $officials = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Query Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perangkat Desa - Desa Saragi</title>
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
                    <a href="officials.php" class="text-white bg-emerald-600 px-3 py-2 rounded transition">Pejabat</a>
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
                <a href="officials.php" class="block text-white bg-emerald-600 px-3 py-2 rounded">Pejabat</a>
                <a href="gallery.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded">Galeri</a>
                <a href="admin/login.php" class="block bg-green-400 text-emerald-900 font-semibold px-3 py-2 rounded mt-2 text-center">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Perangkat Desa Saragi</h1>
            <p class="text-lg text-green-100">Profil dan struktur organisasi pemerintahan desa kami</p>
        </div>
    </section>

    <!-- Officials Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <?php if ($db && !empty($officials)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php foreach ($officials as $official):
                        $photoUrl = !empty($official['photo']) ? 'uploads/' . htmlspecialchars($official['photo']) : 'assets/images/default-profile.jpg';
                        $bio = !empty($official['bio']) ? htmlspecialchars($official['bio']) : 'Perangkat desa yang berdedikasi untuk melayani masyarakat.';
                    ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden text-center group">
                            <div class="relative overflow-hidden h-64 bg-gradient-to-br from-emerald-100 to-green-100">
                                <img src="<?php echo $photoUrl; ?>" alt="<?php echo htmlspecialchars($official['name']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-emerald-700 mb-2"><?php echo htmlspecialchars($official['name']); ?></h3>
                                <p class="text-green-600 font-semibold text-sm mb-3 border-b-2 border-green-200 pb-3"><?php echo htmlspecialchars($official['position']); ?></p>
                                <p class="text-gray-600 text-sm"><?php echo $bio; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($db): ?>
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Data Perangkat</h3>
                    <p class="text-gray-500">Data perangkat desa belum tersedia. Silakan cek kembali nanti.</p>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-red-50 rounded-lg">
                    <p class="text-red-600 font-semibold">Database tidak tersedia. Silakan hubungi administrator.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Organizational Structure Info -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-700 mb-2">Struktur Organisasi</h2>
                <div class="w-24 h-1 bg-green-400 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-emerald-50 p-6 rounded-lg border-l-4 border-emerald-700">
                    <h3 class="text-xl font-bold text-emerald-700 mb-3">📋 Pemerintah Desa</h3>
                    <p class="text-gray-700">Pemerintah desa terdiri dari Kepala Desa dan Perangkat Desa yang mengelola aspek administrasi, pembangunan, dan kesejahteraan masyarakat desa.</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg border-l-4 border-green-700">
                    <h3 class="text-xl font-bold text-green-700 mb-3">👥 Badan Permusyawaratan Desa (BPD)</h3>
                    <p class="text-gray-700">BPD adalah lembaga perwakilan rakyat desa yang bertugas membuat peraturan desa dan mengawasi jalannya pemerintahan desa.</p>
                </div>
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
