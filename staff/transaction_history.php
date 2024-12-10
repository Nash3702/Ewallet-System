<?php
session_start();
include('../includes/db.php');

// Restrict access to logged-in staff
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];

// Fetch transaction history for the logged-in staff
$sql = "SELECT * FROM transactions WHERE staff_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="container">
        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Vendor</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['vendor_id']; ?></td>
                        <td>RM<?php echo number_format($row['amount'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
                <button onclick="window.history.back();" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Go Back
</button>
            </tbody>
        </table>
    </div>
</body>
</html>

