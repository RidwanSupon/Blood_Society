<?php
session_start();
require_once '../includes/db_connect.php';

// Fetch all blood requests
$stmt = $conn->prepare("SELECT br.id, br.user_id, br.blood_group, br.status, u.username 
                        FROM blood_requests br
                        JOIN users u ON br.user_id = u.id");
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Approve a request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_request_id'])) {
    $request_id = $_POST['approve_request_id'];

    // Update the request status to 'Approved'
    $stmt = $conn->prepare("UPDATE blood_requests SET status = 'Approved' WHERE id = ?");
    $stmt->execute([$request_id]);

    // Notify the user (optional)
    // Decrease blood stock (handled during blood collection)

    $message = "Request approved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Admin - Blood Requests</title>

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
<body class="bg-gray-100 p-6">
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Blood Requests</h2>
        <?php if (isset($message)): ?>
            <p class="text-green-500 mb-2"><?php echo $message; ?></p>
        <?php endif; ?>

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Request ID</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Blood Group</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo $request['id']; ?></td>
                        <td class="border px-4 py-2"><?php echo $request['username']; ?></td>
                        <td class="border px-4 py-2"><?php echo $request['blood_group']; ?></td>
                        <td class="border px-4 py-2"><?php echo $request['status']; ?></td>
                        <td class="border px-4 py-2">
                            <?php if ($request['status'] == 'Pending'): ?>
                                <form method="POST">
                                    <input type="hidden" name="approve_request_id" value="<?php echo $request['id']; ?>">
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            <?php else: ?>
                                Approved
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
