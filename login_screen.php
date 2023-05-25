<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate user credentials
function validateUser($username, $password) {
    global $conn;
    
    // SQL query to check if the username and password exist in the database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        // User credentials are valid
        return true;
    } else {
        // User credentials are invalid
        return false;
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate user credentials
    if (validateUser($username, $password)) {
        // Redirect to the main page after successful login
        header("Location: main.php");
        exit();
    } else {
        // Display an error message for invalid credentials
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" name="submit" value="Login">
    </form>
    
    <p>Create a new account:</p>
    <form method="post" action="create_user.php">
        <label for="new_username">Username:</label>
        <input type="text" name="new_username" required><br><br>
        
        <label for="new_password">Password:</label>
        <input type="password" name="new_password" required><br><br>
        
        <input type="submit" name="submit" value="Create Account">
    </form>
</body>
</html>