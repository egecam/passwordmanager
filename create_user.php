<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "passwordmanager";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    function userExists($username, $conn) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    if (userExists($newUsername, $conn)) {
        // User with the provided username or email already exists
        echo "Username already exists.";
    } else { // Insert the new user into the database
        $query = "INSERT INTO users (username, password) VALUES ('$newUsername', '$newPassword')";
        
        if ($conn->query($query) === TRUE) {
            echo "New user created successfully! Will redirect in 5 seconds...";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
    
    // Close the database connection
    $conn->close();
}

header('refresh: 5; url=login_screen.php');
?>
