<?php
/**
 * Desa Cendana - Admin Logout
 * Clear session and redirect to login
 */
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Clear remember me cookie if exists
if (isset($_COOKIE['admin_username'])) {
    setcookie('admin_username', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: login.php?logged_out=1');
exit();
?>
