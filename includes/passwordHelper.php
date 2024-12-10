<?php
// Hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);  // Hash the password using bcrypt
}

// Verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);  // Verify password against stored hash
}
?>
