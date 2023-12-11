<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Chavez";
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'users';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_id'])) {
        $updateId = $_POST['update_id'];
        header("Location: viewlist.php?tab=$currentTab&id=$updateId&edit=1");
        exit();
    } elseif (isset($_POST['save_changes'])) {
        $updateId = $_POST['update_id'];

        // Use htmlspecialchars to prevent SQL injection
        $updateId = htmlspecialchars($updateId);
        
        if ($currentTab === 'users') {
            $stmt = $conn->prepare("UPDATE Users SET username = ?, password = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['role']), $updateId);
        } elseif ($currentTab === 'students') {
            $stmt = $conn->prepare("UPDATE Student SET firstname = ?, lastname = ?, dob = ?, address = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssssi", htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']), htmlspecialchars($_POST['dob']), htmlspecialchars($_POST['address']), htmlspecialchars($_POST['email']), $updateId);
        } elseif ($currentTab === 'courses') {
            $stmt = $conn->prepare("UPDATE Course SET name = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssi", htmlspecialchars($_POST['courseName']), htmlspecialchars($_POST['courseDescription']), $updateId);
        } elseif ($currentTab === 'instructors') {
            $stmt = $conn->prepare("UPDATE Instructor SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", htmlspecialchars($_POST['instructorFirstName']), htmlspecialchars($_POST['instructorLastName']), htmlspecialchars($_POST['instructorEmail']), $updateId);
        }

        $stmt->execute();
        $stmt->close();

        header("Location: {$_SERVER['PHP_SELF']}?tab=$currentTab");
        exit();
    } elseif (isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];
        
        // Use htmlspecialchars to prevent SQL injection
        $deleteId = htmlspecialchars($deleteId);
        
        // Implement the delete operation based on the current tab
        $stmt = $conn->prepare("DELETE FROM $currentTab WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();

        header("Location: {$_SERVER['PHP_SELF']}?tab=$currentTab");
        exit();
    }
}

// Retrieve data for the view list based on the current tab
if ($currentTab === 'users') {
    $result = $conn->query("SELECT * FROM Users");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
    $column1 = 'username';
    $column2 = 'role';
} elseif ($currentTab === 'students') {
    $result = $conn->query("SELECT * FROM Student");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
    $column1 = 'firstname';
    $column2 = 'lastname';
} elseif ($currentTab === 'courses') {
    $result = $conn->query("SELECT * FROM Course");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
    $column1 = 'name';
    $column2 = 'description';
} elseif ($currentTab === 'instructors') {
    $result = $conn->query("SELECT * FROM Instructor");
    $recordList = $result->fetch_all(MYSQLI_ASSOC);
    $column1 = 'firstname';
    $column2 = 'lastname';
}

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
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $record['id']; ?>">
                                        Update
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php
                // Update Modals
                foreach ($recordList as $record): ?>
                    <div class="modal fade" id="updateModal<?php echo $record['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $record['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $record['id']; ?>">Update Record</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <!-- Include the fields based on the current tab -->
                                        <?php if ($currentTab === 'users'): ?>
                                            <!-- Users Form Fields -->
                                            <div class="form-group">
                                                <label for="username">Username:</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $record['username']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $record['password']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role:</label>
                                                <input type="text" class="form-control" id="role" name="role" value="<?php echo $record['role']; ?>" required>
                                            </div>
                                        <?php elseif ($currentTab === 'students'): ?>
                                            <!-- Students Form Fields -->
                                            <div class="form-group">
                                                <label for="firstname">First Name:</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $record['firstname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name:</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $record['lastname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="dob">Date of Birth:</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $record['dob']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address:</label>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $record['address']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $record['email']; ?>" required>
                                            </div>
                                        <?php elseif ($currentTab === 'courses'): ?>
                                            <!-- Courses Form Fields -->
                                            <div class="form-group">
                                                <label for="courseName">Course Name:</label>
                                                <input type="text" class="form-control" id="courseName" name="courseName" value="<?php echo $record['name']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="courseDescription">Course Description:</label>
                                                <textarea class="form-control" id="courseDescription" name="courseDescription"><?php echo $record['description']; ?></textarea>
                                            </div>
                                        <?php elseif ($currentTab === 'instructors'): ?>
                                            <!-- Instructors Form Fields -->
                                            <div class="form-group">
                                                <label for="instructorFirstName">First Name:</label>
                                                <input type="text" class="form-control" id="instructorFirstName" name="instructorFirstName" value="<?php echo $record['firstname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="instructorLastName">Last Name:</label>
                                                <input type="text" class="form-control" id="instructorLastName" name="instructorLastName" value="<?php echo $record['lastname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="instructorEmail">Email:</label>
                                                <input type="email" class="form-control" id="instructorEmail" name="instructorEmail" value="<?php echo $record['email']; ?>" required>
                                            </div>
                                        <?php endif; ?>
                                        <input type="hidden" name="update_id" value="<?php echo $record['id']; ?>">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
