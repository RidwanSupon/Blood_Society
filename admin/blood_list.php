<?php
session_start();
#if (!isset($_SESSION['admin_logged_in'])) {
 #   header('Location: login.php');
  #  exit;
#}

require_once '../includes/db_connect.php';

// Fetch all blood donors
$donorsStmt = $conn->query("SELECT * FROM blood_donors");
$donors = $donorsStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Blood List</title>

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
<body class=" p-6">
    <div class="container mx-auto bg-gray-100 p-6 rounded-lg shadow-2xl">
        
    <a href="../admin/dashboard.php"><img src="../logo.png" alt="" class="w-full md:w-56 -ml-2"></a>

        <!-- Donors Table -->
        <h3 class="text-xl font-semibold mb-4">Blood Donors</h3>
        <table class="table-auto w-full text-left mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Donor ID</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Phone</th>
                    <th class="px-4 py-2 border">Blood Group</th>
                    <th class="px-4 py-2 border">Donation Date</th>
                    <th class="px-4 py-2 border">Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donors as $donor): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo $donor['id']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $donor['name']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $donor['phone']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $donor['blood_group']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $donor['donation_date']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $donor['address']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
