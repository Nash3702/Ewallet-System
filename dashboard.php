<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/db.php');

// Fetching some basic vendor statistics for the dashboard
$vendor_id = $_SESSION['vendor_id'];
// Example query to get some vendor stats like total transactions and revenue (change this based on your database schema)
$result = $conn->query("SELECT COUNT(*) as total_transactions, SUM(amount) as total_revenue FROM transactions WHERE vendor_id = '$vendor_id'");
$stats = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="vendor_dashboard.css"> 

   
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['vendor_id']); ?>!</h1>
            <p>Your vendor dashboard is designed to give you quick access to all essential tools.</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="card">
                <h3>Total Transactions</h3>
                <p><?php echo htmlspecialchars($stats['total_transactions']); ?></p>
            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <p>RM <?php echo number_format($stats['total_revenue'], 2); ?></p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="nav-container">
            <nav>
                <ul>
                    <li><a href="process_transaction.php" class="nav-btn">Process Transaction</a></li>
                    <li><a href="transaction_history.php" class="nav-btn">Transaction History</a></li>
                    <li><a href="logout.php" class="nav-btn logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
