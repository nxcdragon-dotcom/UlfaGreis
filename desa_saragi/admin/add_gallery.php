<?php
/**
 * Desa Saragi - Add Gallery Page
 * Admin interface to add new gallery photos
 */
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include '../config/db.php';

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    
    // Validation
    if (empty($title)) {
        $message = 'Judul foto harus diisi!';
        $message_type = 'error';
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $message = 'Silakan pilih file gambar!';
        $message_type = 'error';
    } else {
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
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file_type, $allowed_types)) {
            $message = 'Tipe file tidak diperbolehkan! Gunakan JPG, PNG, GIF, atau WebP.';
            $message_type = 'error';
        } elseif ($file_size > 5 * 1024 * 1024) {
            // 5MB max
            $message = 'Ukuran file terlalu besar! Maksimal 5MB.';
            $message_type = 'error';
        } else {
            // Create unique filename
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $image_filename = time() . '_' . uniqid() . '.' . $file_ext;
            
            if (move_uploaded_file($file_tmp, $upload_dir . $image_filename)) {
                // File moved successfully, save to database
                try {
                    $stmt = $conn->prepare("INSERT INTO gallery (title, gambar) VALUES (?, ?)");
                    $stmt->execute([$title, $image_filename]);
                    
                    $message = 'Foto berhasil ditambahkan ke galeri!';
                    $message_type = 'success';
                    
                    // Redirect after 2 seconds
                    header('Refresh: 2; url=gallery_manage.php');
                } catch (PDOException $e) {
                    $message = 'Error: ' . $e->getMessage();
                    $message_type = 'error';
                }
            } else {
                $message = 'Gagal mengupload file!';
                $message_type = 'error';
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
    <title>Tambah Foto - Admin Desa Saragi</title>
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

    <!-- Main Content -->
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">➕ Tambah Foto Galeri</h1>
            <p class="text-gray-600 mt-2">Tambahkan foto baru ke galeri website</p>
        </div>

        <!-- Message Alert -->
        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8">
            <!-- Judul Foto -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    📝 Judul Foto
                </label>
                <input 
                    type="text" 
                    id="title"
                    name="title" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600"
                    placeholder="Contoh: Acara Bersih-bersih Desa 2024"
                    required
                >
            </div>

            <!-- Upload Foto -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    📷 Upload Foto
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-600 transition"
                     onclick="document.getElementById('image').click()"
                     id="drop-zone">
                    <input 
                        type="file" 
                        id="image"
                        name="image" 
                        class="hidden"
                        accept="image/*"
                        required
                    >
                    <div id="image-preview" class="text-gray-500">
                        <p class="text-2xl mb-2">📁</p>
                        <p class="text-lg font-semibold mb-1">Klik untuk memilih foto</p>
                        <p class="text-sm">atau drag & drop gambar ke sini</p>
                        <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF, WebP - Max 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition font-semibold"
                >
                    ✅ Tambah Foto
                </button>
                <a 
                    href="gallery_manage.php" 
                    class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold text-center"
                >
                    ❌ Batal
                </a>
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <p class="text-sm text-blue-800">
                <strong>💡 Tips:</strong> Gunakan foto berkualitas tinggi dengan resolusi minimal 800x600 pixel untuk hasil terbaik di galeri.
            </p>
        </div>
    </div>

    <!-- Image Preview & Drag-Drop Script -->
    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('image');
        const preview = document.getElementById('image-preview');

        // Click to upload
        fileInput.addEventListener('change', handleFileSelect);

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-emerald-600', 'bg-emerald-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-emerald-600', 'bg-emerald-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-emerald-600', 'bg-emerald-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect();
            }
        });

        function handleFileSelect() {
            const file = fileInput.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `
                        <img src="${event.target.result}" class="max-h-64 mx-auto mb-4 rounded">
                        <div class="text-left inline-block">
                            <p class="text-sm text-emerald-600">✅ File dipilih</p>
                            <p class="text-sm text-gray-600"><strong>${file.name}</strong></p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
