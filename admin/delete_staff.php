<?php
session_start();
include('../includes/db.php');

// Check if staff ID is provided for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];

    // Delete query
    $query = "DELETE FROM staff WHERE staff_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $staff_id);
    $stmt->execute();

    // Redirect back to manage staff
    header('Location: manage_staff.php');
    exit();
}
?>


<a href="delete_staff.php?staff_id=<?= $row['staff_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
