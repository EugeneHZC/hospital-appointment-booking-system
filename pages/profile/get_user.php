<?php
include('../../helper/connect.php');

function validateUnique(string $tableName, string $columnName, string $value)
{
    global $conn;

    $email = $_SESSION["email"];

    // get user
    $stmt = $conn->prepare("SELECT * FROM $tableName WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM $tableName WHERE $columnName = ? AND " . $tableName . "_id != ?");
    $stmt->bind_param("ss", $value, $user[$tableName . "_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return false;
    }

    return true;
}
?>