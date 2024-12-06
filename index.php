<!-- Placeholder content for index.php -->
<?php
// Start session
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin/dashboard.php');
    exit;
} elseif (isset($_SESSION['user_logged_in'])) {
    header('Location: user/user_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/tailwind.css" rel="stylesheet">
    <title>Blood Bank Management System</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Blood Bank Management System</h1>
        <div class="mt-6">
            <a href="admin/login.php" class="btn btn-primary mx-2">Admin Login</a>
            <a href="user/login.php" class="btn btn-secondary mx-2">User Login</a>
        </div>
    </div>
</body>
</html>
