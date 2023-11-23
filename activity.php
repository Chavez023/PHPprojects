<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
       class Database {
            private $host = 'localhost';
            private $username = 'root';
            private $password = '';
            private $database = 'student_record';
            private $connection;
        
            public function __construct() {
                $this->connection = new mysqli($this->host, $this->username, $this->password);
        
                if ($this->connection->connect_error) {
                    die("Connection failed: " . $this->connection->connect_error);
                }

                $createDbQuery = "CREATE DATABASE IF NOT EXISTS " . $this->database;
                $this->connection->query($createDbQuery);
        
                $this->connection->select_db($this->database);

                $this->executeQuery("CREATE TABLE IF NOT EXISTS students (
                                        studentID INT PRIMARY KEY,
                                        firstName VARCHAR(50),
                                        lastName VARCHAR(50),
                                        dateOfBirth DATE,
                                        email VARCHAR(100),
                                        phone VARCHAR(20)
                                    )");
        
                $this->executeQuery("CREATE TABLE IF NOT EXISTS courses (
                                        courseID INT PRIMARY KEY,
                                        courseName VARCHAR(100),
                                        credits INT
                                    )");
        
                $this->executeQuery("CREATE TABLE IF NOT EXISTS instructors (
                                        instructorID INT PRIMARY KEY,
                                        firstName VARCHAR(50),
                                        lastName VARCHAR(50),
                                        email VARCHAR(100),
                                        phone VARCHAR(20)
                                    )");
        
                $this->executeQuery("CREATE TABLE IF NOT EXISTS enrollments (
                                        enrollmentID INT PRIMARY KEY,
                                        studentID INT,
                                        courseID INT,
                                        enrollmentDate DATE,
                                        grade VARCHAR(2),
                                        FOREIGN KEY (studentID) REFERENCES students(studentID),
                                        FOREIGN KEY (courseID) REFERENCES courses(courseID)
                                    )");
            }
        
            public function executeQuery($query) {
                return $this->connection->query($query);
            }
        }
        
        class Student {
            public $studentID;
            public $firstName;
            public $lastName;
            public $dateOfBirth;
            public $email;
            public $phone;
        
            public function __construct($studentID, $firstName, $lastName, $dateOfBirth, $email, $phone) {
                $this->studentID = $studentID;
                $this->firstName = $firstName;
                $this->lastName = $lastName;
                $this->dateOfBirth = $dateOfBirth;
                $this->email = $email;
                $this->phone = $phone;
            }
        }
        
        class Course {
            public $courseID;
            public $courseName;
            public $credits;
        
            public function __construct($courseID, $courseName, $credits) {
                $this->courseID = $courseID;
                $this->courseName = $courseName;
                $this->credits = $credits;
            }
        }
        
        class Instructor {
            public $instructorID;
            public $firstName;
            public $lastName;
            public $email;
            public $phone;
        
            public function __construct($instructorID, $firstName, $lastName, $email, $phone) {
                $this->instructorID = $instructorID;
                $this->firstName = $firstName;
                $this->lastName = $lastName;
                $this->email = $email;
                $this->phone = $phone;
            }
        }
        
        class Enrollment {
            public $enrollmentID;
            public $studentID;
            public $courseID;
            public $enrollmentDate;
            public $grade;
        
            public function __construct($enrollmentID, $studentID, $courseID, $enrollmentDate, $grade) {
                $this->enrollmentID = $enrollmentID;
                $this->studentID = $studentID;
                $this->courseID = $courseID;
                $this->enrollmentDate = $enrollmentDate;
                $this->grade = $grade;
            }
        }
        
        // TESTING   Database setup
        $database = new Database();
        
        $query = "INSERT INTO students (studentID, firstName, lastName, dateOfBirth, email, phone) 
                  VALUES (1, 'John', 'Doe', '1990-01-01', 'john.doe@example.com', '123-456-7890')";
        $database->executeQuery($query);
        $query = "INSERT INTO courses (courseID, courseName, credits) 
                  VALUES (101, 'Computer Science', 3)";
        $database->executeQuery($query);
        $query = "INSERT INTO enrollments (enrollmentID, studentID, courseID, enrollmentDate, grade) 
                  VALUES (301, 1, 101, '2023-01-15', 'A')";
        $database->executeQuery($query);
        $result = $database->executeQuery("SELECT * FROM students WHERE studentID = 1");
        $row = $result->fetch_assoc();
        
        $student1 = new Student($row['studentID'], $row['firstName'], $row['lastName'], $row['dateOfBirth'], $row['email'], $row['phone']);
        
        // Output retrieved student data
        echo "Student ID: " . $student1->studentID . "<br>";
        echo "First Name: " . $student1->firstName . "<br>";
        echo "Last Name: " . $student1->lastName . "<br>";
        echo "Date of Birth: " . $student1->dateOfBirth . "<br>";
        echo "Email: " . $student1->email . "<br>";
        echo "Phone: " . $student1->phone . "<br>";
    ?>
</body>
</html>