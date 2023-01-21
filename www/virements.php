<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(empty($_SESSION['email'])){
    header("location:login.php");
}else{
    $email = $_SESSION['email'];
    $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
    $sqladmin->execute(array("email" => $email));
    $role = $sqladmin->fetchAll();
    foreach($role as $key => $qui){
        if($qui['role'] == "banned" ){
            header('location:register.php');
        }else if ($qui['role'] == "unverified" ){
            header("location:enattente.php");
        }
    }
}

if(isset($_POST['virement'])){
    if(isset($_POST['accountexpediteur'], $_POST['accountdestinataire'], $_POST['solde']) 
    && !empty($_POST['accountexpediteur']) && !empty($_POST['accountdestinataire']) && !empty($_POST['solde'])){

        $numberExpediteur = $_POST['accountexpediteur'];
        $numberDestinataire = $_POST['accountdestinataire'];
        $soldeDepot = $_POST['solde'];
        
        // Récupérer l'id de l'utilisateur connecté
        $mail = $_SESSION['email'];
        $req = $dbh->prepare('SELECT id FROM users WHERE email = :email');
        $req->execute(array('email' => $mail));
        $user = $req->fetch();
        $idUser = $user['id'];

        // Récupérer l'id_user par rapport au compte
        $sth = $dbh->prepare('SELECT id_user FROM comptes WHERE numero = :numero0');
        $sth->execute(array('numero0' => $numberExpediteur));
        $user = $sth->fetch();
        $userId = $user['id_user'];

        // Si le numero de compte de l'expediteur est bien celui de la personne connecté
        if ($idUser == $userId){

            // Récupérer la solde actuelle de l'expediteur
            $req = $dbh->prepare('SELECT id_cmpt, solde FROM comptes WHERE numero = :numero1');
            $req->execute(array('numero1' => $numberExpediteur));
            $resultatComptes = $req->fetch();
            $soldeActuelleExpediteur = $resultatComptes['solde'];
            $idExpediteur = $resultatComptes['id_cmpt'];

            // Récupérer la solde actuelle du destinataire
            $sth = $dbh->prepare('SELECT id_cmpt, solde FROM comptes WHERE numero = :numero2');
            $sth->execute(array('numero2' => $numberDestinataire));
            $soldeAccountDestinataire = $sth->fetch();
            $soldeActuelleDestinataire = $soldeAccountDestinataire['solde'];
            $idDestinataire = $resultatComptes['id_cmpt'];

            $sth = $dbh->prepare('SELECT id_monaie FROM comptes WHERE numero = :numero1');
            $sth->execute(array('numero1' => $numberExpediteur));
            $user = $sth->fetch();
            $monaieId = $user['id_monaie'];

            if ($soldeActuelleExpediteur >= $soldeDepot){

                // Nouvelle solde expediteur après avoir retiré la somme
                $soldeTotalExpediteur = $soldeActuelleExpediteur - $soldeDepot;
             
                $req = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = :numero");
                $req->execute(['solde' => $soldeTotalExpediteur, 'numero' => $numberExpediteur]);
    
    
                // Nouvelle solde destinataire après avoir ajouté la somme
                $soldeTotalDestinataire = $soldeActuelleDestinataire + $soldeDepot;
    
                $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = :numero");
                $sth->execute(['solde' => $soldeTotalDestinataire, 'numero' => $numberDestinataire]);

                $req = $dbh->prepare("INSERT INTO transactions(id_compte_expediteur, montant, id_monaie, date, num_compte_destinataire, num_compte_expediteur, id_user)  VALUES (?,?,?,NOW(),?,?,?)");
                $req->execute([$idExpediteur, $soldeDepot, $monaieId, $numberDestinataire, $numberExpediteur, $idUser]);
            }else{
                echo "T'as pas assez de thunes loser";
            }  
        }else{
            echo 'Votre numéro de compte est invalide';
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
        <section class="virementsaffiche">
            <?php
                try {
                    $mail = $_SESSION['email'];
                    $req = $dbh->prepare('SELECT id FROM users WHERE email = :email');
                    $req->execute(array('email' => $mail));
                    $user = $req->fetch();
                    $idUser = $user['id'];
                    echo "<table id='tabgestion'>";
                    $variable = $dbh->prepare('SELECT id, id_compte_expediteur, montant, id_monaie, date, num_compte_destinataire, num_compte_expediteur, id_user FROM transactions WHERE id_user = :id_user ORDER BY date');
                    $variable->execute(['id_user' => $idUser]);
                    $data = $variable->fetchAll(PDO::FETCH_ASSOC);
                    $cpt = 0;
                    if (empty($data)) {
                        throw new Exception("Aucun résultat trouvé avec les filtres sélectionnés.");
                    }
                    echo "<tr><th>Id</th><th>Id du compte expediteur</th><th>Montant</th><th>Id monaie</th><th>Date</th><th>Numéro du compte destinataire</th><th>Numéro du compte expediteur</th><th>Id user</th></tr>";
                    foreach ($data as $key => $value) {
                        if ($cpt < 10){
                            $cpt += 1;
                            $subkey = $value;
                            echo "<tr>";
                            foreach ($subkey as $key2 => $attri) {
                                echo "<td>" . $attri . "</td>";
                            }
                        }     
                    }
                    echo '</table>';
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            ?>
        </section>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>