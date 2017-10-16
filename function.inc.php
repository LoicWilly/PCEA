<?php
/* Author : Willy Loïc
 */

include 'selectFunction.inc.php';
include 'insertFunction.inc.php';
include 'updateFunction.inc.php';
include 'deleteFunction.inc.php';

 /* DB connection */

function connexionDb() {
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=pcea", "pceaAdmin", "pceaAdmin");
        $bdd->exec("SET CHARACTER SET utf8");
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}


function strVerif($str){
    return htmlspecialchars(trim($str));
}

function deleteUserInSubGroupAndSubGroup($idGroup){
    
}

function isConnect() {
    if (isset($_SESSION["infoUser"])) {
        return ($_SESSION["infoUser"] != null);
    }
    return false;
}

function AlertMessage($id, $link) {
    echo '<div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Supprimer ?</h4>
                        </div>
                        <div class="modal-body">
                            Attention la suppression est irréversible ! Continuer ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                            <a href="' . $link . '"><button type="button" class="btn btn-primary">Oui</button></a>
                        </div>
                    </div>
                </div>
            </div>';
}

?>
