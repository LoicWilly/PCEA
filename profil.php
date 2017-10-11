<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$idUser = "";
$infoUser = array();
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
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
        <script>
        </script>
    </head>
    <body>      
        <div id="content">
            <?php include 'navBar.php'; ?>
            <form  method="post" action='profil.php'>
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
                </fieldset> 
                <br/>
                <br/>
                <?php
                if (isConnect() && $_SESSION['infoUser']['username'] == $username) {
                    ?>
                    <fieldset>
                        <legend>Valider</legend>              
                        <input type="submit" class="btn btn-default" name="changeProfil" value="Modifier"><br/>
                    </fieldset> 
                <?php } ?>
            </form>
            <br/>
            <br/>
        </div>
    </body>
</html>