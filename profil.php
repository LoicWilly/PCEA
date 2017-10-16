<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$idUser = "";
$infoUser = array();
$firstname = "";
$lastname = "";
$username = "";
$error = "";
if (isset($_POST['changeProfil'])) {
    if (isset($_POST["firstname"])) {
        if (strlen($_POST["firstname"]) >= 3 && strlen($_POST["firstname"]) <= 25) {
            $firstname = strVerif($_POST["firstname"]);
        } else {
            $error .= "<p>Prénom trop long ou trop court !</p>";
        }
    } else {
        $error .= "<p>Prénom invalide !</p>";
    }
    if (isset($_POST["lastname"])) {
        if (strlen($_POST["lastname"]) >= 3 && strlen($_POST["lastname"]) <= 25) {
            $lastname = strVerif($_POST["lastname"]);
        } else {
            $error .= "<p>Nom trop long ou trop court !</p>";
        }
    } else {
        $error .= "<p>Nom invalide !</p>";
    }
    if($firstname != "" && $lastname != ""){
        UpdateProfil($_SESSION['infoUser']['idUser'], $firstname, $lastname);
        $_SESSION['infoUser'] = Connexion($_SESSION['infoUser']['username'], $_SESSION['infoUser']['password'])[0];
    }
}
if (isset($_GET['username'])) {
    if (isConnect() && $_SESSION['infoUser']['username'] == $_GET['username']) {
        $username = $_SESSION['infoUser']['username'];
        $firstname = $_SESSION['infoUser']['firstname'];
        $lastname = $_SESSION['infoUser']['lastname'];
    } else {
        $infoUser = GetUserByUser($_GET['username'])[0];
        if ($infoUser != null) {
            $username = $infoUser['username'];
            $firstname = ($infoUser['firstname']);
            $lastname = ($infoUser['lastname']);
        } else {
            header("location:404.php");
        }
    }
} else {
    header("location:404.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profil</title>
        <?php include 'cssInclude.html'; ?>
        <script>
        </script>
    </head>
    <body>      
        <div id="content">
            <?php include 'navBar.php'; ?>
            <?php echo $error ?>
            <form  method="post" action='profil.php?username=<?php echo $username ?>'>
                <fieldset class="form-group">
                    <legend>Information</legend>
                    Nom d'utilisateur : <?php echo $username ?> <br/>
                    <?php
                    if (isConnect() && $_SESSION['infoUser']['username'] == $username) {
                        ?>
                        <label for="inputEmail3" class="col-sm-4 control-label">Prenom</label>
                        <input type="text" class="form-control" name="firstname" value="<?php echo $firstname ?>" maxlength="25"><br/><br/>
                        <label for="inputEmail3" class="col-sm-4 control-label">Nom</label>
                        <input type="text" class="form-control" name="lastname" value="<?php echo $lastname ?>" maxlength="25"><br/><br/>

                        <?php
                    } else {
                        ?>
                        Nom et prénom :
                        <?php echo $firstname ?>
                        <?php echo $lastname ?>
                    <?php } ?>
                    <?php
                    if (isConnect() && $_SESSION['infoUser']['username'] == $username) {
                        ?>            
                        <input type="submit" class="btn btn-default" name="changeProfil" value="Modifier le profil"><br/>
                    </fieldset> 
                <?php } ?>
            </form>
            <br/>
            <br/>
        </div>
    </body>
</html>