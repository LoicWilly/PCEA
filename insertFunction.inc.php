<?php

/*  INSERT  */

function AddUser($username, $pwd, $firstname, $lastname) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `tusers`(`username`, `password`, `firstname`, `lastname`) VALUES (:username, :pwd, :firstname, :lastname);');
    $reponse->execute(array(":username" => $username, ":pwd" => $pwd, ":firstname" => $firstname, ":lastname" => $lastname));
}

function CreateGroup($nameGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `tgroups`(`nameGroup`) VALUES (:nameGroup);');
    $reponse->execute(array(":nameGroup" => $nameGroup));
    return $bdd->lastInsertId();
}

function CreateSubGroup($nameGroup, $idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `tgroups`(`nameGroup`,`idUpperGroup`) VALUES (:nameGroup, :idGroup);');
    $reponse->execute(array(":nameGroup" => $nameGroup, ":idGroup" => $idGroup));
    return $bdd->lastInsertId();
}

function CreateEvent($nameEvent, $idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `tevents`(`nameEvent`, `idGroup`) VALUES (:nameEvent, :idGroup);');
    $reponse->execute(array(":nameEvent" => $nameEvent, ":idGroup" => $idGroup));
    return $bdd->lastInsertId();
}

function CreateNewPayment($amount, $nature, $idCurrency) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare("INSERT INTO `tpayments`(`amount`, `datePayment`, `paymentNature`, `idCurrency`) VALUES (:amount, CURRENT_TIMESTAMP() , :nature, :idCurrency);");
    $reponse->execute(array(":amount" => $amount,":nature" => $nature,":idCurrency" => $idCurrency));
    return $bdd->lastInsertId();
}

function AddHavePayment($idEvent, $idPayment, $idUser, $idGroup){
    $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `havepayment`(`idEvent`, `idPayment`, `idUser`, `idGroup`) VALUES (:idEvent, :idPayment , :idUser, :idGroup);');
    $reponse->execute(array(":idEvent" => $idEvent, ":idPayment" => $idPayment, ":idUser" => $idUser, ":idGroup" => $idGroup));
    return $bdd->lastInsertId();
}

function AddUserToGroup($idGroup, $idUser, $weight, $leader){
   $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `ingroup`(`idGroup`, `idUser`, `weight`, `leader`) VALUES (:idGroup, :idUser, :weight, :leader);');
    $reponse->execute(array(":idGroup" => $idGroup, ":idUser" => $idUser, ":weight" => $weight, ":leader" => $leader)); 
}

?>