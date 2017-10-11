<?php
/* Author : Willy Loïc
 */
session_start();
$_SESSION = array();
session_destroy();
header("location:index.php");
?>
