<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "skyhigh_db";

try {
    // Create a new mysqli instance
    $mysqli = @new mysqli($servername, $username, $password, $database);

    if ($mysqli->connect_errno) {
        throw new Exception("Failed to connect to the database.");
    }
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
