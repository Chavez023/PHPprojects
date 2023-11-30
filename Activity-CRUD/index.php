<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Information System</title>
</head>
<body>
    <h1>Students Information System</h1>

    <form action="process.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" value="Create">
    </form>

</body>
</html>
