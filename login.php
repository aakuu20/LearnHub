<?php
// Include your database connection file (connect.php)
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Grab user input from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $Password = password($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO register (username, email, password) VALUES ('$username', '$email', '$Password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
