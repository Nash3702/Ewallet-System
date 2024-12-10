<?php
session_start();
include('../includes/db.php');// To connect to the database


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Check if email exists
        $sql = "SELECT * FROM staff WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for logged-in user
            $_SESSION['staff_id'] = $user['staff_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to staff dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="staff.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <div class="login-container">
        <h2>Staff Login</h2>
        <form action="login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn">Login</button>
             <div style="text-align: center; margin-top: 20px;">
    <a href="../index.php" class="btn btn-primary">Back to Home</a>
</div>
        </form>
    </div>
</body>
</html>
