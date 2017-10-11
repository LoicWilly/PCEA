<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>404</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <?php
        include 'navBar.php';
        ?>
        <h1>404 Not Found</h1>
        <a href="index.php">Accueil</a>
    </body>
</html>
