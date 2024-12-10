<?php
// Validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);  // Check if the email format is valid
}

// Check if a string is empty
function isNotEmpty($value) {
    return !empty($value);  // Check if the input is not empty
}
?>
