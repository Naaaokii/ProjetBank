<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION
if (isset($_POST['creer'])) {
    if (isset($_POST['monnaie'], $_POST['solde']) && !empty($_POST['monnaie']) && !empty($_POST['solde'])) {

        $mail = $_SESSION['email'];
        $req = $dbh->prepare('SELECT id FROM users WHERE email = :email');
        $req->execute(array('email' => $mail));
        $user = $req->fetch();
        $idUser = $user['id'];
        var_dump($idUser);

        $nom_monnaie = $_POST['monnaie'];
        $sth = $dbh->prepare('SELECT id_Monnaie FROM monnaies WHERE nom = :nom');
        $sth->execute(array('nom' => $nom_monnaie));
        $idMonnaie = $sth->fetch();
        var_dump($idMonnaie);
        $monnaie = $idMonnaie["id_Monnaie"];

        $numero = rand(10000000000, 99999999999);

        $solde = $_POST['solde'];

        $sth = $dbh->prepare("INSERT INTO comptes (numero, id_user, id_monnaie, solde) VALUES (?,?,?,?)");
        $sth->execute([$numero, $idUser, $monnaie, $solde]);
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
                    <option value="pesos">Pesos</option>
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