<?php
$user = "root";
$pass = "root";
try{
$dbh = new PDO('mysql:host=localhost;dbname=bankADE', $user, $pass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "PDO error".$e->getMessage();
    die();
}
?>