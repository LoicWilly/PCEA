<?php
    
function UpdateProfil($idUser, $firstname, $lastname) {
    $bdd = connexionDb();
    $sql = ("UPDATE tusers SET firstname = :firstname, lastname = :lastname WHERE idUser= :idUser");
    $requete = $bdd->prepare($sql);
    $requete->execute(array(":idUser" => $idUser, ":firstname" => $firstname, ":lastname" => $lastname));
}

?>