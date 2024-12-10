<?php
session_start();
include('../includes/db.php'); // To connect to the database


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize input
        $email = mysqli_real_escape_string($conn, $email);

        // Query to check vendor login
        $sql = "SELECT * FROM vendors WHERE email = ?"; // Adjusted to `vendors` table

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $vendor = $result->fetch_assoc();

            // Check if vendor exists and password is correct
            if ($vendor && password_verify($password, $vendor['password'])) {
                // Set session variables for vendor
                $_SESSION['vendor_id'] = $vendor['vendor_id'];
                $_SESSION['email'] = $vendor['email'];
                header("Location: dashboard.php"); // Redirect to vendor dashboard
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Required fields are missing.";
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Login</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="vendor.css">
</head>
<body>
    <div class="login-container">
        <h2>Vendor Login</h2>
        <form action="login.php" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
    <div style="text-align: center; margin-top: 20px;">
    <a href="../index.php" class="btn btn-primary">Back to Home</a>
</div>
</form>


    </div>
</body>
</html>
