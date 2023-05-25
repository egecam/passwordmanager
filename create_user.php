<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    
    // Insert the new user into the database
    $query = "INSERT INTO users (username, password) VALUES ('$newUsername', '$newPassword')";
    
    if ($conn->query($query) === TRUE) {
        echo "New user created successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}

$url = "login_screen.php";

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);

}

redirect($url);
?>
