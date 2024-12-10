<?php
// Start session
session_start();

// Ensure the staff ID is stored in the session
if (!isset($_SESSION['staff_id'])) {
    die("Staff ID is not set in session. Please log in again.");
}

$staffId = $_SESSION['staff_id'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'e_wallet_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch staff data
$query = "SELECT * FROM staff WHERE staff_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $staffId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc(); // Fetch staff data as associative array
    } else {
        $staff = null; // No staff data found
    }

    $stmt->close();
} else {
    die("Query preparation failed: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="dashboard">
        <?php if ($staff): ?>
            <div class="welcome-message">Welcome, <?= htmlspecialchars($staff['name']) ?>!</div>
            <div class="balance">Your Balance: RM<?= number_format($staff['balance'], 2) ?></div>
        <?php else: ?>
            <div class="error-message">Unable to retrieve your information. Please contact support.</div>
        <?php endif; ?>
        <div class="buttons">
            <a href="transaction_history.php" class="btn">View Transaction History</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>

