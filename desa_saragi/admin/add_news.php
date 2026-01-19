<?php
/**
 * Desa Saragi - Add News Page
 * Admin interface to add new news articles with image upload
 */
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../config/db.php';

$message = '';
$messageType = ''; // 'success' or 'error'

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    // Validate inputs
    if (empty($title)) {
        $message = 'Judul berita harus diisi!';
        $messageType = 'error';
    } elseif (empty($content)) {
        $message = 'Isi berita harus diisi!';
        $messageType = 'error';
    } else {
        $image_filename = '';
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/';
            
            // Create uploads directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Get file info
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_type = $_FILES['image']['type'];
            
            // Validate file type (only allow images)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file_type, $allowed_types)) {
                $message = 'Format file tidak didukung! Gunakan JPG, PNG, GIF, atau WebP.';
                $messageType = 'error';
            } else if ($file_size > 5 * 1024 * 1024) { // 5MB max
                $message = 'Ukuran file terlalu besar! Maksimal 5MB.';
                $messageType = 'error';
            } else {
                // Generate unique filename
                $image_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file_name);
                $target_file = $upload_dir . $image_filename;
                
                // Move uploaded file
                if (!move_uploaded_file($file_tmp, $target_file)) {
                    $message = 'Gagal mengunggah gambar. Pastikan folder uploads/ sudah ada dan dapat ditulis.';
                    $messageType = 'error';
                    $image_filename = ''; // Reset if upload fails
                }
            }
        }
        
        // If no errors, insert into database
        if ($messageType !== 'error') {
            try {
                $sql = "INSERT INTO news (Judul, kontak, gambar) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $title,
                    $content,
                    $image_filename // Will be empty string if no image uploaded
                ]);
                
                $message = 'Berita berhasil ditambahkan!';
                $messageType = 'success';
                
                // Clear form
                $_POST = [];
            } catch (PDOException $e) {
                $message = 'Error: ' . $e->getMessage();
                $messageType = 'error';
                error_log("Add News Error: " . $e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Admin Desa Saragi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-emerald-700 shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-green-300 rounded-full flex items-center justify-center font-bold text-emerald-900">
                        🌿
                    </div>
                    <span class="text-white font-bold text-xl">Desa Saragi - Admin</span>
                </div>
                <a href="dashboard.php" class="text-white hover:bg-emerald-600 px-4 py-2 rounded transition">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Tambah Berita Baru</h1>
            <p class="text-green-100">Bagikan informasi terbaru kepada masyarakat Desa Saragi</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Success/Error Message -->
            <?php if (!empty($message)): ?>
                <div class="mb-6 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-100 border-l-4 border-green-500 text-green-700' : 'bg-red-100 border-l-4 border-red-500 text-red-700'; ?>">
                    <p class="font-semibold">
                        <?php echo $messageType === 'success' ? '✅ ' : '❌ '; ?>
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-lg font-semibold text-gray-700 mb-2">
                            📝 Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                            placeholder="Masukkan judul berita yang menarik..."
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                            required
                        >
                        <p class="text-sm text-gray-500 mt-1">Min. 5 karakter untuk judul yang baik</p>
                    </div>

                    <!-- Content Field -->
                    <div>
                        <label for="content" class="block text-lg font-semibold text-gray-700 mb-2">
                            📄 Isi Berita <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="10"
                            placeholder="Tulis isi berita di sini... Kamu bisa menulis dalam beberapa paragraf."
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition font-mono"
                            required
                        ><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                        <p class="text-sm text-gray-500 mt-1">Gunakan baris baru untuk paragraf yang berbeda</p>
                    </div>

                    <!-- Image Upload Field -->
                    <div>
                        <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">
                            🖼️ Gambar Berita <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-500 transition">
                            <input 
                                type="file" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                                class="hidden"
                                onchange="displayFileName(this)"
                            >
                            <label for="image" class="cursor-pointer block">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-600 font-semibold">Klik atau drag gambar ke sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 5MB)</p>
                            </label>
                            <p id="fileName" class="text-sm text-emerald-600 font-semibold mt-2"></p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-6 border-t-2 border-gray-200">
                        <button 
                            type="submit" 
                            class="flex-1 bg-emerald-600 text-white font-bold py-3 rounded-lg hover:bg-emerald-700 transition inline-flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Simpan Berita
                        </button>
                        <a 
                            href="dashboard.php" 
                            class="flex-1 bg-gray-500 text-white font-bold py-3 rounded-lg hover:bg-gray-600 transition text-center inline-flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                <h3 class="font-bold text-blue-900 mb-2">💡 Tips Menulis Berita yang Baik</h3>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Gunakan judul yang menarik dan deskriptif</li>
                    <li>Mulai dengan paragraf pembuka yang kuat</li>
                    <li>Gunakan bahasa yang jelas dan mudah dipahami</li>
                    <li>Sertakan gambar untuk membuat berita lebih menarik</li>
                    <li>Proofread sebelum mempublikasikan</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-gray-100 py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; 2026 Desa Saragi. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Display selected filename
        function displayFileName(input) {
            const fileNameDisplay = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = '✅ ' + input.files[0].name + ' (' + 
                    (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
            } else {
                fileNameDisplay.textContent = '';
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('[for="image"]').parentElement;
        const fileInput = document.getElementById('image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-emerald-500', 'bg-emerald-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            displayFileName(fileInput);
        }
    </script>
</body>
</html>
