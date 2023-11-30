<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentinformation";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sqlCreateDB) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateTable) === TRUE) {
    echo "Table created successfully or already exists<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Insert data into the database
    $sql = "INSERT INTO students (name, email) VALUES ('$name', '$email')";
    $result = $conn->query($sql);

    if ($result) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch and display records
$result = $conn->query("SELECT * FROM students");

echo "<h1>Students Information System</h1>";

if ($result->num_rows > 0) {
    echo "<h2>Records</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "- Name: " . $row["name"] . " Email: " . $row["email"] . "<br>";
    }
    echo "<br><a href='index.php'>Add a new record</a>";
} else {
    echo "No records found<br><a href='index.php'>Add a new record</a>";
}

// Close the database connection
$conn->close();
?>
