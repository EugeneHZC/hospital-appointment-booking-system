<?php

// the letters heading for ID generation for each table
// e.g. appointment table will have ID of AP001 etc.
$lettersHeading = [
    "appointment" => "AP",
    "time_slot" => "TS",
    "staff" => "S",
    "article" => "A",
    "patient" => "P",
    "department" => "D"
];

function generateId(string $tableName, int $stringHeadNum, int $stringTailNum)
{
    // get access to the letters heading array outside this function
    global $lettersHeading, $conn;

    // get the last row of record from the database table
    $sql = "SELECT * FROM $tableName ORDER BY " . $tableName . "_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if (!$result) {
        die("Failed to fetch data from $tableName to generate ID. Error: $conn->error");
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // retrieve the last row's ID
        $lastId = $row[$tableName . "_id"];

        // get the letters in the ID (e.g. AP001 -> AP)
        $stringHead = $lettersHeading[$tableName];

        // get the numbers in the ID (e.g. AP001 -> 001) and convert to int
        $lastNo = (int) substr($lastId, $stringHeadNum, $stringTailNum);

        // increment the number
        $lastNo++;

        // join the letters and the number with 0 padding in front (e.g. AP + 2 -> AP002)
        $updatedIdString = $stringHead . str_pad($lastNo, $stringTailNum, "0", STR_PAD_LEFT);
    } else {
        // if table is empty
        // generate a new id starting from 1 (e.g. AP001)
        $updatedIdString = $lettersHeading[$tableName] . str_pad("1", $stringTailNum, "0", STR_PAD_LEFT);
    }

    return $updatedIdString;
}
?>