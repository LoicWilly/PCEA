<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
if (!isConnect()) {
    header("location:index.php");
}
$grpname = " ";
$weight = -1;
if (isset($_POST["createGroup"])) {
    var_dump($_POST);
    if (isset($_POST["groupname"])) {
        $grpname = htmlspecialchars(trim($_POST["groupname"]));
    }
    if (isset($_POST["weight"])) {
        $weight = htmlspecialchars(trim($_POST["weight"]));
    }
    if ($grpname != " " && $weight != -1) {
        $idGroup = CreateGroup($grpname);
        AddUserToGroup($idGroup, $_SESSION['infoUser']['idUser'], $weight);
        header("location:index.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Création de groupe</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
    </head>
    <body>      
        <?php include 'navBar.php'; ?>
        <div id="content">
            <form  method="post" action='createGroup.php'>
                <fieldset class="form-group">
                    <legend>Création de groupe</legend>
                    <label for="inputEmail3" class="col-sm-4 control-label">Nom du groupe</label>
                    <input type="text" class="form-control" name="groupname" value="" maxlength="16" required="required"><br/><br/>
                    <label for="inputEmail3" class="col-sm-4 control-label">Poids</label>
                    <input type="number" class="form-control" name="weight" value="" maxlength="40" required="required"><br/><br/>
                </fieldset> 
                <br/>
                <br/>
                <fieldset>
                    <legend>Valider</legend>              
                    <input type="submit" class="btn btn-default" name="createGroup" value="Créer un groupe"><br/>
                </fieldset> 
            </form>
        </div>
    </body>
</html>