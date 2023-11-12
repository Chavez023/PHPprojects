<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
         if(isset($_POST['add'])) {
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $mysql = mysqli_connect($dbhost, $dbuser, $dbpass);
         
            if($mysqli->connect_errno ) {
                printf("Connect failed: %s<br />", $mysqli->connect_error);
                exit();
             }
             printf('Connected successfully.<br />');
             
             if ($mysqli->query("CREATE DATABASE BOOKS")) {
                printf("Database BOOKS created successfully.<br />");
             }
             if ($mysqli->errno) {
                printf("Could not create database: %s<br />", $mysqli->error);
             }

             $sql = "CREATE TABLE Works( ".
            "tutorial_id INT NOT NULL AUTO_INCREMENT, ".
            "tutorial_title VARCHAR(100) NOT NULL, ".
            "tutorial_author VARCHAR(40) NOT NULL, ".
            "submission_date DATE, ".
            "PRIMARY KEY ( tutorial_id )); ";
            if ($mysqli->query($sql)) {
                printf("Table Works created successfully.<br />");
            }
            if ($mysqli->errno) {
                printf("Could not create table: %s<br />", $mysqli->error);
            }

            if(! $mysql ) {
               die('Could not connect: ' . mysqli_error($mysql));
            }
            if(! get_magic_quotes_gpc() ) {
               $tutorial_title = addslashes ($_POST['tutorial_title']);
               $tutorial_author = addslashes ($_POST['tutorial_author']);
            } else {
               $tutorial_title = $_POST['tutorial_title'];
               $tutorial_author = $_POST['tutorial_author'];
            }
            $submission_date = $_POST['submission_date'];
            $sql = "INSERT INTO Works ".
               "(tutorial_title,tutorial_author, submission_date) "."VALUES ".
               "('$tutorial_title','$tutorial_author','$submission_date')";
            mysqli_select_db( $mysql, 'BOOKS' );
            $retval = mysqli_query( $mysql, $sql );
         
            if(! $retval ) {
               die('Could not enter data: ' . mysqli_error($mysql));
            }
            echo "Entered data successfully\n";
            mysqli_close($mysql);
         } else {
      ?>  
      <form method = "post" action = "<?php $_PHP_SELF ?>">
         <table width = "600" border = "0" cellspacing = "1" cellpadding = "2">
            <tr>
               <td width = "250">Tutorial Title</td>
               <td><input name = "tutorial_title" type = "text" id = "tutorial_title"></td>
            </tr>         
            <tr>
               <td width = "250">Tutorial Author</td>
               <td><input name = "tutorial_author" type = "text" id = "tutorial_author"></td>
            </tr>         
            <tr>
               <td width = "250">Submission Date [   yyyy-mm-dd ]</td>
               <td><input name = "submission_date" type = "text" id = "submission_date"></td>
            </tr>      
            <tr>
               <td width = "250"> </td>
               <td></td>
            </tr>         
            <tr>
               <td width = "250"> </td>
               <td><input name = "add" type = "submit" id = "add"  value = "Add Tutorial"></td>
            </tr>
         </table>
      </form>
   <?php
      }
   ?>
</body>
</html>