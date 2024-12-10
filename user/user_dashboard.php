<!-- Placeholder content for user_dashboard.php -->
<?php
session_start();
require_once '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>User Dashboard</title>
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
<body class="max-w-2xl mx-auto md:rounded-xl shadow-2xl bg-gray-300 md:mt-6 p-6">
    <div class="flex flex-col md:flex-row justify-between items-center">

    <a href="../admin/dashboard.php"><img src="../logo.png" alt="" class="w-full md:w-56 -ml-2"></a>
    <h2 class="text-3xl font-bold">Stock Blood</h2>
    </div>


    <div class="grid grid-cols-1 gap-4 mt-6">
        
        <a href="request_blood.php" class="btn btn-primary">Request Blood</a>
        <a href="logout.php" class="btn btn-error">Logout</a>
    </div>
</body>
</html>
