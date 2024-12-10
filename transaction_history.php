<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/db.php');

$vendor_id = $_SESSION['vendor_id'];

$sql = "SELECT t.date, s.name AS staff_name, t.amount 
        FROM transactions t 
        JOIN staff s ON t.staff_id = s.staff_id 
        WHERE t.vendor_id = ? 
        ORDER BY t.date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendor_id);
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
    <link rel="stylesheet" href="vendor.css">
</head>
<body>
    <div class="history-container">
        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Staff Name</th>
                    <th>Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
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
