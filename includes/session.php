<?php
// Start a session only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
