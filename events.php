<?php
/* Author : Willy Loïc
 */
session_start();
require 'function.inc.php';
$idEvent = "";
$amount = "";
$paymentNature = "";
$idGrp = "";
$groups = [];
if (isset($_GET['idEvent'])) {
    $idEvent = strVerif($_GET['idEvent']);
} else {
    header("location:index.php");
}

if (isConnect() && IsUserInEventById($idEvent, $_SESSION['infoUser']['idUser']) != null) {
    if (isset($_POST['addPayment'])) {
        $amount = (isset($_POST['amount'])) ? strVerif($_POST['amount']) : "";
        $paymentNature = (isset($_POST['paymentNature'])) ? strVerif($_POST['paymentNature']) : "";
        $idCurrency = (isset($_POST['currency'])) ? strVerif($_POST['currency']) : "";
        $idGrp = (isset($_POST['group'])) ? strVerif($_POST['group']) : "";
        if ($amount != "" && $paymentNature != "" && $idCurrency != "") {
            $idPayment = CreateNewPayment($amount, $paymentNature, $idCurrency);
            AddHavePayment($idEvent, $idPayment, $_SESSION['infoUser']['idUser'], $idGrp);
        }
    }
    if (isset($_GET['messageAction']) && isset($_GET['idPayment'])) {
        $action = strVerif($_GET['messageAction']);
        $idPayment = strVerif($_GET['idPayment']);
        if ($action == "delete") {
            deletePayment($idPayment, $idEvent, $_SESSION['infoUser']['idUser']);
            header("events.php?idEvent" . $idEvent);
        }
    }
    $currencies = GetAllCurrencies();
    $payments = GetAllPaymentsByIdEvent($idEvent);
    $event = GetEventById($idEvent);
    $group = GetGroupById($event['idGroup']);
    $groups = GetAllSubGroupById($group['idGroup']);
    $groups[sizeof($groups)] = $group;
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
        <h1><?php echo $event['nameEvent']; ?></h1>
        <h2>Événement du groupe : <?php echo $group['nameGroup']; ?></h2>
        <div id="content">
            <fieldset>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-expanded="true">Payements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview">Vue globale</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                            <legend>Payements de l'événement</legend>
                            <table class="table table-bordered">
                                <th>Nom d'utilisateur</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Nature</th>
                                <th>Monnaie</th>
                                <th>Concerne</th>
                                <?php
                                foreach ($payments as $payment) {
                                    $usr = GetUserByIdUser($payment['idUser']);
                                    $curr = GetCurrencyById($payment['idCurrency']);
                                    $groupPayment = GetGroupById($payment['idGroup']);
                                    ?>
                                    <tr>
                                        <td><?php
                                            echo $usr['username'];
                                            if ($usr['idUser'] == $_SESSION['infoUser']['idUser']) {
                                                $id = "deletePayment" . $payment['idPayment'];
                                                $link = 'events.php?idEvent=' . $idEvent . '&messageAction=delete&idPayment=' . $payment['idPayment'];
                                                ?>
                                                &nbsp;&nbsp;
                                                <a href="" data-toggle="modal" data-target="#<?php echo $id ?>"><img src="./images/deleteButton.png"/></a> 
                                                <?php
                                                AlertMessage($id, $link);
                                            }
                                            ?></td>
                                        <td><?php echo $payment['amount']; ?></td>
                                        <td><?php echo $payment['datePayment'] ?></td>
                                        <td><?php echo $payment['paymentNature'] ?></td>
                                        <td><?php echo $curr['abbvCurrency'] ?></td>
                                        <td><a href='groups.php?idGroup=<?php echo $groupPayment['idGroup']; ?>'><?php echo $groupPayment['nameGroup'] ?></a></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        <fieldset class="form-group">
                            <form  method="post" action='events.php?idEvent=<?php echo $idEvent ?>'>
                                <legend>Ajouter un payment</legend>
                                <label for="inputEmail3" class="col-sm-4 control-label">Montant</label>
                                <input type="number" class="form-control" name="amount" value="" maxlength="16" required="required"><br/><br/>
                                <label for="inputEmail3" class="col-sm-4 control-label">Nature</label>
                                <input type="text" class="form-control" name="paymentNature" value="" maxlength="16" required="required"><br/><br/>
                                <label for="inputEmail3" class="col-sm-4 control-label">Monnaie </label>
                                <select name="currency" class="form-control">
                                    <option value="null"></option>
                                    <?php
                                    foreach ($currencies as $currency) {
                                        echo "<option value=" . $currency['idCurrency'] . ">" . $currency['nameCurrency'] . "</option>";
                                    }
                                    ?>                          
                                </select><br/>
                                <label for="inputEmail3" class="col-sm-4 control-label">Concerne </label>
                                <select name="group" class="form-control">
                                    <option value="null"></option>
                                    <?php
                                    foreach ($groups as $eachGrp) {
                                        echo "<option value=" . $eachGrp['idGroup'] . ">" . $eachGrp['nameGroup'] . "</option>";
                                    }
                                    ?>                          
                                </select> 
                                <br/>
                                <input type="submit" class="btn btn-default" name="addPayment" value="Ajouter un payment"><br/>
                            </form>
                        </fieldset> 
                    </div>
                    <div class="tab-pane fade text-left" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <fieldset class="container">
                            <div class="container">
                                <div class="progress vertical">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                    </div>  
                                </div>
                                <div class="progress vertical">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                    </div>  
                                </div>
                            </div>
                        </fieldset> 
                    </div>
                </div>
            </fieldset>

        </div>
    </body>
</html>