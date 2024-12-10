<?php
// Redirect function
function redirectTo($url) {
    header("Location: " . $url);
    exit();
}
?>
