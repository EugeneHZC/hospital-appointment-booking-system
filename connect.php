<?php
$username = "han";
$password = "1234";
$hostname = "localhost";
$database = "azzahrah_appointment_system_db";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Failed to connect to database.");
}
?>