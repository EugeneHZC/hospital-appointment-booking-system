<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    session_destroy();
    echo "
        <script>
            alert('Please login first.');
            window.location='../login/Login.php';
        </script>
        ";
}
?>