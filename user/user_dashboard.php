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

    <div class="flex justify-end">

        <div class="w-6 h-6 cursor-pointer">
        <a href="notification.php" class=""><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg></a>
            
        </div>

    </div>
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