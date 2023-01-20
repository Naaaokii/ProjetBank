
<?php
    $page_title = 'MON ESPACE';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
    require_once __DIR__ . '/../src/init.php';
    require_once __DIR__ . '/../src/class/DbManager.php';
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
            <input type="radio" id="first" class="optioncheck" name="filtre[]" value=""/>tous les utilisateurs</input>
            <input type="radio" class="optioncheck" name="filtre" value="WHERE role = 'unverified'"/>les non-verifié</input>
            <input type="radio" class="optioncheck" name="filtre" value="WHERE role = 'banned'"/>les bannis</input>
            <input type="radio" class="optioncheck" name="filtre" value="WHERE role = 'verified'"/>les verifiés</input>
            </br>
            <input type="submit" value="filtrer" name="submit" id="submitfiltre">
        </form>

        
        <?php
        echo "<h2>Select du désespoir</h2>";
        if (isset($_POST['submit'])) {
            if(!empty($_POST["filtre"])){
                $filtre = $_POST['filtre'];
                try {
                    echo "<table id='tabgestion'>";
                    $variable = $dbh->prepare('SELECT id,nom,prenom,email,role FROM users '.$filtre.' ORDER BY nom');
                    $variable->execute();
                    $data = $variable->fetchAll(PDO::FETCH_ASSOC);
                    if (empty($data)) {
                        throw new Exception("Aucun résultat trouvé avec les filtres sélectionnés.");
                    }
                    echo "<tr><th>Id</th><th>Nom</th><th>Prenom</th><th>Email</th><th>Role</th><th>Gérer</th></tr>";
                    $ct = 1;
                    foreach ($data as $key => $value) {
                        $subkey = $value;
                        echo "<tr>";
                        foreach ($subkey as $key2 => $attri) {
                            echo "<td>" . $attri . "</td>";
                        }
                        echo '<td ><form method="post" class="formGestion">
                            <select name="gerer" id="gererUsers">
                                <option value="" class="sous_theme4">Gérer</option>
                                <option value="banned">Bannir</option>
                                <option value="verifier">Vérifier</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </form>
                        <input class="buttonGestion" type="submit" value="Valider" name="creer" class="inpbutton"></td></tr>';
                    }
                    echo '</table>';
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        ?>
        <form method="post">
            <input class='validerall' type="submit" value="Tout valider" name="validerall">
            <input class='button' id='decobutton' type="submit" value="Deconnexion" name="deconnexion" class="outbutton"> 
        </form>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>