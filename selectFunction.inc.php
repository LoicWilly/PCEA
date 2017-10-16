<?php

/* SELECT   */

/* users */

function Connexion($user, $pwd) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE username = :user AND password = :pwd');
    $reponse->execute(array(":user" => $user, ":pwd" => $pwd));
    return $reponse->fetch(PDO::FETCH_ASSOC);
}

function GetUserByUser($username) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE username= :username');
    $reponse->execute(array(":username" => $username));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetUserByIdUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE idUser= :idUser');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetch(PDO::FETCH_ASSOC);
}

/*  Group  */

function GetGroupById($idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups JOIN ingroup ON tgroups.idGroup = ingroup.idGroup WHERE tgroups.idGroup = :idGroup');
    $reponse->execute(array(":idGroup" => $idGroup));
    return $reponse->fetch(PDO::FETCH_ASSOC);
}

function GetAllSubGroupById($idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups JOIN ingroup ON tgroups.idGroup = ingroup.idGroup WHERE tgroups.idUpperGroup = :idGroup GROUP BY tgroups.idGroup');
    $reponse->execute(array(":idGroup" => $idGroup));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllSubGroupByIdGroupAndIdUser($idGroup, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups JOIN ingroup ON tgroups.idGroup = ingroup.idGroup WHERE tgroups.idUpperGroup = :idGroup AND ingroup.idUser = :idUser');
    $reponse->execute(array(":idGroup" => $idGroup,":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function IsUserInGroupById($idGroup, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM inGroup WHERE inGroup.idGroup = :idGroup AND idUser = :idUser');
    $reponse->execute(array(":idGroup" => $idGroup, ":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}


function IsUserInGroupLeaderById($idGroup, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups, ingroup WHERE tgroups.idGroup = :idGroup AND idUser = :idUser AND leader = 1');
    $reponse->execute(array(":idGroup" => $idGroup, ":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}


function GetAllGroupFromUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups JOIN ingroup ON tgroups.idGroup = ingroup.idGroup WHERE idUser = :idUser AND idUpperGroup IS NULL');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

/* event   */

function GetEventById($idEvent) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tevents WHERE idEvent = :idEvent');
    $reponse->execute(array(":idEvent" => $idEvent));
    return $reponse->fetch(PDO::FETCH_ASSOC);
}

function IsUserInEventById($idEvent, $idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tevents JOIN tgroups ON tgroups.idGroup JOIN inGroup ON ingroup.idGroup WHERE tevents.idEvent = :idEvent AND idUser = :idUser');
    $reponse->execute(array(":idEvent" => $idEvent, ":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllEventFromUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tevents JOIN ingroup ON ingroup.idGroup = tevents.idGroup WHERE idUser = :idUser');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllEventFromGroup($idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT distinct tevents.idGroup, tevents.idEvent, tevents.nameEvent FROM tevents JOIN ingroup ON ingroup.idGroup = tevents.idGroup WHERE ingroup.idGroup = :idGroup');
    $reponse->execute(array(":idGroup" => $idGroup));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

/* currency  */

function GetCurrencyById($idCurrency) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tcurrencies WHERE idCurrency = :idCurrency');
    $reponse->execute(array(":idCurrency" => $idCurrency));
    return $reponse->fetch(PDO::FETCH_ASSOC);
}


function GetAllCurrencies() {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tcurrencies');
    $reponse->execute();
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

/*  payment  */

function GetAllPaymentsByIdUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tpayments JOIN havepayment ON havepayment.idPayment = tpayments.idPayment WHERE idUser = :idUser');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllPaymentsByIdEventAndIdGroup($idEvent, $idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tevents, tpayments JOIN havepayment ON havepayment.idPayment = tpayments.idPayment WHERE havepayment.idEvent = :idEvent AND tevents.idGroup = :idGroup');
    $reponse->execute(array(":idEvent" => $idEvent, ":idGroup" => $idGroup));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

function GetAllPaymentsByIdEvent($idEvent) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tpayments JOIN havepayment ON havepayment.idPayment = tpayments.idPayment WHERE havepayment.idEvent = :idEvent');
    $reponse->execute(array(":idEvent" => $idEvent));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

?>