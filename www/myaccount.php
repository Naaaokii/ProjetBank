<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(ISSET($_POST['deconnexion'])){
    session_destroy();
    header("location:login.php");
}
?>

<?php
    $page_title = 'MON ESPACE';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>Mon compte</h1>
        <?php
        $user_mail = $_SESSION['email'];
        $req = $dbh->prepare('SELECT * FROM users WHERE email = :email');
        $req->execute(array('email' => $user_mail));
        $user = $req->fetch();
        echo "<div>";
        foreach ($user as $key => $value) {
            echo "<p>".$value."</p>";
        }
        echo "</div>";
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