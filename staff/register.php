<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password

        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM staff WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            echo "Email is already registered. Please use a different email.";
        } else {
            // Insert new staff into the database
            $stmt = $conn->prepare("INSERT INTO staff (name, email, password, balance) VALUES (?, ?, ?, 200.00)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                echo "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                echo "Error: " . $conn->error;
            }

            $stmt->close();
        }
        $checkEmail->close();
    } else {
        echo "Please fill in all the required fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="staff.css">
</head>
<body>
    <div class="login-container">
        <h2>Staff Registration</h2>
        <form action="register.php" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <div style="text-align: center; margin-top: 20px;">
    <a href="../index.php" class="btn btn-primary">Back to Home</a>
</div>
    </div>
</body>
</html>
