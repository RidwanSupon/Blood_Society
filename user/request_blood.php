<?php
session_start();
require_once '../includes/db_connect.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $error = "User is not logged in.";
    } else {
        $blood_group = $_POST['blood_group'];
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

        // Check if blood is available in stock
        $stmt = $conn->prepare("SELECT * FROM blood_stock WHERE blood_group = :blood_group");
        $stmt->execute(['blood_group' => $blood_group]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stock && $stock['quantity'] > 0) {
            // Add request to the database
            $stmt = $conn->prepare("INSERT INTO blood_requests (user_id, blood_group, status) VALUES (?, ?, ?)");
            if ($stmt->execute([$user_id, $blood_group, 'Pending'])) {
                $message = "Your blood request has been submitted. Please wait for admin approval.";
            } else {
                $error = "Error inserting the blood request.";
                print_r($stmt->errorInfo()); // Display detailed error info
            }
        } else {
            $error = "Sorry, the requested blood group is not available.";
        }
    }
}
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
</head>
<body class="bg-gray-100 p-6 ">
    <form class="max-w-3xl mx-auto bg-gray-100 md:p-6 mt-6 rounded-xl shadow-2xl" method="POST">
        <h2 class="text-2xl font-bold mb-4">Request Blood</h2>
        <?php if (isset($message)): ?>
            <p class="text-green-500 mb-2"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-2"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Blood Group Dropdown -->
        <div class="mb-4">
            <label for="blood_group" class="block text-sm font-semibold text-gray-700">Select Blood Group</label>
            <select name="blood_group" id="blood_group" class="select select-bordered w-full mt-2" required>
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
        </div>

        <button type="submit" class="btn btn-primary w-full">Request Blood</button>
    </form>
</body>
</html>
