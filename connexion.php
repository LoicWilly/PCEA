<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
if (isConnect()) {
    header("location:index.php");
}
$username = " ";
$pwd = " ";
if (isset($_POST["connexion"])) {
    if (isset($_POST["username"])) {
        $username = htmlspecialchars(trim($_POST["username"]));
    }
    if (isset($_POST["password1"])) {
        $pwd = sha1(htmlspecialchars(trim($_POST["password1"])));
    }
    if ($username != " " && $pwd != " ") {
        $infoUser = Connexion($username, $pwd);
        if ($infoUser != null) {
            $_SESSION['infoUser'] = $infoUser[0];
            header("location:index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
    </head>
    <body>      
        <?php include 'navBar.php'; ?>
        <div id="content">
            <form  method="post" action='connexion.php'>
                <fieldset class="form-group">
                    <legend>Connexion</legend>
                    <label for="inputEmail3" class="col-sm-4 control-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="username" value="" maxlength="16" required="required"><br/><br/>
                    <label for="inputEmail3" class="col-sm-4 control-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password1" value="" maxlength="40" required="required"><br/><br/>
                </fieldset> 
                <br/>
                <br/>
                <fieldset>
                    <legend>Valider</legend>              
                    <input type="submit" class="btn btn-default" name="connexion" value="Se connecter"><br/>
                </fieldset> 
            </form>
        </div>
    </body>
</html>