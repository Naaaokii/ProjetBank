<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_POST['depot'])){
    if(isset($_POST['numberaccount'], $_POST['solde']) && !empty($_POST['numberaccount']) && !empty($_POST['solde'])){
        
        $numberAccount = $_POST['numberaccount'];
        $soldeDepot = $_POST['solde'];

        $req = $dbh->prepare('SELECT solde FROM comptes WHERE numero = :numero');
        $req->execute(array('numero' => $numberAccount));
        $soldeAccount = $req->fetch();
        $soldeActuelle = $soldeAccount['solde'];

        $soldeTotal = $soldeActuelle + $soldeDepot;
         
        $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = ".$numberAccount);
        $sth->execute(['solde' => $soldeTotal]);
    }
}
?>

<?php
    $page_title = 'DEPOTS';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>DEPOTS</h1>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Faire un dépot</h2>
            <form method="post">
                <input class="numberaccount" type="number"  name="numberaccount"  id="numberaccount"  placeholder="Numéro du compte" required>
                <input class="solde" type="number"  name="solde"  id="solde"  placeholder="Solde" required>
                <input class='buttondaccount' type="submit" value="Déposer" name="depot" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>