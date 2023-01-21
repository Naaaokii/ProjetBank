
<?php
    $page_title = 'MON ESPACE';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
    require_once __DIR__ . '/../src/init.php';
    require_once __DIR__ . '/../src/class/DbManager.php';

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
            }
        }
    }
?>

    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>Gestion</h1>
        <form method="post" action="">
        <legend id="choixfiltre"><b>Filtres de recherche</b></legend>
            <input type="radio" id="first" class="optioncheck" name="filtre" value="all"/>tous les utilisateurs</input>
            <input type="radio" class="optioncheck" name="filtre" value="unverified"/>les non-verifié</input>
            <input type="radio" class="optioncheck" name="filtre" value="banned"/>les bannis</input>
            <input type="radio" class="optioncheck" name="filtre" value="verified"/>les verifiés</input>
            </br>
            <input type="submit" value="filtrer" name="submit" id="submitfiltre">
        </form>

        
        <?php

        $email = $_SESSION['email'];
        $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
        $sqladmin->execute(array("email" => $email));
        $role = $sqladmin->fetchAll();
        foreach($role as $key => $qui){
            if($qui['role'] !== "admin" && $qui['role'] !== "manager"){
                header('location:index.php');
            }
        }


        $userId = [];
        echo "<h2>Select du désespoir</h2>";
        if (isset($_POST['submit'])) {
            if(!empty($_POST["filtre"])){
                $filtre = $_POST['filtre'];
                try {
                    echo "<table id='tabgestion'>";
                    if ($filtre == 'all'){
                        $filtre = '%';
                    }
                    $variable = $dbh->prepare('SELECT id,nom,prenom,email,role FROM users WHERE role LIKE :role ORDER BY nom');
                    $variable->execute(['role' => $filtre]);
                    $data = $variable->fetchAll(PDO::FETCH_ASSOC);
                    if (empty($data)) {
                        throw new Exception("Aucun résultat trouvé avec les filtres sélectionnés.");
                    }
                    echo "<tr><th>Id</th><th>Nom</th><th>Prenom</th><th>Email</th><th>Role</th><th>Gérer</th></tr>";
                    foreach ($data as $key => $value) {
                        
                        $subkey = $value;
                        echo "<tr>";
                        foreach ($subkey as $key2 => $attri) {
                            echo "<td>" . $attri . "</td>";
                        }
                        $email = $_SESSION['email'];
                        $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
                        $sqladmin->execute(array("email" => $email));
                        $role = $sqladmin->fetchAll();

                        $req = $dbh->prepare('SELECT montant FROM depots WHERE id_user = :id_user AND verif = :verif');
                        $req->execute(array("id_user" => $value['id'], "verif" => 'unverified'));
                        $montant = $req->fetch();

                        $req = $dbh->prepare('SELECT montant FROM retraits WHERE id_user = :id_user AND verif = :verif');
                        $req->execute(array("id_user" => $value['id'], "verif" => 'unverified'));
                        $montantRetrait = $req->fetch();

                        $cpt = 0;
                        foreach($role as $key => $qui){
                            if($qui['role'] !== "admin" ){
                                $cpt = 1;
                            }
                        }
                        if ($cpt == 0){
                            echo '<td ><form method="post" class="formGestion">
                            <select name="gerer" id="gererUsers">
                                <option value="" class="sous_theme4">Gérer</option>
                                <option value="banned">Bannir</option>
                                <option value="verifier">Vérifier</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                                </select>
                                <input class="userhid" type="hidden" value="'.$value['id'].'" name="userhid">
                                <input class="buttonGestion" type="submit" value="Valider" name="valideruser" class="inpbutton">
                            </form>
                            </td></tr>';

                            if ($montant != false){
                                echo '<td ><p>Demande de dépôt de '.$montant['montant'].'
                                    <form method="post" class="formGestion">
                                    <input class="userhid" type="hidden" value="'.$value['id'].'" name="userhid">
                                    <input class="depothid" type="hidden" value="'.$montant['montant'].'" name="depothid">
                                    <input class="buttonGestion" type="submit" value="Valider" name="validerdepot" class="inpbutton">
                                </form>
                                </td></tr>';
                            }else if ($montantRetrait != false){
                                echo '<td ><p>Demande de retrait de '.$montantRetrait['montant'].'
                                    <form method="post" class="formGestion">
                                    <input class="userhid" type="hidden" value="'.$value['id'].'" name="userhid">
                                    <input class="retraithid" type="hidden" value="'.$montantRetrait['montant'].'" name="retraithid">
                                    <input class="buttonGestion" type="submit" value="Valider" name="validerretrait" class="inpbutton">
                                </form>
                                </td></tr>';
                            }
                        }else{
                            echo '<td ><form method="post" class="formGestion">
                            <select name="gerer" id="gererUsers">
                                <option value="" class="sous_theme4">Gérer</option>
                                <option value="banned">Bannir</option>
                                <option value="verified">Vérifier</option>
                                <option value="manager">Manager</option>
                                </select>
                                <input class="userhid" type="hidden" value="'.$value['id'].'" name="userhid">
                                <input class="buttonGestion" type="submit" value="Valider" name="valideruser" class="inpbutton">
                            </form>
                            </td></tr>';

                            if ($montant != false){
                                echo '<td ><p>Demande de dépôt de '.$montant['montant'].'
                                    <form method="post" class="formGestion">
                                    <input class="userhid" type="hidden" value="'.$value['id'].'" name="userhid">
                                    <input class="depothid" type="hidden" value="'.$montant['montant'].'" name="depothid">
                                    <input class="buttonGestion" type="submit" value="Valider" name="validerdepot" class="inpbutton">
                                </form>
                                </td></tr>';
                            }
                        }
                    }
                    echo '</table>';
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }

        if(isset($_POST['valideruser'])){
            if(isset($_POST['gerer'], $_POST['userhid']) && !empty($_POST['gerer'])){
                $idUser = $_POST['userhid'];
                $roleuser = $_POST['gerer'];
                
                $sth = $dbh->prepare("UPDATE users SET role = :role WHERE id = :id");
                $sth->execute(['id' => $idUser,'role' => $roleuser]);
            }
        }

        if(isset($_POST['validerdepot'])){
            if(isset($_POST['depothid'], $_POST['userhid'])){
                $idUser = $_POST['userhid'];
                $montantDepot = $_POST['depothid'];

                $sth = $dbh->prepare("SELECT id_compte FROM depots WHERE id_user = :id_user");
                $sth->execute(['id_user' => $idUser]);
                $idCompte = $sth->fetch();

                $req = $dbh->prepare('SELECT solde FROM comptes WHERE id_cmpt = :id_cmpt');
                $req->execute(array('id_cmpt' => $idCompte['id_compte']));
                $soldeAccount = $req->fetch();
                $soldeActuelle = $soldeAccount['solde'];

                $soldeTotal = $soldeActuelle + $montantDepot;
                
                $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE id_cmpt = :id_cmpt");
                $sth->execute(['solde' => $soldeTotal,'id_cmpt' => $idCompte['id_compte']]);

                $req = $dbh->prepare("UPDATE depots SET verif = :verif WHERE id_user = :id_user AND verif = :verif2");
                $req->execute(['verif' => 'verified','id_user' => $idUser, 'verif2' => 'unverified']);
            }
        }

        if(isset($_POST['validerretrait'])){
            if(isset($_POST['retraithid'], $_POST['userhid'])){
                $idUser = $_POST['userhid'];
                $montantRetrait2 = $_POST['retraithid'];

                $sth = $dbh->prepare("SELECT id_compte FROM depots WHERE id_user = :id_user");
                $sth->execute(['id_user' => $idUser]);
                $idCompte = $sth->fetch();

                $req = $dbh->prepare('SELECT solde FROM comptes WHERE id_cmpt = :id_cmpt');
                $req->execute(array('id_cmpt' => $idCompte['id_compte']));
                $soldeAccount = $req->fetch();
                $soldeActuelle = $soldeAccount['solde'];

                $soldeTotal = $soldeActuelle - $montantRetrait2;
                
                $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE id_cmpt = :id_cmpt");
                $sth->execute(['solde' => $soldeTotal,'id_cmpt' => $idCompte['id_compte']]);

                $req = $dbh->prepare("UPDATE retraits SET verif = :verif WHERE id_user = :id_user AND verif = :verif2");
                $req->execute(['verif' => 'verified','id_user' => $idUser, 'verif2' => 'unverified']);
            }
        }
        ?>
        <form method="post">
            <input class='button' id='decobutton' type="submit" value="Deconnexion" name="deconnexion" class="outbutton"> 
        </form>

        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>