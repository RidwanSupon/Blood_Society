<?php
session_start();
require_once '../includes/db_connect.php';

// Fetch all blood requests

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM `blood_requests` WHERE  user_id =$user_id  ");
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Request Blood</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5ed21b9157.js" crossorigin="anonymous"></script>
    <!-- Daisy UI & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    </style>

</head>

<body class="bg-gray-100 p-6 max-w-3xl mx-auto mt-5">
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Notification</h2>


        <table class="table-auto w-full">
            <thead>
                <tr>
                   
                    <th class="px-4 py-2">Blood Group</th>
                    <th class="px-4 py-2">Status</th>
              
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        
                        <td class="border px-4 py-2"><?php echo $request['blood_group']; ?></td>
                        <td class="border px-4 py-2"><?php echo $request['status']; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>