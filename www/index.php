<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_POST['creer'])){
    if(ISSET($_POST['monnaie'], $_POST['solde']) && !empty($_POST['monnaie']) && !empty($_POST['solde'])){
        $numero = rand(10000000000,99999999999);
        $monnaie = $_POST['monnaie'];
        $solde = $_POST['solde'];

        $sth = $dbh->prepare("INSERT INTO comptes (numero, id_user, id_monnaie, solde) VALUES (?,?,?,?)");
        $sth->execute([$name, $firstName, $email, $number, $date, hash('sha256', $password), 'unverified']);
    }
}

?>

<?php
    $page_title = 'ACCUEIL';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>Mes comptes</h1>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Créer un compte</h2>
            <form method="post">
                <select name="monnaie" id="monnaie">
                    <option value="" class="sous_theme4">Chosir la monnaie</option>
                    <option value="euro">Euro</option>
                    <option value="usd">USD</option>
                    <option value="pessos">Pessos</option>
                    <option value="yen">Yen</option>
                    <option value="ls">LS</option>
                </select>
                <input class="solde" type="number"  name="solde"  id="solde"  placeholder="Solde" required>
                <input class='buttondaccount' type="submit" value="Créér" name="creer" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>