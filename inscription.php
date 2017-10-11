<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$alert = "";
$error = "";

$username = " ";
$pwd = " ";
$lastname = " ";
$firstname = " ";

if (isset($_POST["inscription"])) {
    if (isset($_POST["username"])) {
        if (!preg_match('/[^a-z_\-0-9\[\]]/i', $_POST["username"])) {
            if (strlen($_POST["username"]) >= 3 && strlen($_POST["username"]) <= 16) {
                if (GetUserByUser($_POST["username"]) == null) {
                    $username = htmlspecialchars(trim($_POST["username"]));
                } else {
                    $error .= "<p>Nom d'utilisateur déjà pris !</p>";
                }
            } else {
                $error .= "<p>Nom d'utilisateur trop long ou trop court !</p>";
            }
        } else {
            $error .= "<p>Nom d'utilisateur invalide !</p>";
        }
    } else {
        $error .= "<p>Nom d'utilisateur invalide !</p>";
    }
    if (isset($_POST["firstname"])) {
            if (strlen($_POST["firstname"]) >= 3 && strlen($_POST["firstname"]) <= 25) {
                    $firstname = htmlspecialchars(trim($_POST["firstname"]));
            } else {
                $error .= "<p>Prénom trop long ou trop court !</p>";
            }
    } else {
        $error .= "<p>Prénom invalide !</p>";
    }
    if (isset($_POST["lastname"])) {
            if (strlen($_POST["lastname"]) >= 3 && strlen($_POST["lastname"]) <= 25) {
                    $lastname = htmlspecialchars(trim($_POST["lastname"]));
            } else {
                $error .= "<p>Nom trop long ou trop court !</p>";
            }
    } else {
        $error .= "<p>Nom invalide !</p>";
    }
    if (isset($_POST["password1"])) {
        if ($_POST["password1"] == $_POST["password2"]) {
            $pwd = sha1(htmlspecialchars(trim($_POST["password1"])));
        } else {
            $error .= "<p>Les mots de passe ne se correspondent pas !</p>";
        }
    }
    if ($username != " " && $pwd != " ") {
        AddUser($username, $pwd, $firstname, $lastname);
        $infoUser = Connexion($username, $pwd);
        if ($infoUser != null) {
            $_SESSION['infoUser'] = $infoUser[0];
            header("location:index.php");
        }
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade in" role="alert">'
                . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                . '<span aria-hidden="true">&times;</span></button>'
                . '<h4>Une erreur est survenue !</h4>'
                . $error
                . '</div>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
    </head>
    <body>      
        <?php include 'navBar.php'; ?>
        <div id="content">
            <form method="post" action='inscription.php'>
                <?php echo $alert ?>
                <fieldset class="form-horizontal">
                    <legend>Inscription</legend>
                    <label for="inputEmail3" class="col-sm-4 control-label">Nom d'utilisateur*</label>
                    <input type="text" class="form-control" name="username" maxlength="16" value="<?php echo (isset($_POST["username"])) ? ($_POST["username"]) : ("") ?>" required="required"><br/><br/>

                    <label for="inputEmail3" class="col-sm-4 control-label">Mot de passe* </label>
                    <input type="password" class="form-control" name="password1" value="" maxlength="40" required="required"><br/><br/>

                    <label for="inputEmail3" class="col-sm-4 control-label">Retapez le mot de passse* </label>
                    <input type="password" class="form-control" name="password2" value="" maxlength="40" required="required"><br/><br/>

                    <label for="inputEmail3" class="col-sm-4 control-label">Nom </label>
                    <input type="text" class="form-control" name="lastname" maxlength="50" value="<?php echo (isset($_POST["lastname"])) ? ($_POST["lastname"]) : ("") ?>"><br/><br/>

                    <label for="inputEmail3" class="col-sm-4 control-label">Prénom </label>
                    <input type="text" class="form-control" name="firstname" maxlength="50" value="<?php echo (isset($_POST["firstname"])) ? ($_POST["firstname"]) : ("") ?>"><br/><br/>

                    *Champs obligatoires
                </fieldset> 
                <br/>
                <fieldset>
                    <legend>Valider</legend>              
                    <input type="submit" class="btn btn-default" name="inscription" value="S'inscrire"><br/>
                </fieldset>
                <br/>
                <br/>
            </form>
        </div>
    </body>
</html>