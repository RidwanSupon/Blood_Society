<?php
session_start();
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password'=>$password]);
  
    $admin = $stmt->fetch(mode: PDO::FETCH_ASSOC);
   
    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        header('Location:dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Admin Login</title>
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
<body class="flex items-center justify-center rounded-xl mt-6 p-2">
    <form class="bg-gray-100 p-6 rounded shadow-md" method="POST">
    <div class="flex flex-col md:flex-row items-center justify-between">
    <a href=""><img src="../logo.png" alt="" class="w-full md:w-56 -mx-2 mb-6"></a>    
    <h2 class="text-2xl font-bold mb-4 overflow-x-hidden">Admin Login</h2>
    </div>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-2"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" class="input input-bordered w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="input input-bordered w-full mb-4" required>
        <button type="submit" class="btn btn-primary w-full">Login</button>
    </form>
</body>
</html>