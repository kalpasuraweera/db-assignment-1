<?php

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    // Database connection settings
    $host = "localhost";
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $database = "uni_course_db";

    // Create a MySQL connection
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} else {
    header('Location: ../index.php');
    exit();
}
?>