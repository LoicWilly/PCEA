<?php

/* Author : Willy Loïc
 */

function isConnect() {
    if (isset($_SESSION["infoUser"])) {
        return ($_SESSION["infoUser"] != null);
    }
    return false;
}

function connexionDb() {
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=pcea", "pceaAdmin", "pceaAdmin");
        $bdd->exec("SET CHARACTER SET utf8");
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}

function Connexion($user, $pwd) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE username = :user AND password = :pwd');
    $reponse->execute(array(":user" => $user, ":pwd" => $pwd));
    return $reponse->fetchAll();
}

function GetUserByUser($username) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE username= :username');
    $reponse->execute(array(":username" => $username));
    return $reponse->fetchAll();
}

function GetUserByIdUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tusers WHERE idUser= :idUser');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetchAll(PDO::FETCH_ASSOC)[0];
}

function strVerif($str){
    return htmlspecialchars(trim($str));
}

function GetGroupById($idGroup) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups, ingroup WHERE tgroups.idGroup= :idGroup');
    $reponse->execute(array(":idGroup" => $idGroup));
    return $reponse->fetchAll(PDO::FETCH_ASSOC);
}

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

function AddUserToGroup($idGroup, $idUser, $weight){
   $bdd = connexionDb();
    $reponse = $bdd->prepare('INSERT INTO `ingroup`(`idGroup`, `idUser`, `weight`) VALUES (:idGroup, :idUser, :weight);');
    $reponse->execute(array(":idGroup" => $idGroup, ":idUser" => $idUser, ":weight" => $weight)); 
}

function GetAllGroupFromUser($idUser) {
    $bdd = connexionDb();
    $reponse = $bdd->prepare('SELECT * FROM tgroups JOIN ingroup ON ingroup.idGroup WHERE idUser = :idUser');
    $reponse->execute(array(":idUser" => $idUser));
    return $reponse->fetchAll();
}

?>
