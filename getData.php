<?php
// Connect to SQLite database
$db = new SQLite3('db/myTestDB.db'); // Replace with your database name

if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

// Retrieve data from the table
$query = "SELECT * FROM usertable";
$result = $db->query($query);
$data = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

// Close the database connection
$db->close();

// Send data as JSON response
header("Content-Type: application/json");
echo json_encode($data);
?>