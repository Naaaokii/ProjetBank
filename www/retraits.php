<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_POST['retrait'])){
    if(isset($_POST['numberaccount'], $_POST['solde']) && !empty($_POST['numberaccount']) && !empty($_POST['solde'])){
        
        $numberAccount = $_POST['numberaccount'];
        $soldeDepot = $_POST['solde'];

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

            $req = $dbh->prepare('SELECT solde, id_monaie FROM comptes WHERE numero = :numero');
            $req->execute(array('numero' => $numberAccount));
            $monaieId = $req->fetch();
            $soldeActuelle = $monaieId['solde'];
            $idMonaie = $monaieId['id_monaie'];

            $sth = $dbh->prepare('SELECT nom FROM monaies WHERE id_monaie = :id_monaie');
            $sth->execute(array('id_monaie' => $idMonaie));
            $monaie = $sth->fetch();
            $nomMonaie = $monaie['nom'];

            if ($soldeActuelle > $soldeDepot){
                $soldeTotal = $soldeActuelle - $soldeDepot;
            
                $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = :numero");
                $sth->execute(['solde' => $soldeTotal, 'numero' => $numberAccount]);

                echo "Vous avez bien retiré ".$soldeDepot." ".$nomMonaie.", il vous reste ".$soldeTotal." ".$nomMonaie;
            }else{
                echo "T'as pas assez de thunes loser";
            }  
        }else{
            echo 'Numéro de compte invalide';
        }
    }
}
?>

<?php
    $page_title = 'RETRAITS';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>RETRAITS</h1>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Retirer de l'argent</h2>
            <form method="post">
                <input class="numberaccount" type="number"  name="numberaccount"  id="numberaccount"  placeholder="Numéro du compte" required>
                <input class="solde" type="number"  name="solde"  id="solde"  placeholder="Solde" required>
                <input class='buttondaccount' type="submit" value="Retirer" name="retrait" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>