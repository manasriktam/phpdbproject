<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $recordId = $_POST["id"];

    // Connect to SQLite database
    $db = new SQLite3('db/myTestDB.db'); // Replace with your database name

    if (!$db) {
        die("Connection failed: " . $db->lastErrorMsg());
    }

    // Delete the record
    $deleteQuery = "DELETE FROM data WHERE id = '$recordId'";
    $db->exec($deleteQuery);

    // Close the database connection
    $db->close();

    http_response_code(200); // Success response
} else {
    http_response_code(400); // Bad request response
}
?>