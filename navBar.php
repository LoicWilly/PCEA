<!-- Author : Willy Loïc -->


<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Accueil</a>
        </div>
        <ul class="nav navbar-nav navbar-right collapse navbar-collapse">
            <?php
            if (!isConnect()) {
                ?>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="inscription.php">S'inscire</a></li>
                <?php
            } else {
                ?>
                <p class="navbar-text">Connecté en tant que <?php echo $_SESSION['infoUser']['username'] ?></p>
                <li><a href="profil.php?username=<?php echo $_SESSION['infoUser']['username'] ?>">Mon profil</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mes groupes <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        $grps = GetAllGroupFromUser($_SESSION['infoUser']['idUser']);
                        foreach ($grps as $grp) {
                            echo "<li><a href=groups.php?idGroup=" . $grp["idGroup"] . ">" . $grp["nameGroup"] . "</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mes Événements <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        $evts = GetAllEventFromUser($_SESSION['infoUser']['idUser']);
                        foreach ($evts as $evt) {
                            echo "<li><a href=events.php?idEvent=" . $evt["idEvent"] . ">" . $evt["nameEvent"] . "</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="payments.php">Mes payements</a></li>
                <li><a href="createGroup.php">Créer un groupe</a></li>
                <li><a href="deconnexion.php">Se déconnecter</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>