<?php
header('Access-Control-Allow-Origin: http://localhost:3000');

// Import necessary libraries
require_once 'vendor/autoload.php'; // Path to your autoload.php
use SQLite3;

try {
    // Create a new SQLite3 instance
    $db = new SQLite3('db/myTestDB.db'); // Replace with your database name

    if (!$db) {
        throw new Exception("Connection failed: " . $db->lastErrorMsg());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get data from the request
        $name = $_POST["name"];
        $email = $_POST["email"];

        // Create a table if not exists
        $createTableQuery = "CREATE TABLE IF NOT EXISTS data (id INTEGER PRIMARY KEY, name TEXT, email TEXT)";
        $db->exec($createTableQuery);

        // Insert data into the table
        $insertQuery = "INSERT INTO data (name, email) VALUES ('$name', '$email')";
        $db->exec($insertQuery);

        // Close the database connection
        $db->close();

        // Send a success response
        http_response_code(200);
        echo json_encode(['message' => 'Data saved successfully']);
    } else {
        // Send an error response
        http_response_code(400);
        echo json_encode(['message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    // Handle exceptions
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
}
?>