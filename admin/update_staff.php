<?php
session_start();
include('../includes/db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $balance = $_POST['balance'];

    // Update query
    $query = "UPDATE staff SET name = ?, email = ?, balance = ? WHERE staff_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssdi', $name, $email, $balance, $staff_id);
    $stmt->execute();

    // Redirect back to manage staff
    header('Location: manage_staff.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1>Update Staff</h1>
<a href="manage_staff.php" class="btn">Back to Manage Staff</a>

<form method="POST">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($staff['name']) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($staff['email']) ?>" required>

    <label for="balance">Balance</label>
    <input type="number" id="balance" name="balance" value="<?= htmlspecialchars($staff['balance']) ?>" required>

    <button type="submit" class="btn">Update</button>
</form>

</body>
</html>