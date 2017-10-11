<!-- Author : Willy Loïc -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Accueil</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
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
                            $groups = GetAllGroupFromUser($_SESSION['infoUser']['idUser']);
                            foreach ($groups as $group) {
                                echo "<li><a href=groups.php?idGroup=" . $group["idGroup"] . ">" . $group["nameGroup"] . "</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="payements.php">Mes payements</a></li>
                    <li><a href="createGroup.php">Créer un groupe</a></li>
                    <li><a href="deconnexion.php">Se déconnecter</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>