<?php

function linkResource($rel, $href)
{
    echo "<link rel='{$rel}' href='{$href}'>";
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdata";


// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to encrypt a string
function encrypt($data)
{
    // Perform encryption logic here (e.g., using a secure encryption algorithm)
    // ...
    $encryptionKey = 'your_encryption_key';
    $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));
    return $encryptedData;
}

// Function to decrypt a string
function decrypt($encryptedData)
{
    // Perform decryption logic here (e.g., using the same encryption algorithm)
    // ...
    $encryptionKey = 'your_encryption_key';
    $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));
    return $decryptedData;
}

// Fetch login information from the database
$query = "SELECT * FROM userdata";
$result = $conn->query($query);

// Store decrypted login information
$logins = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decrypt the login information
        $username = decrypt($row['username']);
        $password = decrypt($row['password']);

        // Add decrypted login information to the array
        $logins[] = array('username' => $username, 'password' => $password);
    }
}

// Handle form submission to create new data
if (isset($_POST['submit'])) {
    $newUsername = encrypt($_POST['new_username']);
    $newPassword = encrypt($_POST['new_password']);

    // Insert the new data into the database
    $createQuery = "INSERT INTO userdata (username, password) VALUES ('$newUsername', '$newPassword')";

    if ($conn->query($createQuery) === TRUE) {
        // Refresh the page to show the updated data
        header("Location: main.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}



// Retrieve data from the database
$sql = "SELECT user_id, username, password FROM userdata";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Password Manager</title>
    <link rel="stylesheet" href="style.css" media="screen">
</head>

<body>
    <h2>Password Manager</h2>

    <h3>Login Information:</h3>
    <table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
            <?php foreach ($logins as $login) { ?>
                <?php $row = $result->fetch_assoc() ?>
                <tr>
                    <td><?php echo $login['username']; ?></td>
                    <td><?php echo $login['password']; ?></td>
                    <td>
                    <?php echo "<td><a href='delete.php?user_id=".$row["user_id"]."'> <button>Delete</button></a></td>"; ?>
                    </td>
                </tr>
            <?php } ?>

    </tbody>
</table>

    <h3>Create New Data:</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="new_username">Username:</label>
        <input type="text" name="new_username" required><br><br>

        <label for="new_password">Password:</label>
        <input type="password" name="new_password" required><br><br>

        <input type="submit" name="submit" value="Create Data">
    </form>
</body>

</html>