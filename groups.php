<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$idUser = "";
$infoUser = array();
if (isConnect() && isset($_GET['idGroup'])) {
    $idGroup = strVerif($_GET['idGroup']);
    $grp = GetGroupById($idGroup);
    if (isset($_POST['addUser'])) {
        $username = (isset($_POST['username'])) ? strVerif($_POST['username']) : "";
        $weight = (isset($_POST['weight'])) ? strVerif($_POST['weight']) : "";
        if ($username != "" && $weight != "") {
            $user = GetUserByUser($username)[0];
            AddUserToGroup($idGroup, $user['idUser'], $weight);
            header("location:groups.php?idGroup=".$idGroup);
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
        <title>Groupe</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet" type="text/css" >
        <script>
        </script>
    </head>
    <body>      
        <?php include 'navBar.php'; ?>
        <div id="content">
            <legend>Groupe : <?php echo $grp[0]['nameGroup'] ?></legend>
            <table class="table table-bordered">
                <th>Nom d'utilisateur</th>
                <th>Poids</th>
                <?php
                foreach ($grp as $usr) {
                    ?>
                    <tr><?php
                        $user = GetUserByIdUser($usr['idUser']);
                        ?>
                        <td><?php
                            echo $user['username'];
                            ?></td>
                        <td><?php echo $usr['weight'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br/>
            <form  method="post" action='groups.php?idGroup=<?php echo $idGroup; ?>'>
                <fieldset class="form-group">
                    <legend>Ajouter un membre</legend>
                    <label for="inputEmail3" class="col-sm-4 control-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="username" value="" maxlength="16" required="required"><br/><br/>
                    <label for="inputEmail3" class="col-sm-4 control-label">Poids</label>
                    <input type="number" class="form-control" name="weight" value="" maxlength="40" required="required"><br/><br/>
                </fieldset> 
                <fieldset>
                    <legend>Valider</legend>              
                    <input type="submit" class="btn btn-default" name="addUser" value="Ajouter"><br/>
                </fieldset> 
            </form>
        </div>
    </body>
</html>