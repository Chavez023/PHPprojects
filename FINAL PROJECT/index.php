<?php
ob_start();
    include 'setup.php';
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Student Information System</title>
</head>
<body>

<?php
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'users';
?>

<div class="container mt-5">
    <h2>Student Information System</h2>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab === 'users') ? 'active' : '' ?>" href="?tab=users">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab === 'students') ? 'active' : '' ?>" href="?tab=students">Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab === 'courses') ? 'active' : '' ?>" href="?tab=courses">Courses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentTab === 'instructors') ? 'active' : '' ?>" href="?tab=instructors">Instructors</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-2">
        <!-- Include the form and viewlist files with $currentTab variable -->
        <?php include 'form.php'; ?>
        <?php include 'viewlist.php'; ?>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
