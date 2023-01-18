<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_POST['virement'])){
    if(isset($_POST['accountexpediteur'], $_POST['accountdestinataire'], $_POST['solde']) 
    && !empty($_POST['accountexpediteur']) && !empty($_POST['accountdestinataire']) && !empty($_POST['solde'])){
        
        $numberExpediteur = $_POST['accountexpediteur'];
        $numberDestinataire = $_POST['accountdestinataire'];
        $soldeDepot = $_POST['solde'];

        $req = $dbh->prepare('SELECT solde FROM comptes WHERE numero = :numero1');
        $req->execute(array('numero1' => $numberExpediteur));
        $soldeAccountExpediteur = $req->fetch();
        $soldeActuelleExpediteur = $soldeAccountExpediteur['solde'];

        
        $sth = $dbh->prepare('SELECT solde FROM comptes WHERE numero = :numero2');
        $sth->execute(array('numero2' => $numberDestinataire));
        $soldeAccountDestinataire = $sth->fetch();
        $soldeActuelleDestinataire = $soldeAccountDestinataire['solde'];

        if ($soldeActuelleExpediteur >= $soldeDepot){
            $soldeTotalExpediteur = $soldeActuelleExpediteur - $soldeDepot;
         
            $req = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = ".$numberExpediteur);
            $req->execute(['solde' => $soldeTotalExpediteur]);



            $soldeTotalDestinataire = $soldeActuelleDestinataire + $soldeDepot;

            $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = ".$numberDestinataire);
            $sth->execute(['solde' => $soldeTotalDestinataire]);
        }else{
            echo "T'as pas assez de thunes loser";
        }    
    }
}
?>

<?php
    $page_title = 'VIREMENTS';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>VIREMENTS</h1>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Faire un virement</h2>
            <form method="post">
                <input class="numberaccount" type="number"  name="accountexpediteur"  id="numberaccount"  placeholder="Numéro de votre compte" required>
                <input class="numberaccount" type="number"  name="accountdestinataire"  id="numberaccount"  placeholder="Numéro de compte du destinataire" required>
                <input class="solde" type="number"  name="solde"  id="solde"  placeholder="Solde" required>
                <input class='buttonvirement' type="submit" value="Valider" name="virement" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>