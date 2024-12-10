<?php
session_start();
include('../includes/db.php');



if ($_SESSION['role'] != 'admin') {
    header("Location: ../error.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>Welcome, Admin!</h1>
            <p>Manage staff accounts or logout.</p>
        </div>

        <div class="dashboard-cards">
            <div class="card manage-staff">
                <i class="fas fa-user-cog"></i>
                <h2>Manage Staff</h2>
                <p>View and manage all staff accounts in the system.</p>
                <a href="manage_staff.php" class="btn">Go to Manage Staff</a>
            </div>

            <div class="card logout">
                <i class="fas fa-sign-out-alt"></i>
                <h2>Logout</h2>
                <p>Securely logout from the admin dashboard.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>