<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$events = null;
$payments = null;
$subGroups = [];
if (isset($_GET['idGroup'])) {
    $idGroup = strVerif($_GET['idGroup']);
} else {
    header("location:index.php");
}
if (isset($_POST['addEvent'])) {
    $nameEvent = strVerif($_POST['nameEvent']);
    CreateEvent($nameEvent, $idGroup);
}
if (isConnect() && IsUserInGroupById($idGroup, $_SESSION['infoUser']['idUser']) != null) {
    $events = GetAllEventFromGroup($idGroup);
    foreach ($events as $event) {
        $payments = (GetAllPaymentsByIdEventAndIdGroup($event['idEvent'], $idGroup));
    }
    $group = GetGroupById($idGroup);
    $subGroups = GetAllSubGroupByIdGroupAndIdUser($idGroup, $_SESSION['infoUser']['idUser']);

    if (isset($_POST['addUser'])) {
        $username = (isset($_POST['username'])) ? strVerif($_POST['username']) : "";
        $weight = (isset($_POST['weight'])) ? strVerif($_POST['weight']) : "";

        if ($username != "" && $weight != "") {
            $user = GetUserByUser($username)[0];
            $inGroup = true;
            if (!is_null($group['idUpperGroup'])) {
                $inGroup = (!empty(IsUserInGroupById($group['idUpperGroup'], $user['idUser'])));
            }
            if ($inGroup) {
                AddUserToGroup($idGroup, $user['idUser'], $weight, 0);
                header("location:groups.php?idGroup=" . $idGroup);
            }
        }
    }
    if (isset($_POST["createSubGroup"])) {
        if (isset($_POST["groupname"])) {
            $grpname = strVerif($_POST["groupname"]);
        }
        if (isset($_POST["weight"])) {
            $weight = strVerif($_POST["weight"]);
        }
        if ($grpname != " " && $weight != -1) {
            $idGroupSub = CreateSubGroup($grpname, $idGroup);
            AddUserToGroup($idGroupSub, $_SESSION['infoUser']['idUser'], $weight, 1);
            header("location:index.php");
        }
    }
    if (isset($_GET['messageAction']) && isset($_GET['idUser']) && (IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) || $_SESSION['infoUser']['idUser'] == $_GET['idUser'])) {
        $action = strVerif($_GET['messageAction']);
        $idUser = strVerif($_GET['idUser']);
        if ($action == "remove") {
            if ($subGroups != null) {
                foreach ($subGroups as $subGroup) {
                    deleteInGroup($subGroup['idGroup'], $idUser);
                }
            }
            deleteInGroup($idGroup, $idUser);
            header("location:groups.php?idGroup=" . $idGroup);
        }
    }
} else {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Groupe</title>
        <?php include 'cssInclude.html'; ?>
    </head>
    <body>      
        <?php include 'navBar.php'; ?>
        <div id="content">
            <fieldset>
                <legend>Groupe : <?php echo $group['nameGroup'] ?></legend>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users">Utilisateurs</a>
                    </li>
                    <?php if (is_null($group['idUpperGroup'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events">Événements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="subGroup-tab" data-toggle="tab" href="#subGroup" role="tab" aria-controls="subGroup">Sous-groupes</a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <br/>
                        <legend>Utilisateurs</legend>

                        <table class="table table-bordered">
                            <th>Nom d'utilisateur</th>
                            <th>Poids</th>
                            <tr><?php
                                $user = GetUserByIdUser($group['idUser']);
                                ?>
                                <td><?php ?><a href='profil.php?username=<?php echo $user['username']; ?>'><?php echo $user['username']; ?></a>
                                    <?php
                                    if ($payments == null && IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) && $_SESSION['infoUser']['idUser'] != $user['idUser']) {
                                        $id = "removeUser" . $user['idUser'];
                                        $link = 'groups.php?idGroup=' . $idGroup . '&messageAction=remove&idUser=' . $user['idUser'];
                                        ?>
                                        &nbsp;&nbsp;
                                        <a href="" data-toggle="modal" data-target="#<?php echo $id ?>"><img src="./images/deleteButton.png"/></a> 
                                        <?php
                                        AlertMessage($id, $link);
                                    }
                                    ?></td>
                                <td><?php echo $group['weight'] ?></td>
                            </tr>
                        </table>
                        <?php if (IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) != null) { ?>
                            <form  method="post" action='groups.php?idGroup=<?php echo $idGroup; ?>'>
                                <fieldset class="form-group">
                                    <legend>Ajouter un membre</legend>
                                    <label for="inputEmail3" class="col-sm-4 control-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="username" value="" maxlength="16" required="required"><br/><br/>
                                    <label for="inputEmail3" class="col-sm-4 control-label">Poids</label>
                                    <input type="number" class="form-control" name="weight" value="" maxlength="40" required="required"><br/><br/>
                                    <input type="submit" class="btn btn-default" name="addUser" value="Ajouter un membre"><br/>
                                </fieldset> 
                            </form>
                        <?php } ?>
                    </div>
                    <?php if (is_null($group['idUpperGroup'])) { ?>

                        <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
                            <br/>
                            <legend>Événements du groupe</legend>
                            <table class="table table-bordered">
                                <th>Nom de l'événement</th>
                                <?php
                                foreach ($events as $event) {
                                    ?>
                                    <tr>
                                        <td><?php ?><a href='events.php?idEvent=<?php echo $event['idEvent']; ?>'><?php echo $event['nameEvent']; ?></a>
                                            <?php
                                            if ($payments == null && IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) && $_SESSION['infoUser']['idUser'] != $user['idUser']) {
                                                $id = "removeUser" . $user['idUser'];
                                                $link = 'groups.php?idGroup=' . $idGroup . '&messageAction=remove&idUser=' . $user['idUser'];
                                                ?>
                                                &nbsp;&nbsp;
                                                <a href="" data-toggle="modal" data-target="#<?php echo $id ?>"><img src="./images/deleteButton.png"/></a> 
                                                <?php
                                                AlertMessage($id, $link);
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php if (IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) != null) { ?>

                                <form  method="post" action='groups.php?idGroup=<?php echo $idGroup; ?>'>
                                    <fieldset class="form-group">
                                        <legend>Créer un événement</legend>
                                        <label for="inputEmail3" class="col-sm-4 control-label">Nom de l'événement</label>
                                        <input type="text" class="form-control" name="nameEvent" value="" maxlength="25" required="required"><br/><br/>
                                        <input type="submit" class="btn btn-default" name="addEvent" value="Créer un événement"><br/>
                                    </fieldset> 
                                </form>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="subGroup" role="tabpanel" aria-labelledby="subGroup-tab">
                            <br/>    
                            <legend>Sous-groupes</legend>
                            <table class="table table-bordered">
                                <th>Nom du sous-groupe</th>                       
                                <?php
                                foreach ($subGroups as $subGroup) {
                                    ?>
                                    <tr>
                                        <td><?php ?><a href='groups.php?idGroup=<?php echo $subGroup['idGroup']; ?>'>
                                                <?php echo $subGroup['nameGroup']; ?></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php if (IsUserInGroupLeaderById($idGroup, $_SESSION['infoUser']['idUser']) != null) { ?>
                                <form  method="post" action='groups.php?idGroup=<?php echo $idGroup; ?>'>
                                    <fieldset class="form-group">
                                        <legend>Création d'un sous-groupe</legend>
                                        <label for="inputEmail3" class="col-sm-4 control-label">Nom du groupe</label>
                                        <input type="text" class="form-control" name="groupname" value="" maxlength="16" required="required"><br/><br/>
                                        <label for="inputEmail3" class="col-sm-4 control-label">Poids</label>
                                        <input type="number" class="form-control" name="weight" value="" maxlength="40" required="required"><br/><br/>
                                        <legend>Créer un sous-groupe</legend>              
                                        <input type="submit" class="btn btn-default" name="createSubGroup" value="Créer un groupe"><br/>
                                    </fieldset> 
                                </form>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="dropdown2" role="tabpanel" aria-labelledby="dropdown2-tab">...</div>
                </div>
            </fieldset>
            <br/>
            <?php if (!is_null($group['idUpperGroup'])) { ?>
                <a href="groups.php?idGroup=<?php echo $group['idUpperGroup'] ?>">
                    <button type="button" class="btn btn-default">Retour au groupe de base</button>
                </a>         
                <?php
            }
            $id = "removeUser" . $user['idUser'];
            $link = 'groups.php?idGroup=' . $idGroup . '&messageAction=remove&idUser=' . $user['idUser'];
            ?>
            &nbsp;&nbsp;
            <a href="" data-toggle="modal" data-target="#<?php echo $id ?>">
                <button class="btn btn-danger">Quitter le groupe</button>
            </a> 
            <?php
            AlertMessage($id, $link);
            ?>
        </div>
    </body>
</html>