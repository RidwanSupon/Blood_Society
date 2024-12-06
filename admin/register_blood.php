<?php
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $donation_date = $_POST['donation_date'];
    $blood_group = $_POST['blood_group'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO blood_donors (name, phone, donation_date, blood_group, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $donation_date, $blood_group, $address]);

    $updateStock = $conn->prepare("INSERT INTO blood_stock (blood_group, quantity) VALUES (?, 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1");
    $updateStock->execute([$blood_group]);

    $message = "Blood donor registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Register Blood</title>
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
<body class="max-w-3xl mx-auto bg-gray-100 md:p-6 mt-6 rounded-xl shadow-2xl">
    <form class="bg-white p-6 rounded shadow-md" method="POST">
        <a href="../admin/dashboard.php"><img src="../logo.png" alt="" class="w-full md:w-56 -ml-2 -mt-6"></a>
        <h2 class="text-2xl font-bold mb-4">Register Blood</h2>
        <?php if (isset($message)): ?>
            <p class="text-green-500 mb-2"><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="text" name="name" placeholder="Donor Name" class="input input-bordered w-full mb-4" required>
        <input type="text" name="phone" placeholder="Phone" class="input input-bordered w-full mb-4" required>
        <input type="date" name="donation_date" class="input input-bordered w-full mb-4" required>
        
        <!-- Dropdown for Blood Group -->
        <select name="blood_group" class="select select-bordered w-full mb-4" required>
            <option value="" disabled selected>Select Blood Group</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>

        <textarea name="address" placeholder="Address" class="textarea textarea-bordered w-full mb-4" required></textarea>
        <button type="submit" class="btn btn-primary w-full">Register</button>
    </form>
</body>
</html>
