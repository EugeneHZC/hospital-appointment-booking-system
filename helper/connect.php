<?php
$username = "han";
$password = "1234";
$hostname = "localhost";
$database = "azzahrah_appointment_system_db";
$port = "3302";

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Failed to connect to database. Error: $conn->error");
}
?>