<?php
// Check if the user is an admin
function isAdmin($conn, $adminId) {
    $sql = "SELECT * FROM admins WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;  // Return true if admin exists
}

// Admin-specific actions (add/remove users, etc.)
function addUser($conn, $name, $email, $password) {
    // This function can be used for adding a user through the admin panel
    $hashedPassword = hashPassword($password);
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    $stmt->execute();
}
?>
