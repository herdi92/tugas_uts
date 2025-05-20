<?php
// database.php - database connection

$host = 'localhost';
$user = 'root';
$password = ''; // set your MySQL root password if any
$database = 'tugas';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

