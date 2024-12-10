<!-- Placeholder content for dashboard.php -->
<?php
session_start();
#if (!isset($_SESSION['admin_logged_in'])) {
 #   header('Location: login.php');
 #   exit;
#}
require_once '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Admin Dashboard</title>
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/5ed21b9157.js" crossorigin="anonymous"></script>

<!-- Daisy UI & Tailwind -->
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .font-manrope {
        font-family: 'Manrope', sans-serif;
    }
</style>
</head>
<body class="max-w-5xl mx-auto bg-gray-100  mt-0 md:mt-6 ">
    <div class="p-6">
        <a href=""><img src="../logo.png" alt="" class="w-full md:w-56"></a>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <a href="register_blood.php" class="btn btn-primary h-auto md:h-20 text-xl md:text-2xl text-yellow-50">Register Blood</a>
            <a href="b_segment.php" class="btn btn-secondary h-auto md:h-20 text-xl md:text-2xl text-yellow-50">View Blood List</a>
            <a href="exchange_blood.php" class="btn btn-accent h-auto md:h-20 text-xl md:text-2xl text-yellow-50">Handle Exchanges</a>
            <a href="available_blood.php" class="btn btn-warning h-auto md:h-20 text-xl md:text-2xl text-yellow-50">Check Stock</a>
            <a href="admin_blood_requests.php" class="btn btn-warning h-auto md:h-20 text-xl md:text-2xl text-yellow-50">Blood Request</a>
        </div>
        <div class="mt-6">
            <a href="logout.php" class="btn btn-error">Logout</a>
        </div>
    </div>
</body>
</html>
