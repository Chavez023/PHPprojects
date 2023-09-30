<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variable Type</title>
</head>
<body>
    <?php
        echo "Integers <br>";
        $int_var = 12345;
        $another_int = -12345 + 12345;
        echo "$int_var <br> $another_int <br>";


        echo "Double <br>";
        $many = 2.2888800;
        $many_2 = 2.2111200;
        $few = $many + $many_2;
        print($many + $many_2 . " = $few<br>");

        echo "Boolean <br>";
        if (TRUE)
            print("This will always print<br>");
        else
            print("This will never print<br>");

        

        echo "Null<br>";
        $my_var = null;


        echo "Strings <br>";
        $string_1 = "This is a string in double quotes";
        $string_2 = "This is a somewhat longer, singly quoted string";
        $string_39 = "This string has thirty-nine characters";
        $string_0 = ""; // a string with zero characters

        $variable = "name";
        $literally = 'My $variable will not print!\\n';
        print($literally);
        $literally = "My $variable will print!\\n";
        print($literally);

        echo "<br><br>";
    ?>

    
    <?php
    echo "here Document<br>";
    $channel =<<<_XML_
    <channel>
        <title>What's For Dinner</title>
        <link>http://menu.example.com/</link>
        <description>Choose what to eat tonight.</description>
    </channel>
    _XML_;

    echo <<<END
    This uses the "here document" syntax to output
    multiple lines with variable interpolation. Note
    that the here document terminator must appear on a
    line with just a semicolon. no extra whitespace!
    <br />
    END;
    
    print $channel;
    echo "<br><br>";
    ?>


    <?php
     echo "Php Local Variable<br>";
    $x = 4;
    function assignx () {
    $x = 0;
    print "\$x inside function is $x. 
    ";
    }
    assignx();
    print "\$x outside of function is $x. 
    ";
    ?>

    <?php
    echo "Php Global Variable<br>";
    $somevar = 15;
    function addit() {
    GLOBAL $somevar;
    $somevar++;
    print "Somevar is $somevar";
    }
    addit();

    echo "<br><br>";
    ?>
    
    <?php
    echo "Php Global Variable<br>";

    function keep_track() {
    STATIC $count = 0;
    $count++;
    print $count;
    print "";
    }

    keep_track();
    keep_track();
    keep_track();
    ?>



   
    
</body>
</html>
