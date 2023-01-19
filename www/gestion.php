
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
        <?php
        echo "<h2>Select du désespoir</h2>";
            echo "<table id='tabgestion'>";
            $variable = $dbh->prepare('SELECT id,nom,prenom,email FROM users');
            $variable->execute();
            $data = $variable->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Id</th><th>Nom</th><th>Prenom</th><th>Email</th></tr>";
            echo "<tr>".var_dump($data)."</tr>";
            foreach($data as $key => $value){
                $subkey = $value;
                echo "<tr>";
                foreach($subkey as $key2 => $attri){
                        echo "<td>". $attri."</td>";
                }
                echo "</tr>";
            }
            echo '</table>';

        ?>
        <form method="post">
            <input class='button' type="submit" value="Deconnexion" name="deconnexion" class="outbutton"> 
        </form>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>