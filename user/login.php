<?php
session_start(); 
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password'=>$password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] =$user['id'];
        header('Location: user_dashboard.php');
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
    <title>User Login</title>
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
<body class="max-w-3xl mx-auto flex items-center justify-center">

    <form class="bg-gray-100 p-6 rounded shadow-md mt-6" method="POST">
        <div class="flex flex-row items-center justify-between">
            <a href=""><img src="../logo.png" alt="" class="w-full md:w-56 "></a>
        <h2 class="text-2xl font-bold mb-4">User Login</h2></div>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-2"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" class="input input-bordered w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="input input-bordered w-full mb-4" required>
        <button type="submit" class="btn btn-primary w-full">Login</button>
        <button class="btn bg-orange-400 mt-3 w-auto"><a href="../index.php">Select Role</a></button>
    </form>
</body>
</html>