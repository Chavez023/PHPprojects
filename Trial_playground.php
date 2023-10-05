<?php


function generatePhpPlayground($title, $code) {
   
    $escapedCode = htmlspecialchars($code);

   
    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>
    <style>
        .playground {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>{$title}</h1>
    <div class="playground">
        <pre><code>{$escapedCode}</code></pre>
    </div>
    <script>
       
        eval(`<?php {$code} ?>`);
    </script>
</body>
</html>
HTML;

    return $html;
}


$title = "PHP Playground";
$code = <<<PHP
echo "Hello, World!";
PHP;

$phpPlayground = generatePhpPlayground($title, $code);
echo $phpPlayground;

?>