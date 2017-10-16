<?php
   
function deleteSubGroup($idGroup){
     $bdd = connexionDb();
    $reponse = $bdd->prepare('DELETE FROM tgroups WHERE idGroup = :idGroup AND idUpperGroup IS NOT NULL');
    if ($reponse->execute(array(":idGroup" => $idGroup))) {
        return $bdd->lastInsertId();
    } else {
        return NULL;
    }
}

function deleteInGroup($idGroup, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('DELETE FROM ingroup WHERE idGroup = :idGroup AND idUser = :idUser');
    if ($reponse->execute(array(":idGroup" => $idGroup, ":idUser" => $idUser))) {
        return $bdd->lastInsertId();
    } else {
        return NULL;
    }
}

function deleteHavePayment($idPayment, $idEvent, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('DELETE FROM havepayment WHERE idPayment = :idPayment AND idEvent = :idEvent AND idUser = :idUser');
    if ($reponse->execute(array(":idPayment" => $idPayment, ":idEvent" => $idEvent, ":idUser" => $idUser))) {
        return $bdd->lastInsertId();
    } else {
        return NULL;
    }
}

function deletePayment($idPayment, $idEvent, $idUser) {
    deleteHavePayment($idPayment, $idEvent, $idUser);
    $bdd = connexionDb();
    $reponse = $bdd->prepare('DELETE FROM tpayments WHERE idPayment = :idPayment');
    if ($reponse->execute(array(":idPayment" => $idPayment))) {
        return $bdd->lastInsertId();
    } else {
        return NULL;
    }
}

?>