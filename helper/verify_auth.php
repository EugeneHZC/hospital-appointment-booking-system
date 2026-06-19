<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    session_destroy();
    echo "<meta http-equiv='refresh' content='3;URL=../login/Login.php' />";
    die("Please login first.");
}
?>