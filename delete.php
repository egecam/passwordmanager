<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "userdata";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the id parameter is set
if (isset($_GET["user_id"])) {
    $id = $_GET["user_id"];
    
    // Perform the delete operation
    $sql = "DELETE FROM userdata WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    
}

header('Location: main.php');
?>
