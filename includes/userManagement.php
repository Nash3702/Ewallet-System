<?php
// Check if a user (vendor, admin, staff) exists by email/username
function checkUserExists($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";  // Change the table name if needed
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;  // Return true if user exists
}

// Register a new user
function registerUser($conn, $name, $email, $password) {
    $hashedPassword = hashPassword($password);
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    $stmt->execute();
    return $stmt->affected_rows > 0;  // Return true if the insertion is successful
}
?>
