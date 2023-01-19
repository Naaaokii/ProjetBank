<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_POST['convertir'])){
    if(isset($_POST['numberaccount'], $_POST['monnaie']) && !empty($_POST['numberaccount']) && !empty($_POST['monnaie'])){
        
        $numberAccount = $_POST['numberaccount'];
        $monaie = $_POST['monnaie'];

        // Récupérer l'id de l'utilisateur connecté
        $mail = $_SESSION['email'];
        $req = $dbh->prepare('SELECT id FROM users WHERE email = :email');
        $req->execute(array('email' => $mail));
        $user = $req->fetch();
        $idUser = $user['id'];

        // Récupérer l'id_user par rapport au compte
        $sth = $dbh->prepare('SELECT id_user FROM comptes WHERE numero = :numero0');
        $sth->execute(array('numero0' => $numberAccount));
        $user = $sth->fetch();
        $userId = $user['id_user'];

        // Si le numero de compte de l'expediteur est bien celui de la personne connecté
        if ($idUser == $userId){

            $req = $dbh->prepare('SELECT id_monaie, solde FROM comptes WHERE numero = :numero');
            $req->execute(array('numero' => $numberAccount));
            $monaieId = $req->fetch();
            $idMonaieActuelle = $monaieId['id_monaie'];
            $soldeActuelle = $monaieId['solde'];


            $req = $dbh->prepare('SELECT id_monaie, valeur FROM monaies WHERE nom = :nom');
            $req->execute(array('nom' => $monaie));
            $typeMonaie = $req->fetch();
            $idMonaie = $typeMonaie['id_monaie'];
            $valeurFutur = $typeMonaie['valeur'];

            $req = $dbh->prepare('SELECT valeur FROM monaies WHERE id_monaie = :id_monaie');
            $req->execute(array('id_monaie' => $idMonaieActuelle));
            $typeMonaie = $req->fetch();
            $valeur = $typeMonaie['valeur'];

            if ($idMonaieActuelle == 3){
                $soldeTotal = $soldeActuelle * $valeur;
            }else{
                $soldeTotal = $soldeActuelle / $valeur;
                if ($idMonaie != 3){
                    $soldeTotal = $soldeTotal * $valeurFutur;
                }
            }
            $sth = $dbh->prepare("UPDATE comptes SET solde = :solde, id_monaie = :id_monaie WHERE numero = ".$numberAccount);
            $sth->execute(['solde' => $soldeTotal, 'id_monaie' => $idMonaie]);
            
        }else{
            echo 'Numéro de compte invalide';
        }
    }
}
?>

<?php
    $page_title = 'CONVERTISSEUR';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>Convertisseur</h1>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Créer un compte</h2>
            <form method="post">
                <select name="monnaie" id="monnaie">
                    <option value="" class="sous_theme4">Chosir la monnaie</option>
                    <option value="euro">Euro</option>
                    <option value="usd">USD</option>
                    <option value="pesos">Pesos</option>
                    <option value="yen">Yen</option>
                    <option value="ls">LS</option>
                </select>
                <input class="numberaccount" type="number"  name="numberaccount"  id="numberaccount"  placeholder="Numéro du compte" required>
                <input class='buttondaccount' type="submit" value="Convertir" name="convertir" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>