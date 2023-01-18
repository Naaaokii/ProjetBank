<section>
    <nav class="navbar">
        <h3 class='titre'>BankADE</h3>
        <div class="divnav">
            <a href="index.php" class="correctlink">Accueil</a>
            <a href="virements.php" class="correctlink">Virement</a>
            <a href="depots.php" class="correctlink">Dépot</a>
            <a href="convertisseur.php" class="correctlink">Convertisseur</a>
            <?php 
            if ($user !== false && $user->role =='admin' || $user->role =='modo') {
                echo ("<a href='gestion.php' class='correctlink'>Gestion<a>"); 
            }
            ?>

            <a href="login.php"><i class="fa-solid fa-user"></i></a>
        </div>
    </nav>
</section>
