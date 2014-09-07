<?php
ini_set('display_errors', 1);
include '../src/autoload.php';
$p = new PracticeHelper;
?>
<html lang="en">
    <head>
    <link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, .full { width: 100%; height: 100%; }
        .btn-group-vertical, .btn-group-vertical button { width: 100%; }
        
    </style>
    </head>
    <body>
<?php
echo $p;
?>
</div>
    </body>
</html>