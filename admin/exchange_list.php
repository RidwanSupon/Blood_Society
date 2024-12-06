<?php
session_start();
#if (!isset($_SESSION['admin_logged_in'])) {
 #   header('Location: login.php');
  #  exit;
#}

require_once '../includes/db_connect.php';

// Fetch all blood exchanges
$exchangesStmt = $conn->query("SELECT * FROM blood_exchanges");
$exchanges = $exchangesStmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<body class=" container mx-auto mt-0 md:mt-6 p-6 bg-gray-100 rounded-lg shadow-2xl">
<a href="../admin/dashboard.php"><img src="../logo.png" alt="" class="w-full md:w-56 -ml-2"></a>
<h3 class="text-xl font-semibold mb-4 mt-4">Blood Exchanges</h3>
        <table class="table-auto w-full text-left mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Exchange ID</th>
                    <th class="px-4 py-2 border">Exchanger's Name</th>
                    <th class="px-4 py-2 border">Contact Number</th>
                    <th class="px-4 py-2 border">Blood Taken</th>
                    <th class="px-4 py-2 border">Blood Given</th>
                   <!-- <th class="px-4 py-2 border">Exchange Date</th>-->
                    <th class="px-4 py-2 border">Time & Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exchanges as $exchange): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo $exchange['id']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $exchange['exchange_name']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $exchange['contact_number']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $exchange['blood_taken']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $exchange['blood_given']; ?></td>
                <!--<td class="px-4 py-2 border"><?php echo $exchange['exchange_date']; ?></td> -->
                        <td class="px-4 py-2 border"><?php echo $exchange['exchange_timestamp']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</body>
</html>