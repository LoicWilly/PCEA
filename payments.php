<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$currencies = GetAllCurrencies();
$payments = GetAllPaymentsByIdUser($_SESSION['infoUser']['idUser']);
if (isConnect()) {
    if (isset($_POST['addPayment'])) {
        $username = (isset($_POST['username'])) ? strVerif($_POST['username']) : "";
        $weight = (isset($_POST['weight'])) ? strVerif($_POST['weight']) : "";
        if ($username != "" && $weight != "") {
            $user = GetUserByUser($username)[0];
            AddUserToGroup($idGroup, $user['idUser'], $weight, 0);
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
            <form  method="post" action='payments.php'>
                <fieldset>
                    <legend>Mes payements</legend>
                    <table class="table table-bordered">
                        <th>Événement</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Nature</th>
                        <th>Monnaie</th>
                        <?php
                        foreach ($payments as $payment) {
                            $event = GetEventById($payment['idEvent']);
                            $curr = GetCurrencyById($payment['idCurrency']);
                            ?>
                          <tr>
                              <td><a href="events.php?idEvent=<?php echo $event['idEvent'] ?>"><?php echo $event['nameEvent']; ?></a></td>
                            <td><?php echo $payment['amount']; ?></td>
                            <td><?php echo $payment['datePayment'] ?></td>
                            <td><?php echo $payment['paymentNature'] ?></td>
                            <td><?php echo $curr['abbvCurrency'] ?></td>
                        </tr>
                            <?php
                        }
                        ?>
                    </table>
                </fieldset>
            </form>
        </div>
    </body>
</html>