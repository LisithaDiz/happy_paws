<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "happy_paws";

//Create a connection to the MySQL database

function connectDatabase() {
    global $servername, $username, $password, $dbname;

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

 //Close the database connection

function closeDatabase($conn) {
    $conn->close();
}
?>
