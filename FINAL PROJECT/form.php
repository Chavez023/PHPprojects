<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Chavez"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($currentTab === 'users' && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
        // Process the form data for the Users table
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Insert data into Users table
        $sql = "INSERT INTO Users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($sql) === TRUE) {
            echo "User added successfully";
        } else {
            echo "Error adding user: " . $conn->error;
        }
    } elseif ($currentTab === 'students' && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['dob']) && isset($_POST['address']) && isset($_POST['email'])) {
        // Process the form data for the Students table
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $email = $_POST['email'];

        // Insert data into Students table
        $sql = "INSERT INTO Student (firstname, lastname, dob, address, email) VALUES ('$firstname', '$lastname', '$dob', '$address', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Student added successfully";
        } else {
            echo "Error adding student: " . $conn->error;
        }
    } elseif ($currentTab === 'courses' && isset($_POST['courseName']) && isset($_POST['courseDescription'])) {
        // Process the form data for the Courses table
        $courseName = $_POST['courseName'];
        $courseDescription = $_POST['courseDescription'];

        // Insert data into Courses table
        $sql = "INSERT INTO Course (name, description) VALUES ('$courseName', '$courseDescription')";
        if ($conn->query($sql) === TRUE) {
            echo "Course added successfully";
        } else {
            echo "Error adding course: " . $conn->error;
        }
    } elseif ($currentTab === 'instructors' && isset($_POST['instructorFirstName']) && isset($_POST['instructorLastName']) && isset($_POST['instructorEmail'])) {
        // Process the form data for the Instructors table
        $instructorFirstName = $_POST['instructorFirstName'];
        $instructorLastName = $_POST['instructorLastName'];
        $instructorEmail = $_POST['instructorEmail'];

        // Insert data into Instructors table
        $sql = "INSERT INTO Instructor (firstname, lastname, email) VALUES ('$instructorFirstName', '$instructorLastName', '$instructorEmail')";
        if ($conn->query($sql) === TRUE) {
            echo "Instructor added successfully";
        } else {
            echo "Error adding instructor: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<div class="mt-3">
    <h4>Add New</h4>
    <form action="" method="post">
        <?php if ($currentTab === 'users'): ?>
            <!-- Users Form Fields -->
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" class="form-control" id="role" name="role" required>
            </div>
        <?php elseif ($currentTab === 'students'): ?>
            <!-- Students Form Fields -->
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        <?php elseif ($currentTab === 'courses'): ?>
            <!-- Courses Form Fields -->
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" class="form-control" id="courseName" name="courseName" required>
            </div>
            <div class="form-group">
                <label for="courseDescription">Course Description:</label>
                <textarea class="form-control" id="courseDescription" name="courseDescription"></textarea>
            </div>
        <?php elseif ($currentTab === 'instructors'): ?>
            <!-- Instructors Form Fields -->
            <div class="form-group">
                <label for="instructorFirstName">First Name:</label>
                <input type="text" class="form-control" id="instructorFirstName" name="instructorFirstName" required>
            </div>
            <div class="form-group">
                <label for="instructorLastName">Last Name:</label>
                <input type="text" class="form-control" id="instructorLastName" name="instructorLastName" required>
            </div>
            <div class="form-group">
                <label for="instructorEmail">Email:</label>
                <input type="email" class="form-control" id="instructorEmail" name="instructorEmail" required>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

