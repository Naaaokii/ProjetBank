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
        <h1 class='titlebanned'>Vous êtes bannis !!!!!!!</h1>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>