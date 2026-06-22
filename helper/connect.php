<?php
$username = "Haziq";
$password = "12345";
$hostname = "localhost";
$database = "azzahrah_appointment_system_db";
$port = "3306";

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Failed to connect to database. Error: $conn->error");
}
?>