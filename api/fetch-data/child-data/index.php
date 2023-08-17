<?php
header('Access-Control-Allow-Origin: http://localhost:3000');

// Import necessary libraries
require_once '../../../vendor/autoload.php'; // Path to your autoload.php
use SQLite3;

try {
    // Create a new SQLite3 instance
    $db = new SQLite3('../../../db/tigersheetgpt.db'); // Replace with your database name

    if (!$db) {
        throw new Exception("Connection failed: " . $db->lastErrorMsg());
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Get data from the request
        // $sessionuid = $_POST["sessionuid"];
        $sessionuid = $_GET["sessionuid"];
        
        // Retrieve data from the rootnodestable
        $data = [];
        
        // $query1 = "SELECT * FROM rootnodestable WHERE sessionuid = '$sessionuid'";
        // $result1 = $db->query($query1);
        

        // while ($row = $result1->fetchArray(SQLITE3_ASSOC)) {
        //     $data[] = $row;
        // }

        // Retrieve data from the rootnodestable
        $query2 = "SELECT * FROM childnodestable WHERE sessionuid = '$sessionuid'";
        $result2 = $db->query($query2);

        while ($row = $result2->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        
        // $rootuid = $_POST["rootuid"];
        // $isrootnode = $_POST["isrootnode"];
        // $useruid = $_POST["useruid"];
        // $rootmessage = $_POST["rootmessage"];
        // $userdomain = $_POST["userdomain"];
        // $username = $_POST["username"];
       

        // Create a table if not exists
        // $createTableQuery = "CREATE TABLE IF NOT EXISTS data (id INTEGER PRIMARY KEY, name TEXT, email TEXT)";
        // $db->exec($createTableQuery);

        // Insert data into the usertable table
        // $insertQuery = "INSERT INTO usertable (userdomain,username,rootuid,useruid) VALUES ('$userdomain','$username','$rootuid','$useruid')";
        // $db->exec($insertQuery);

        // Insert data into the rootnodestable table
        // $insertQuery = "INSERT INTO rootnodestable (sessionuid,rootuid,isrootnode,useruid,rootmessage) VALUES ('$sessionuid','$rootuid','$isrootnode','$useruid','$rootmessage')";
        // $db->exec($insertQuery);

        // Close the database connection
        $db->close();

        // Send a success response
        http_response_code(200);
        // echo json_encode(['message' => 'Data saved successfully']);
        // Send data as JSON response
        header("Content-Type: application/json");
        echo json_encode($data);
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