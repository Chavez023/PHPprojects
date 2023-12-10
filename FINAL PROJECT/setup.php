<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Chavez";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the initial connection
$conn->close();

// Establish a new connection to the created database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Users table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
)";
$conn->query($sql);

// Create Student table
$sql = "CREATE TABLE IF NOT EXISTS Student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";
$conn->query($sql);

// Create Course table
$sql = "CREATE TABLE IF NOT EXISTS Course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
)";
$conn->query($sql);

// Create Instructor table
$sql = "CREATE TABLE IF NOT EXISTS Instructor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";
$conn->query($sql);

// Create Enrollment table
$sql = "CREATE TABLE IF NOT EXISTS Enrollment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    FOREIGN KEY (student_id) REFERENCES Student(id),
    FOREIGN KEY (course_id) REFERENCES Course(id)
)";
$conn->query($sql);

echo "Tables created successfully";

// Close the connection
$conn->close();
?>
