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
        <?php include 'cssInclude.html'; ?>
    </head>
    <body>
        <?php
        include 'navBar.php';
        ?>
        <h1>404 Not Found</h1>
        <a href="index.php">Accueil</a>
    </body>
</html>
