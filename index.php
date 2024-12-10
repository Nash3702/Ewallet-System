<?php
// Start session to check if the user is already logged in
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Wallet System</title>
    <link rel="stylesheet" href="css/global.css"> <!-- Link to global CSS -->
    <link rel="stylesheet" href="css/index.css?v=1.1"> <!-- Versioned link to ensure fresh load -->
</head>
<body>
    <div class="main-container">
        <header>
            <h1>Welcome to E-Wallet System</h1>
            <p>Your digital wallet for staff, admin, and vendor management.</p>
        </header>

        <!-- Section for login options -->
        <section class="login-options">
            <div class="login-option">
                <h2>Admin Login</h2>
                <p>Access the admin panel to manage users and transactions.</p>
                <a href="admin/login.php" class="btn">Admin Login</a>
            </div>

            <div class="login-option">
                <h2>Staff Login</h2>
                <p>Manage your wallet and view balance.</p>
                <a href="staff/login.php" class="btn">Staff Login</a>
            </div>

            <div class="login-option">
                <h2>Vendor Login</h2>
                <p>Process transactions and view your history.</p>
                <a href="vendor/login.php" class="btn">Vendor Login</a>
            </div>
        </section>

        <!-- Staff Registration Section -->
        <section class="register-section">
            <h2>New Staff? Register Now</h2>
            <p>If you are a new staff member, click below to register.</p>
            <a href="staff/register.php" class="btn btn-register">Staff Registration</a>
        </section>

        <!-- Footer -->
        <footer>
            <p>&copy; 2024 E-Wallet System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
