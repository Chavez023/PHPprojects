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
    // Check if an update or delete button is clicked
    if (isset($_POST['update_id'])) {
        $updateId = $_POST['update_id'];

        // Redirect to the update form with the record ID
        header("Location: update.php?tab=$currentTab&id=$updateId");
        exit();
    } elseif (isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];

        // Determine the current tab and delete the record from the corresponding table
        if ($currentTab === 'users') {
            $conn->query("DELETE FROM Users WHERE id = $deleteId");
        } elseif ($currentTab === 'students') {
            $conn->query("DELETE FROM Student WHERE id = $deleteId");
        } elseif ($currentTab === 'courses') {
            $conn->query("DELETE FROM Course WHERE id = $deleteId");
        } elseif ($currentTab === 'instructors') {
            $conn->query("DELETE FROM Instructor WHERE id = $deleteId");
        }
    }
}

// Retrieve data for the view list based on the current tab
if ($currentTab === 'users') {
    $result = $conn->query("SELECT * FROM Users");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($currentTab === 'students') {
    $result = $conn->query("SELECT * FROM Student");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($currentTab === 'courses') {
    $result = $conn->query("SELECT * FROM Course");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($currentTab === 'instructors') {
    $result = $conn->query("SELECT * FROM Instructor");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>
        <?php
        // Display title based on the current tab and record availability
        if (!empty($recordList)) {
            if ($currentTab === 'users') {
                echo "User List";
            } elseif ($currentTab === 'students') {
                echo "Student List";
            } elseif ($currentTab === 'courses') {
                echo "Course List";
            } elseif ($currentTab === 'instructors') {
                echo "Instructor List";
            }
        }
        ?>
    </title>
</head>
<body>

<div class="container mt-4">
    <!-- View List -->
    <div class="row">
        <div class="col">
            <?php if (!empty($recordList)): ?>
                <!-- Header/Category -->
                <div class="row mb-3">
                    <div class="col">
                        <h2>
                            <?php
                            // Display category based on the current tab
                            if ($currentTab === 'users') {
                                echo "User List";
                                $column1 = 'username';
                                $column2 = 'role';
                            } elseif ($currentTab === 'students') {
                                echo "Student List";
                                $column1 = 'firstname';
                                $column2 = 'lastname';
                            } elseif ($currentTab === 'courses') {
                                echo "Course List";
                                $column1 = 'name';
                                $column2 = 'description';
                            } elseif ($currentTab === 'instructors') {
                                echo "Instructor List";
                                $column1 = 'firstname';
                                $column2 = 'lastname';
                            }
                            ?>
                        </h2>
                    </div>
                </div>

                <!-- Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo ucfirst($column1); ?></th>
                            <th><?php echo ucfirst($column2); ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recordList as $record): ?>
                            <tr>
                                <td><?php echo $record['id']; ?></td>
                                <td><?php echo $record[$column1]; ?></td>
                                <td><?php echo $record[$column2]; ?></td>
                                <td>
                                    <form action="" method="post" style="display: inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $record['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
