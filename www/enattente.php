<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

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
        <h1 class='titleattente'>En attente de vérification de vos données, Cela peut prendre de tout de suite à jamais !!!!</h1>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>