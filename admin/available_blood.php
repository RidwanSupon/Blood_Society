<!-- Placeholder content for available_blood.php -->
<?php
session_start();
#if (!isset($_SESSION['admin_logged_in'])) {
 #   header('Location: login.php');
  #  exit;
#}

require_once '../includes/db_connect.php';

// Fetch blood stock from both donors and exchanges
$query = "
    SELECT bg.blood_group,
           COALESCE(donor_count, 0) AS total_donations,
           COALESCE(exchange_taken_count, 0) AS total_exchanges_taken,
           COALESCE(exchange_given_count, 0) AS total_exchanges_given,
           (COALESCE(donor_count, 0) + COALESCE(exchange_given_count, 0) - COALESCE(exchange_taken_count, 0)) AS available_stock
    FROM (
        SELECT DISTINCT blood_group FROM blood_donors
        UNION
        SELECT DISTINCT blood_taken AS blood_group FROM blood_exchanges
        UNION
        SELECT DISTINCT blood_given AS blood_group FROM blood_exchanges
    ) bg
    LEFT JOIN (
        SELECT blood_group, COUNT(*) AS donor_count
        FROM blood_donors
        GROUP BY blood_group
    ) donors ON bg.blood_group = donors.blood_group
    LEFT JOIN (
        SELECT blood_taken AS blood_group, COUNT(*) AS exchange_taken_count
        FROM blood_exchanges
        GROUP BY blood_taken
    ) exchanges_taken ON bg.blood_group = exchanges_taken.blood_group
    LEFT JOIN (
        SELECT blood_given AS blood_group, COUNT(*) AS exchange_given_count
        FROM blood_exchanges
        GROUP BY blood_given
    ) exchanges_given ON bg.blood_group = exchanges_given.blood_group
    ORDER BY bg.blood_group;
";

$bloodStock = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Blood Stock</title>
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
<body class="mt-6">
    <div class="bg-gray-300 max-w-4xl mx-auto p-2 md:p-6 rounded-lg shadow-2xl ">
        
        <div class="flex flex-row justify-between items-center">

        <a href="../admin/dashboard.php"><img src="../logo.png" alt="" class="w-full md:w-56 -ml-2"></a>
        <h2 class="text-2xl font-bold">Stock Blood</h2>
        </div>
        
        <table class="table-auto w-full text-left border-collapse border border-gray-500">
            <thead>
                <tr>
                    <th class="px-4 py-2 border bg-red-600 text-slate-100 text-xl rounded-lg shadow-lg">Blood Group</th>
                    <th class="px-4 py-2 border bg-slate-600 text-slate-100 text-xl rounded-lg shadow-lg">Total Donations</th>
                    <th class="px-4 py-2 border bg-slate-600 text-slate-100 text-xl rounded-lg shadow-lg">Exchanges Taken</th>
                    <th class="px-4 py-2 border bg-slate-600 text-slate-100 text-xl rounded-lg shadow-lg">Exchanges Given</th>
                    <th class="px-4 py-2 border bg-green-600 text-slate-100 text-xl rounded-lg shadow-lg">Available Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bloodStock as $stock): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo $stock['blood_group']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $stock['total_donations']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $stock['total_exchanges_taken']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $stock['total_exchanges_given']; ?></td>
                        <td class="px-4 py-2 border text-xl font-bold"><?php echo $stock['available_stock']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
