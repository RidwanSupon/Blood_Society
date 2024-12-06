<?php
session_start();

require_once '../includes/db_connect.php';

// Check if blood group is requested
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['blood_group_needed'])) {
    $blood_group_needed = $_POST['blood_group_needed'];

    // Check if the requested blood group is available in stock
    $stmt = $conn->prepare("SELECT * FROM blood_stock WHERE blood_group = :blood_group");
    $stmt->execute(['blood_group' => $blood_group_needed]);
    $bloodStock = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bloodStock && $bloodStock['quantity'] > 0) {
        // Blood is available, show the form to fill in exchange details
        $show_form = true;
    } else {
        $error = "The requested blood group is not available in stock.";
        $show_form = false;
    }
}

// Process the exchange form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['exchange_name'])) {
    $exchange_name = $_POST['exchange_name'];
    $contact_number = $_POST['contact_number'];
    $exchange_date = $_POST['exchange_date'];
    $blood_taken = $_POST['blood_taken'];
    $blood_given = $_POST['blood_given'];

    // Insert exchange details into the blood_exchanges table
    $stmt = $conn->prepare("INSERT INTO blood_exchanges (exchange_name, contact_number, exchange_date, blood_taken, blood_given) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$exchange_name, $contact_number, $exchange_date, $blood_taken, $blood_given]);

    // Update the blood stock: decrease taken blood group and increase given blood group
    $stmt = $conn->prepare("UPDATE blood_stock SET quantity = quantity - 1 WHERE blood_group = :blood_group");
    $stmt->execute(['blood_group' => $blood_taken]);

    $stmt = $conn->prepare("UPDATE blood_stock SET quantity = quantity + 1 WHERE blood_group = :blood_group");
    $stmt->execute(['blood_group' => $blood_given]);

    $message = "Blood exchange successfully recorded!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/tailwind.css" rel="stylesheet">
    <title>Blood Exchange</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5ed21b9157.js" crossorigin="anonymous"></script>
    <!-- Daisy UI & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="max-w-3xl mx-auto mt-6">
    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
        <a href="../admin/dashboard.php"><img src="../logo.png" alt="Logo" class="w-full md:w-56 -ml-2"></a>

        <?php if (isset($message)): ?>
            <p class="text-green-500 mb-2"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-2"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Check Blood Stock Form -->
        <?php if (!isset($show_form)): ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="blood_group_needed" class="block text-sm font-semibold text-gray-700">Blood Group Needed</label>
                    <select name="blood_group_needed" id="blood_group_needed" class="select select-bordered w-full mt-2" required>
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
                <button type="submit" class="btn btn-primary w-full">Check Blood Availability</button>
            </form>
        <?php endif; ?>

        <!-- Blood Exchange Form -->
        <?php if (isset($show_form) && $show_form): ?>
            <h3 class="text-xl font-semibold mb-4">Fill Exchange Details</h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="exchange_name" class="block text-sm font-semibold text-gray-700">Exchanger's Name</label>
                    <input type="text" name="exchange_name" id="exchange_name" class="input input-bordered w-full mt-2" required>
                </div>
                <div class="mb-4">
                    <label for="contact_number" class="block text-sm font-semibold text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="input input-bordered w-full mt-2" required>
                </div>
                <div class="mb-4">
                    <label for="exchange_date" class="block text-sm font-semibold text-gray-700">Exchange Date</label>
                    <input type="date" name="exchange_date" id="exchange_date" class="input input-bordered w-full mt-2" required>
                </div>
                <div class="mb-4">
                    <label for="blood_taken" class="block text-sm font-semibold text-gray-700">Blood Group Taken</label>
                    <select name="blood_taken" id="blood_taken" class="select select-bordered w-full mt-2" required>
                        <option value="<?php echo $blood_group_needed; ?>" selected><?php echo $blood_group_needed; ?></option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="blood_given" class="block text-sm font-semibold text-gray-700">Blood Group Given</label>
                    <select name="blood_given" id="blood_given" class="select select-bordered w-full mt-2" required>
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
                <button type="submit" class="btn btn-primary w-full">Record Exchange</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
